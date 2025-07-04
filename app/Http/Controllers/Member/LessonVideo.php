<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\EcourseService;
use App\Services\OrderService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonVideo extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EcourseService $ecourseService, SubscriptionService $subscriptionService, OrderService $orderService, string $slug, ?string $lesson_uu = null)
    {
        $activeOrder = $orderService->activeOrder();
        if(!$activeOrder){
            return redirect()->route('checkout')->with('error', 'Anda belum memiliki langganan aktif');
        }
        $member_id = Auth::user()->member?->id;
        $data['member_id'] = $member_id;
        $ecourse = $subscriptionService->getEcourse($slug, $member_id);
        $data['ecourse'] = $ecourse;
        $videos = $subscriptionService->getVideos($ecourse->id);
        $data['completed'] = $subscriptionService->getCompletedLessons($ecourse->id, $member_id)->pluck('lesson_id');
        if ($lesson_uu) {
            $data['video'] = $subscriptionService->getLesson($lesson_uu);
        } else {
            $data['video'] = $videos->first();
        }
        if(!$data['video']){
            return redirect()->route('member.ecourses.show', $slug);
        }
        $ecourseService->addHistory($data['video']->id, $member_id);
        $data['videos'] = $videos;
        $allVideos = $subscriptionService->getVideos($ecourse->id);
        $data['next'] = $ecourseService->getNext($allVideos, $lesson_uu);

        return view('member.lesson-video', $data);
    }
}
