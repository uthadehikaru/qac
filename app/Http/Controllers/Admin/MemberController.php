<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Member;
use App\Models\MemberBatch;
use DataTables;
use Hash;
use Str;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Member::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                        return $row->created_at->format('d-M-Y');
                    })
                    ->addColumn('name', function($row){
                        return $row->user->name;
                    })
                    ->addColumn('action', function($row){
                            $btn = '<a href="'.route('admin.members.show', $row->id).'" class="text-blue-500">Detail</a>';
                            $btn .= '<a href="'.route('admin.members.edit', $row->id).'" class="ml-3 text-yellow-500">Edit</a>';
                            $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin/member-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['member'] = null;
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:members,phone|min:8',
            'gender' => 'required|in:pria,wanita',
            'address' => '',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make(Str::random(8));
        $user->save();

        $member = new Member();
        $member->user_id = $user->id;
        $member->phone = $request->phone;
        $member->gender = $request->gender;
        $member->address = $request->address;
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
        if ($request->ajax()) {
            $data = MemberBatch::select('*')->where('member_id',$id);
            return Datatables::of($data)
                    ->addColumn('batch_id', function($row){
                        return $row->batch->name;
                    })
                    ->editColumn('approved_at',function($row){
                        return $row->approved_at?'Approved at '.$row->approved_at->format('d-M-Y H:i'):'Not Approved';
                    })
                    ->addColumn('action', function($row){
                        $btn = '';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $data['member'] = Member::find($id);
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
        $data['member'] = Member::find($id);
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$member->user_id,
            'phone' => 'required|numeric|unique:members,phone,'.$member->id.'|min:8',
            'gender' => 'required|in:pria,wanita',
            'address' => '',
        ]);

        $user = $member->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $member->phone = $request->phone;
        $member->gender = $request->gender;
        $member->address = $request->address;
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
}
