<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Services\EcourseService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonVideo extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EcourseService $ecourseService, SubscriptionService $subscriptionService, string $slug, string $section_id = null, string $lesson_uu = null)
    {
        $member_id = Auth::user()->member->id;
        $data['member_id'] = $member_id;
        $ecourse = $subscriptionService->getEcourse($slug, $member_id);
        $section = $subscriptionService->getSection($section_id);
        $data['section'] = $section;
        $data['ecourse'] = $ecourse;
        $videos = $subscriptionService->getVideos($ecourse->id, $section_id);
        $data['completed']  = $subscriptionService->getCompletedLessons($ecourse->id, $member_id)->pluck('lesson_id');
        if($lesson_uu)
            $data['video'] = $subscriptionService->getLesson($lesson_uu);
        else
            $data['video'] = $videos->first();
        $data['videos'] = $videos;
        $data['next'] = $ecourseService->getNext($videos, $lesson_uu);
        return view('member.lesson-video', $data);
    }
}
