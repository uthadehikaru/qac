<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MemberBatch;
use App\Services\EcourseService;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;

class MemberOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubscriptionService $subscriptionService)
    {
        $data['orders'] = $subscriptionService->orders(Auth::user()->member->id);
        $data['memberBatches'] = MemberBatch::with('batch')->where('member_id', Auth::user()->member->id)->get();

        return view('member.orders', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionService $subscriptionService, EcourseService $ecourseService, string $slug)
    {
        $member_id = Auth::user()->member->id;
        $ecourse = $subscriptionService->getEcourse($slug, $member_id);
        $data['ecourse'] = $ecourse;
        $data['sections'] = $ecourseService->getEcourseSections($ecourse->id);
        $data['completed'] = $subscriptionService->getCompletedLessons($ecourse->id, $member_id);

        return view('member.ecourse', $data);
    }
}
