<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompletePhoneController extends Controller
{
    /**
     * Show the phone number form.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create()
    {
        if (! Auth::user()->needsPhoneNumber()) {
            return redirect()->intended(route('home'));
        }

        return view('auth.complete-phone');
    }

    /**
     * Store the phone number and continue.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $member = $request->user()->member;

        $request->validate([
            'phone' => 'required|numeric|unique:members,phone,'.$member->id.'|min:8',
        ]);

        $member->phone = $request->phone;
        $member->save();

        return redirect()->intended(route('home'))->with('status', 'Nomor telepon berhasil disimpan');
    }
}
