<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\EcourseService;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;

class MemberSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubscriptionService $subscriptionService)
    {
        $data['subscriptions'] = $subscriptionService->ofMember(Auth::user()->member->id);

        return view('member.subscriptions', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(EcourseService $ecourseService, SubscriptionService $subscriptionService, string $slug)
    {
        $member_id = Auth::user()->member->id;
        $ecourse = $subscriptionService->getEcourse($slug, $member_id);
        $data['ecourse'] = $ecourse;
        $data['sections'] = $ecourseService->getEcourseSections($ecourse->id);
        $data['completed'] = $subscriptionService->getCompletedLessons($ecourse->id, $member_id);

        return view('member.ecourse', $data);
    }
}
