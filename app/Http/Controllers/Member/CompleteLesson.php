<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompleteLesson extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SubscriptionService $subscriptionService, string $slug, string $lesson_uu)
    {
        $subscriptionService->completeLesson($lesson_uu, Auth::user()->member->id);
        return redirect()->route('member.ecourses.lessons', $slug);
    }
}
