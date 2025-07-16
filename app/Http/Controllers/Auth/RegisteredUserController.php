<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Member;
use App\Models\Queue;
use App\Models\Regency;
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

        if($request->course_id) {
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
            'name' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'nullable|numeric|unique:members|min:8',
            'gender' => 'nullable|in:pria,wanita',
            'regency_id' => 'nullable|exists:regencies,id',
            'session' => 'sometimes',
            'profesi' => 'nullable',
            'pendidikan' => 'nullable',
            'instagram' => '',
            'batch_id' => 'sometimes',
            'course_id' => 'sometimes',
        ]);

        DB::beginTransaction();

        Auth::login($user = User::create([
            'name' => $request->name ?? $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
        ]));

        $regency = $request->regency_id ? Regency::find($request->regency_id) : null;

        $member = Member::create([
            'user_id' => $user->id,
            'full_name' => $request->full_name,
            'phone' => $request->phone ?? '',
            'gender' => $request->gender ?? 'pria',
            'is_overseas' => $request->is_overseas ?? 0,
            'city' => $regency ? $regency->name : null,
            'address' => $regency ? $regency->name.' '.$regency->province->name : null,
            'profesi' => $request->profesi,
            'pendidikan' => $request->pendidikan,
            'instagram' => $request->instagram,
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

        // Redirect back to register form with success message
        return redirect()->route('home');
    }
}
