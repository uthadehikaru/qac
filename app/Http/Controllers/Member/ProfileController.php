<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('member.profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:members,phone,'.Auth::user()->member->id.'|min:8',
            'gender' => 'required|in:pria,wanita',
            'address' => '',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        $member = $user->member;
        $member->phone = $request->phone;
        $member->gender = $request->gender;
        $member->address = $request->address;
        $member->save();

        return back()->with('status','Profile updated successfully');
    }
}
