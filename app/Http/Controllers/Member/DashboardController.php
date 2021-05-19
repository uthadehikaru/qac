<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Event;
use App\Models\Member;
use App\Models\MemberBatch;

class DashboardController extends Controller
{
    public function index()
    {
        $member = Member::with(['batches','courses'])->where('user_id',Auth::id())->first();
        $data['member'] = $member;
        $data['courses'] = Course::orderBy('level')->get();
        $data['incomingEvents'] = Event::incoming()->get();
        return view('member.dashboard', $data);
    }

    public function waitingList($course_id)
    {
        $member = Auth::user()->member;
        $course = Course::find($course_id);
        if($member->level()<$course->level-1){
            return redirect()->route('member.dashboard')->with('error','Anda belum selesai mengikuti kelas dibawah '.$course->name);
        }else{
            $member->courses()->toggle($course_id);
            return redirect()->route('member.dashboard')->with('message','Berhasil memperbaharui waiting list '.$course->name);
        }
    }
}
