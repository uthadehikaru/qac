<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Ecourse;
use App\Models\Lesson;
use App\Services\EcourseService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompleteLesson extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EcourseService $ecourseService, SubscriptionService $subscriptionService, string $slug, string $lesson_uu)
    {
        $lesson = $ecourseService->getLessonByUUID($lesson_uu);
        $subscriptionService->completeLesson($lesson_uu, Auth::user()->member->id);
        $videos = $subscriptionService->getVideos($lesson->ecourse_id);
        $next = $ecourseService->getNext($videos, $lesson_uu);
        $params = [$slug];
        if($next)
            $params[] = $next->lesson_uu;
        else
            $params[] = $lesson_uu;

        return redirect()->route('member.ecourses.lessons', $params);
    }
}
