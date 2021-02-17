<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use App\Models\Batch;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data['batches'] = Batch::where('registration_start_at', '<=', date('Y-m-d'))
        ->where('registration_end_at', '>=', date('Y-m-d'))
        ->get();
        return view('auth.register', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|numeric|unique:members|min:8',
            'gender' => 'required|in:pria,wanita',
            'batch_id' => 'required',
        ]);

        DB::beginTransaction();

        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
        ]));

        $member = Member::create([
            'user_id'=> $user->id,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);

        $member->batches()->attach($request->batch_id);

        event(new Registered($user));

        DB::commit();

        return redirect(RouteServiceProvider::HOME);
    }
}
