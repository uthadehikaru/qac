<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Event;
use App\Models\Member;
use App\Models\MemberBatch;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data['all_members'] = Member::count();
        $data['all_courses'] = Course::count();
        $data['all_batches'] = Batch::count();
        $data['all_events'] = Event::count();
        $data['courses'] = Course::orderBy('level')->active()->get();
        $data['batchStatuses'] = MemberBatch::statuses;
        if (Auth::user()->is_admin) {
            $data['queues'] = \DB::table('jobs')->count();
        }

        return view('admin.dashboard', $data);
    }

    public function notifications()
    {
        $data['notifications'] = Auth::user()->notifications;

        return view('admin.notifications', $data);
    }
}
