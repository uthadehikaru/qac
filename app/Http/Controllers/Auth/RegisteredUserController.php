<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Member;
use App\Models\Queue;
use App\Models\User;
use App\Notifications\AdminWaitinglist;
use App\Notifications\BatchRegistration;
use App\Notifications\MemberBatchRegistration;
use App\Notifications\MemberWaitinglist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $data['educations'] = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'];
        $data['batch'] = $data['course'] = $data['sessions'] = null;
        $data['provinces'] = DB::table('provinces')->orderBy('name')->get();

        $course = Course::find($request->course_id);
        $data['course'] = $course;
        $batch = $course->batches()->open()->first();

        if ($course->level > 1) {
            if ($batch) {
                return redirect()->route('member.batch.detail', $batch->id);
            } else {
                return redirect()->route('member.waitinglist', $course->id);
            }
        }

        if ($batch && $batch->is_open) {
            $data['batch'] = $batch;
            $data['sessions'] = $batch->sessions ? explode(',', $batch->sessions) : false;
        }

        return view('auth.register', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|numeric|unique:members|min:8',
            'gender' => 'required|in:pria,wanita',
            'session' => 'sometimes',
            'address' => 'nullable',
            'village_id' => 'nullable|exists:villages,id',
            'zipcode' => 'nullable|min:5',
            'profesi' => 'nullable',
            'pendidikan' => 'nullable',
            'instagram' => '',
            'batch_id' => 'sometimes',
            'course_id' => 'sometimes',
            'term_condition' => 'required',
        ]);

        DB::beginTransaction();

        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
        ]));

        $member = Member::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'profesi' => $request->profesi,
            'pendidikan' => $request->pendidikan,
            'instagram' => $request->instagram,
            'village_id' => $request->village_id,
            'zipcode' => $request->zipcode,
            'is_overseas' => $request->is_overseas ?? 0,
        ]);

        if ($request->has('batch_id')) {
            $additional = [];
            if ($request->has('session')) {
                $additional = ['session' => $request->session];
            }

            $member->batches()->attach($request->batch_id, $additional);

            $memberBatch = $member->batches()->latest()->first()->pivot;

            $member->user->notify(new MemberBatchRegistration($memberBatch));

            foreach (User::where('role', 'admin')->get() as $admin) {
                $admin->notify(new BatchRegistration($memberBatch));
            }
        } elseif ($request->has('course_id')) {
            $queue = Queue::create([
                'course_id' => $request->course_id,
                'member_id' => $member->id,
            ]);
            $member->user->notify(new MemberWaitinglist($queue));
            foreach (User::where('role', 'admin')->get() as $admin) {
                $admin->notify(new AdminWaitinglist($queue));
            }
        }

        //event(new Registered($user));

        DB::commit();

        if ($request->has('batch_id')) {
            return redirect()->route('member.batches.detail', $memberBatch->id);
        } elseif ($request->has('course_id')) {
            return redirect()->route('member.dashboard')->with('message', 'Anda telah berhasil didaftarkan dalam waiting list');
        }

        return redirect('/');
    }
}
