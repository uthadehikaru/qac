<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Batch;
use App\Models\Event;
use App\Models\Member;
use App\Models\MemberBatch;

class DashboardController extends Controller
{
    public function index()
    {
        $member = Member::where('user_id',Auth::id())->first();
        $data['batches'] = MemberBatch::where('member_id',$member->id)->get();
        $data['openBatches'] = Batch::with('course')->open()->get();
        $data['incomingEvents'] = Event::incoming()->get();
        return view('member.dashboard', $data);
    }
}
