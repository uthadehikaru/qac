<?php

namespace App\Http\Controllers;

use Auth;

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
