<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\EcourseService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberEcoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EcourseService $ecourseService)
    {
        $data['ecourses'] = $ecourseService->memberEcourses(Auth::user()->member->id);
        return view('member.ecourses', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionService $subscriptionService, string $slug)
    {
        $member_id = Auth::user()->member->id;
        $ecourse = $subscriptionService->getEcourse($slug, $member_id);
        $data['ecourse'] = $ecourse;
        $data['sections'] = $subscriptionService->getSections($ecourse->id);
        $data['completed'] = $subscriptionService->getCompletedLessons($ecourse->id, $member_id);
        return view('member.ecourse', $data);
    }
}
