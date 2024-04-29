<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function index()
    {
        return view('member.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            're_password' => 'required|string|min:8|same:new_password',
        ]);

        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return back()->with('status', 'Password berhasil diperbaharui');
        } else {
            return back()->with('error', 'Password Lama tidak cocok');
        }

    }
}
