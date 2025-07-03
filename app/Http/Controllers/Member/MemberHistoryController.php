<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EcourseService;
use Illuminate\Support\Facades\Auth;

class MemberHistoryController extends Controller
{
    public function index(EcourseService $ecourseService)
    {
        $member_id = Auth::user()->member?->id;
        $data['histories'] = $ecourseService->memberHistory($member_id);

        return view('member.history', $data);
    }
}