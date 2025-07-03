<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Member;
use App\Models\Province;
use App\Models\Queue;
use App\Models\Regency;
use App\Models\User;
use App\Notifications\AdminWaitinglist;
use App\Notifications\BatchRegistration;
use App\Notifications\MemberBatchRegistration;
use App\Notifications\MemberWaitinglist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseRegisterController extends Controller
{
    public function index($course_id, $batch_id = null)
    {
        if(!Auth::check()) {
            session()->put('url.intended', route('kelas.register', ['course_id' => $course_id, 'batch_id' => $batch_id]));
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu untuk melanjutkan pendaftaran');
        }
        $data['member'] = Member::with('batches')->where('user_id', Auth::user()->id)->first();
        $data['is_registered'] = $data['member']->batches()->count() > 0;
        $regency = Regency::where('name', $data['member']->city)->first();
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

    public function submit(Request $request, $course_id, $batch_id = null)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'batch_id' => 'nullable|exists:batches,id',
            'phone' => 'required|numeric',
            'job' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
            'province' => 'required|string|max:255',
            'regency' => 'required|string|max:255',
            'is_overseas' => 'nullable|boolean',
            'package' => 'nullable|required_if:lite,1|in:1a,1b,bundling',
            'lite' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try{
            $course = Course::find($course_id);
            $batch = null;
            if(isset($data['batch_id'])){
                $batch = Batch::find($data['batch_id']);
            }
            $regency = $data['regency'] ? Regency::find($data['regency']) : null;

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

            if($data['lite']) {
                $data['package'] = $data['package'] ?? '1a';
                if($data['package'] == 'bundling') {
                    $lite1a = Course::where('name', 'QAC 1.0 Lite 1a')->first();
                    $batch1a = $lite1a->batches()->first();
                    $lite1b = Course::where('name', 'QAC 1.0 Lite 1b')->first();
                    $batch1b = $lite1b->batches()->first();
                    $member->batches()->attach($batch1a->id);
                    $member->batches()->attach($batch1b->id);

                    $memberBatch = $member->batches()->latest()->first()->pivot;

                    $member->user->notify(new MemberBatchRegistration($memberBatch));

                    foreach (User::where('role', 'admin')->get() as $admin) {
                        $admin->notify(new BatchRegistration($memberBatch));
                    }
                }else{
                    $course = Course::where('name', 'QAC 1.0 Lite '.$data['package'])->first();
                    $batch = $course->batches()->first();
                    $member->batches()->attach($batch->id);

                    $memberBatch = $member->batches()->latest()->first()->pivot;

                    $member->user->notify(new MemberBatchRegistration($memberBatch));

                    foreach (User::where('role', 'admin')->get() as $admin) {
                        $admin->notify(new BatchRegistration($memberBatch));
                    }
                }
            }elseif($batch){
                $member->batches()->attach($batch->id);

                $member->batches()->attach($batch->id);

                $memberBatch = $member->batches()->latest()->first()->pivot;

                $member->user->notify(new MemberBatchRegistration($memberBatch));

                foreach (User::where('role', 'admin')->get() as $admin) {
                    $admin->notify(new BatchRegistration($memberBatch));
                }
            }else{
                $queue = Queue::create([
                    'course_id' => $request->course_id,
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