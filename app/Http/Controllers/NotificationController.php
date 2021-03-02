<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Member;
use App\Models\MemberBatch;

class NotificationController extends Controller
{
    public function index()
    {
        $data['notifications'] = Auth::user()->notifications()->paginate(10);
        return view('notifications', $data);
    }
    public function read()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }
}
