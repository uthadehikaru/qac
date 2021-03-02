<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Member;
use App\Models\MemberBatch;

class DashboardController extends Controller
{
    public function index()
    {
        $data['all_members'] = Member::count();
        $data['unverified_members'] = User::whereNull('email_verified_at')->count();
        $data['unapproved_members'] = MemberBatch::whereNull('approved_at')->count();
        return view('admin.dashboard', $data);
    }

    public function notifications()
    {
        $data['notifications'] = Auth::user()->notifications;
        return view('admin.notifications', $data);
    }
}
