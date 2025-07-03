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

        return back()->with('status', 'Profil berhasil diperbarui');
    }
}
