<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Artisan;

class JobController extends Controller
{
    public function index()
    {
        $data['jobs'] = DB::table('jobs')->count();
        $data['failed_jobs'] = DB::table('failed_jobs')->get();
        return view('admin.jobs', $data);
    }

    public function retry()
    {
        $exitCode = Artisan::call('queue:retry', ['all']);
        return back()->with('message','Processed '.$exitCode);
    }

    public function empty()
    {
        $exitCode = Artisan::call('queue:flush');
        return back()->with('message','Processed '.$exitCode);
    }
}