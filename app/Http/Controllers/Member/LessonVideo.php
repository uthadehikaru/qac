<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonVideo extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SubscriptionService $subscriptionService, string $slug, string $lesson_uu = null)
    {
        $member_id = Auth::user()->member->id;
        $data['member_id'] = $member_id;
        $ecourse = $subscriptionService->getEcourse($slug, $member_id);
        $data['ecourse'] = $ecourse;
        $data['videos'] = $subscriptionService->getVideos($ecourse->id);
        $data['completed']  = $subscriptionService->getCompletedLessons($ecourse->id, $member_id)->pluck('lesson_id');
        //dd($data);
        if($lesson_uu)
            $data['video'] = $subscriptionService->getLesson($lesson_uu);
        else
            $data['video'] = $data['videos']->first();
        return view('member.lesson-video', $data);
    }
}
