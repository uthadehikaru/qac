<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Member;
use App\Models\MemberBatch;
use App\Models\User;
use App\Notifications\BatchRegistration;
use App\Notifications\MemberBatchRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatchController extends Controller
{
    public function detail($id)
    {
        $batch = Batch::with('course')->find($id);

        if (! $batch || ! $batch->is_open) {
            abort(404);
        }

        $data['batch'] = $batch;
        $member = Member::with(['batches', 'courses'])->where('user_id', Auth::id())->first();

        // check if member already register for this course
        $data['reseat'] = $member->batches->contains(function ($memberBatch, $key) use ($batch) {
            return $memberBatch->course_id == $batch->course_id && $memberBatch->status>=MemberBatch::STATUS_PAID;
        });

        $data['member'] = $member;

        return view('member.batch-detail', $data);
    }

    public function register(Request $request, $id)
    {
        $batch = Batch::with('course')->find($id);

        if (! $batch || ! $batch->is_open) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $request->validate([
            'session' => 'sometimes',
        ]);

        $member = Auth::user()->member;
        $lastLevel = $member->level() ?? 0;
        $currentLevel = $batch->course->level;

        if ($member->batches()->where('batches.id', $batch->id)->wherePivot('status', '>', MemberBatch::STATUS_CANCELED)->exists()) {
            return back()->with('error', 'Anda telah mendaftar kelas ini');
        }

        if ($lastLevel < $currentLevel - 1) {
            return back()->with('error', 'Maaf, Anda belum menyelesaikan level sebelumnya');
        }

        $additional = [];
        if ($request->has('session')) {
            $additional['session'] = $request->session;
        }

        if ($request->has('new_book')) {
            $additional['new_book'] = $request->new_book;
        }

        if ($request->has('reseat')) {
            $additional['reseat'] = 1;
        }

        $member->batches()->attach($batch->id, $additional);

        $memberBatch = $member->batches()->latest()->first()->pivot;

        $member->user->notify(new MemberBatchRegistration($memberBatch));

        foreach (User::where('role', 'admin')->get() as $admin) {
            $admin->notify(new BatchRegistration($memberBatch));
        }

        return redirect()->route('member.batches.detail', $memberBatch->id)->with('success', 'Selamat, Anda telah terdaftar pada '.$batch->full_name.'. silahkan menghubungi Admin QAC via whatsapp untuk proses administrasi. <a target="_blank" href="https://wa.me/'.\App\Models\System::value('whatsapp').'?text='.urlencode('Assalaamu\'alaikum QAC, saya sudah mendaftar '.$batch->full_name.' atas nama '.Auth::user()->member->full_name.'. mohon dibantu untuk proses selanjutnya. terima kasih').'" class="text-blue-500 cursor-pointer">klik disini</a>');
    }
}
