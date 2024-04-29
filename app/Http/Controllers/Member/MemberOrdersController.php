<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
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

        return view('member.orders', $data);
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
