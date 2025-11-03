<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Member;
use App\Models\MemberBatch;
use App\Models\Province;
use App\Models\Queue;
use App\Models\Regency;
use App\Models\System;
use App\Models\User;
use App\Notifications\AdminWaitinglist;
use App\Notifications\BatchRegistration;
use App\Notifications\MemberBatchRegistration;
use App\Notifications\MemberWaitinglist;
use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CourseRegisterController extends Controller
{
    public function index($course_id, $batch_id = null)
    {
        $data['member'] = null;
        $regency = null;
        $data['is_registered'] = false;
        $data['full_name'] = null;
        $data['phone'] = null;
        $data['job'] = null;
        $data['education'] = null;
        $data['province'] = null;
        $data['regency'] = null;
        $data['is_overseas'] = null;
        $data['is_registered'] = 0;
        if(Auth::check()) {
            $data['member'] = Member::with('batches')->where('user_id', Auth::user()->id)->first();
            $data['is_registered'] = $data['member']->batches()->count() > 0 ? 1 : 0;
            $regency = Regency::where('name', $data['member']->city)->first();
            $data['full_name'] = $data['member']->full_name;
            $data['phone'] = $data['member']->phone;
            $data['job'] = $data['member']->profesi;
            $data['education'] = $data['member']->pendidikan;
            $data['province'] = $data['member']->province;
            $data['regency'] = $data['member']->city;
            $data['is_overseas'] = $data['member']->is_overseas;
        }
        $data['member_regency'] = $regency ? $regency->id : null;
        $data['member_province'] = $regency ? $regency->province_id : null;
        $data['course'] = Course::find($course_id);
        $data['lite'] = Str::startsWith($data['course']->name, 'QAC 1.0 Lite');
        $data['batch'] = Batch::find($batch_id);
        $data['provinces'] = Province::orderBy('name')->get();
        $data['regencies'] = [];
        if($data['member_province']) {
            $data['regencies'] = Regency::where('province_id', $data['member_province'])->orderBy('name')->get();
        }
        return view('kelas.register', $data);
    }

    public function submit(MemberService $memberService, Request $request, $course_id, $batch_id = null)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'batch_id' => 'nullable|exists:batches,id',
            'phone' => 'required|numeric',
            'email' => 'required_if:is_registered,0|email|unique:users,email',
            'password' => 'required_if:is_registered,0|string|min:8|confirmed',
            'job' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'regency' => 'nullable|string|max:255',
            'is_overseas' => 'nullable|boolean',
            'package' => 'nullable|required_if:lite,1|in:1a,1b,bundling',
            'lite' => 'nullable|boolean',
            'term_condition' => 'required|accepted',
        ]);

        DB::beginTransaction();
        try{
            $course = Course::find($course_id);
            $batch = null;
            if(isset($data['batch_id'])){
                $batch = Batch::find($data['batch_id']);
            }
            $regency = $data['regency'] ? Regency::find($data['regency']) : null;

            $user = null;
            $member = null;
            if(Auth::check()) {
                $user = User::with('member')->find(Auth::user()->id);
                $user->update([
                    'name' => $data['full_name'],
                ]);
                $member = $user->member;

                $member->update([
                    'full_name' => $data['full_name'],
                    'phone' => $data['phone'],
                    'profesi' => $data['job'],
                    'pendidikan' => $data['education'],
                    'city' => $regency ? $regency->name : null,
                    'address' => $regency ? $regency->name.' '.$regency->province->name : null,
                    'is_overseas' => isset($data['is_overseas']) ? $data['is_overseas'] : 0,
                ]);
                $member->save();
            }else{
                $user = User::create([
                    'name' => $data['full_name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => 'member',
                ]);

                $member = Member::create([
                    'user_id' => $user->id,
                    'full_name' => $data['full_name'],
                    'phone' => $data['phone'] ?? '',
                    'gender' => $data['gender'] ?? 'pria',
                    'is_overseas' => $data['is_overseas'] ?? 0,
                    'city' => $regency ? $regency->name : null,
                    'address' => $regency ? $regency->name.' '.$regency->province->name : null,
                    'profesi' => $data['job'],
                    'pendidikan' => $data['education'],
                ]);

                Auth::login($user);
            }

            if($data['lite']) {
                $data['package'] = $data['package'] ?? '1a';
                if($data['package'] == 'bundling') {
                    $lite1a = Course::find(System::value('qac_1_lite_1a'));
                    $batch1a = $lite1a->batches()->first();
                    $lite1b = Course::find(System::value('qac_1_lite_1b'));
                    $batch1b = $lite1b->batches()->first();
                    $activeBatch1a = $memberService->checkMemberActiveBatch($member->id, $lite1a->id, true);
                    if($activeBatch1a) {
                        return back()->with('error', 'Anda masih mengikuti kelas '.$lite1a->name.' bundling');
                    }

                    $member->batches()->attach($batch1a->id, ['session' => 'bundling']);
                    $member->batches()->attach($batch1b->id, ['session' => 'bundling']);

                    $memberBatch = $member->batches()->latest()->first()->pivot;

                    $member->user->notify(new MemberBatchRegistration($memberBatch));

                    foreach (User::where('role', 'admin')->get() as $admin) {
                        $admin->notify(new BatchRegistration($memberBatch));
                    }
                }else{
                    if($data['package'] == '1a') {
                        $course = Course::find(System::value('qac_1_lite_1a'));
                    }else{
                        $course = Course::find(System::value('qac_1_lite_1b'));
                    }
                    $batch = $course->batches()->first();
                    $activeBatch = $memberService->checkMemberActiveBatch($member->id, $course->id, true);
                    if($activeBatch) {
                        return back()->with('error', 'Anda masih mengikuti kelas '.$activeBatch->batch->full_name);
                    }
                    $member->batches()->attach($batch->id);

                    $memberBatch = $member->batches()->latest()->first()->pivot;

                    $member->user->notify(new MemberBatchRegistration($memberBatch));

                    foreach (User::where('role', 'admin')->get() as $admin) {
                        $admin->notify(new BatchRegistration($memberBatch));
                    }
                }
            }elseif($batch){
                $lastBatch = Auth::user()->member->batches()
                    ->wherePivot('status', MemberBatch::STATUS_GRADUATED)
                    ->orderBy('pivot_id', 'desc')->first();
                $lastLevel = $lastBatch ? $lastBatch->course->level : 0;
                $currentLevel = $batch ? $batch->course->level : 0;
                if ($lastBatch && $lastBatch->id == $batch->id) {
                    return back()->with('error', 'Anda telah mendaftar kelas ini');
                }

                if ($lastLevel < $currentLevel - 1) {
                    return back()->with('error', 'Maaf, Anda belum menyelesaikan level sebelumnya');
                }
                $member->batches()->attach($batch->id);

                $memberBatch = $member->batches()->latest()->first()->pivot;

                $member->user->notify(new MemberBatchRegistration($memberBatch));

                foreach (User::where('role', 'admin')->get() as $admin) {
                    $admin->notify(new BatchRegistration($memberBatch));
                }
            }else{
                $queue = Queue::create([
                    'course_id' => $course_id,
                    'member_id' => $member->id,
                ]);
                $member->user->notify(new MemberWaitinglist($queue));
                foreach (User::where('role', 'admin')->get() as $admin) {
                    $admin->notify(new AdminWaitinglist($queue));
                }
            }

            DB::commit();

            return redirect()->route('member.orders.index')->with('success', 'Pendaftaran berhasil');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat pendaftaran');
        }
    }
}