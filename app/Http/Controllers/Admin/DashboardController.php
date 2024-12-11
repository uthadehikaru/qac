<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Event;
use App\Models\Member;
use App\Models\MemberBatch;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Cache::remember('dashboard', 60, function () {
            $data['all_members'] = Member::count();
            $data['all_courses'] = Course::count();
            $data['all_batches'] = Batch::count();
            $data['all_events'] = Event::count();
            $data['courses'] = Course::orderBy('level')->active()->get();
            $data['batchStatuses'] = MemberBatch::statuses;
            return $data;
        });
        if (Auth::user()->is_admin) {
            $data['queues'] = DB::table('jobs')->count();
        }

        return view('admin.dashboard', $data);
    }

    public function clearCache()
    {
        Cache::flush();
        return redirect()->back()->with('success', 'Cache cleared successfully');
    }

    public function notifications()
    {
        $data['notifications'] = Auth::user()->notifications;

        return view('admin.notifications', $data);
    }
}
