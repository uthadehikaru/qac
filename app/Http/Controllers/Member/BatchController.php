<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Batch;
use App\Models\Member;
use App\Models\MemberBatch;
use App\Notifications\BatchRegistration;
use App\Notifications\MemberBatchRegistration;

class BatchController extends Controller
{
    public function detail($id)
    {
        $batch = Batch::with('course')->find($id);

        if(!$batch || !$batch->is_open)
            abort(404);

        $data['batch'] = $batch;
        $member = Member::with(['batches','courses'])->where('user_id',Auth::id())->first();
        $data['member'] = $member;
        return view('member.batch-detail', $data);
    }
    
    public function register(Request $request, $id)
    {
        $batch = Batch::with('course')->find($id);

        if(!$batch || !$batch->is_open)
            return back()->with('error','Data tidak ditemukan');

        $request->validate([
            'session' => 'sometimes',
        ]);

        $lastBatch = Auth::user()->member->batches()->orderBy('pivot_id','desc')->first();
        $lastLevel = $lastBatch?$lastBatch->course->level:0;
        $lastDate = $lastBatch?$lastBatch->end_at:Carbon::now();
        $currentLevel = $batch?$batch->course->level:0;
        if($lastBatch && $lastBatch->id==$batch->id)
            return back()->with('error','Anda telah mendaftar kelas ini');

        if(Carbon::now()->isBefore($lastDate) || $lastLevel<$currentLevel-1)
            return back()->with('error','Maaf, Anda belum menyelesaikan level sebelumnya');

        $additional = [];
        if($request->has('session'))
            $additional = ['session'=>$request->session];
        
        $member = Auth::user()->member;
        
        $member->batches()->attach($batch->id, $additional);
        
        $memberBatch = $member->batches()->latest()->first()->pivot;

        $member->user->notify(new MemberBatchRegistration($memberBatch));
        
        foreach(User::where('role','admin')->get() as $admin)
            $admin->notify(new BatchRegistration($memberBatch));

        return redirect()->route('member.batches.detail', $memberBatch->id)->with('success','Selamat, Anda telah terdaftar pada '.$batch->full_name.'. silahkan menghubungi Admin QAC via whatsapp untuk proses administrasi. <a target="_blank" href="https://wa.me/'.\App\Models\System::value('whatsapp').'?text='.urlencode('Assalaamu\'alaikum QAC, saya sudah mendaftar '.$batch->full_name.' atas nama '.Auth::user()->member->full_name.'. mohon dibantu untuk proses selanjutnya. terima kasih').'" class="text-blue-500 cursor-pointer">klik disini</a>');
    }
}
