<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\MemberBatch;
use Hash;
use Str;
use DB;
use Carbon\Carbon;
use App\DataTables\MemberDataTable;
use App\Notifications\MemberResetPassword;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MemberDataTable $dataTable)
    {
        $data['title'] = "Data Anggota";
        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['member'] = null;
        $data['educations'] = ['SD','SMP', 'SMA', "D3", "S1", "S2", "S3"];

        $data['provinces'] = DB::table('provinces')->orderBy('name')->get();
        $data['regencies'] = [];
        $data['districts'] = [];
        $data['villages'] = [];

        return view('admin.member-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:members,phone|min:8',
            'gender' => 'required|in:pria,wanita',
            'address' => '',
            'city' => '',
            'instagram' => '',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make(Str::random(8));
        $user->save();

        $member = new Member();
        $member->user_id = $user->id;
        $member->full_name = $request->full_name;
        $member->phone = $request->phone;
        $member->gender = $request->gender;
        $member->address = $request->address;
        $member->city = $request->city;
        $member->instagram = $request->instagram;
        $member->village_id = $request->village_id;
        $member->zipcode = $request->zipcode;
        $member->save();

        return redirect()->route('admin.members.index')->with('status','Member created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $member = Member::with('batches')->find($id);
        $data['member'] = $member;
        return view('admin.member-detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Member::find($id);
        $data['educations'] = ['SD','SMP', 'SMA', "D3", "S1", "S2", "S3"];

        $province_id = 0;
        $regency_id = 0;
        $district_id = 0;
        $village_id = $member->village_id;
        if($village_id>0){
            $address = DB::table('villages')
                ->select('province_id','regency_id','district_id')
                ->join('districts','districts.id','villages.district_id')
                ->join('regencies','regencies.id','districts.regency_id')
                ->join('provinces','provinces.id','regencies.province_id')
                ->where('villages.id',$village_id)
                ->first();
            if($address){
                $province_id = $address->province_id;
                $regency_id = $address->regency_id;
                $district_id = $address->district_id;
            }
        }
        $data['province_id'] = $province_id;
        $data['regency_id'] = $regency_id;
        $data['district_id'] = $district_id;
        $data['village_id'] = $village_id;

        $data['provinces'] = DB::table('provinces')->orderBy('name')->get();
        $data['regencies'] = DB::table('regencies')->where('province_id',$province_id)->orderBy('name')->get();
        $data['districts'] = DB::table('districts')->where('regency_id',$regency_id)->orderBy('name')->get();
        $data['villages'] = DB::table('villages')->where('district_id',$district_id)->orderBy('name')->get();
        
        $data['member'] = $member;
        return view('admin.member-form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $member = Member::find($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$member->user_id,
            'phone' => 'required|numeric|unique:members,phone,'.$member->id.'|min:8',
            'gender' => 'required|in:pria,wanita',
            'village_id' => '',
            'city' => '',
            'instagram' => '',
        ]);

        $user = $member->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $member->full_name = $request->full_name;
        $member->phone = $request->phone;
        $member->gender = $request->gender;
        $member->address = $request->address;
        $member->city = $request->city;
        $member->instagram = $request->instagram;
        $member->village_id = $request->village_id;
        $member->zipcode = $request->zipcode;
        $member->save();

        return redirect()->route('admin.members.index')->with('status','Member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        $user = $member->user;
        $member->delete();
        $user->delete();
        return response()->json(['status'=>'Deleted Successfully']);
    }

    public function verify($user_id)
    {
        $user = User::find($user_id);
        $user->email_verified_at = Carbon::now();
        $user->save();
        return back()->with('message','Berhasil diverifikasi');
    }

    public function reset($user_id)
    {
        $user = User::find($user_id);
        $pass = Str::random(6);
        $user->password = Hash::make($pass);
        $user->save();
        $user->notify(new MemberResetPassword($pass));
        $message = 'Berhasil mereset kata sandi menjadi '.$pass;
        return back()->with('message',$message);
    }
}
