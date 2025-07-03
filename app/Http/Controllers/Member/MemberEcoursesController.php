<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\EcourseService;
use App\Services\OrderService;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;

class MemberEcoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EcourseService $ecourseService, OrderService $orderService)
    {
        if(Auth::user()->role == 'admin') {
            return redirect()->route('admin.ecourses.index');
        }

        $member_id = Auth::user()->member?->id;
        $data['ecourses'] = $ecourseService->memberEcourses($member_id)
            ->transform(function ($ecourse) use ($member_id) {
                $ecourse->completed = (new SubscriptionService)->getCompletedLessons($ecourse->id, $member_id)->count();

                return $ecourse;
            });
        $data['order'] = $orderService->activeOrder();

        return view('member.ecourses', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionService $subscriptionService, string $slug)
    {
        $member_id = Auth::user()->member?->id;
        $ecourse = $subscriptionService->getEcourse($slug, $member_id);
        $data['ecourse'] = $ecourse;
        $data['videos'] = $subscriptionService->getVideos($ecourse->id);

        return view('member.ecourse', $data);
    }
}
