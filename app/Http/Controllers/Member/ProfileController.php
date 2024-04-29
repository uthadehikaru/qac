<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $data['educations'] = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'];
        $member = Auth::user()->member;

        $province_id = 0;
        $regency_id = 0;
        $district_id = 0;
        $village_id = $member->village_id;
        if ($village_id > 0) {
            $address = DB::table('villages')
                ->select('province_id', 'regency_id', 'district_id')
                ->join('districts', 'districts.id', 'villages.district_id')
                ->join('regencies', 'regencies.id', 'districts.regency_id')
                ->join('provinces', 'provinces.id', 'regencies.province_id')
                ->where('villages.id', $village_id)
                ->first();
            if ($address) {
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
        $data['regencies'] = DB::table('regencies')->where('province_id', $province_id)->orderBy('name')->get();
        $data['districts'] = DB::table('districts')->where('regency_id', $regency_id)->orderBy('name')->get();
        $data['villages'] = DB::table('villages')->where('district_id', $district_id)->orderBy('name')->get();

        return view('member.profile', $data);
    }

    public function verify()
    {
        return 'verified';
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:members,phone,'.Auth::user()->member->id.'|min:8',
            'gender' => 'required|in:pria,wanita',
            'address' => 'required|min:10',
            'village_id' => 'required|exists:villages,id',
            'zipcode' => 'required',
            'profesi' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'is_notify' => '',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->is_notify = $request->is_notify;
        $user->save();

        $member = $user->member;
        $member->full_name = $request->full_name;
        $member->phone = $request->phone;
        $member->gender = $request->gender;
        $member->address = $request->address;
        $member->village_id = $request->village_id;
        $member->zipcode = $request->zipcode;
        $member->instagram = $request->instagram;
        $member->profesi = $request->profesi;
        $member->pendidikan = $request->pendidikan;
        $member->save();

        return back()->with('status', 'Profile updated successfully');
    }
}
