<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Notifications\BatchRegistration;
use App\Notifications\MemberBatchRegistration;
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
        $data['course'] = Course::find($course_id);
        $data['lite'] = Str::startsWith($data['course']->name, 'QAC 1.0 Lite');
        $data['batch'] = Batch::find($batch_id);
        $data['provinces'] = Province::orderBy('name')->get();
        return view('kelas.register', $data);
    }

    public function submit(Request $request, $course_id, $batch_id = null)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
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
            $batch = Batch::find($batch_id);
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
            }else{
                $member->batches()->attach($batch->id);

                $member->batches()->attach($request->batch_id);

                $memberBatch = $member->batches()->latest()->first()->pivot;

                $member->user->notify(new MemberBatchRegistration($memberBatch));

                foreach (User::where('role', 'admin')->get() as $admin) {
                    $admin->notify(new BatchRegistration($memberBatch));
                }
            }

            DB::commit();

            return redirect()->route('member.dashboard')->with('success', 'Pendaftaran berhasil');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat pendaftaran');
        }
    }
}