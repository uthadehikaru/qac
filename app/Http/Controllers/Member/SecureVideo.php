<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecureVideo extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SubscriptionService $subscriptionService, string $slug, string $lesson_uu)
    {
        $member_id = Auth::user()->member->id;
        $ecourse = $subscriptionService->getEcourse($slug, $member_id);
        $video = $subscriptionService->getLesson($lesson_uu);
        if (! $ecourse || ! $video || ! $video->getMedia('videos')->first()) {
            abort(404);
        }

        return response()->file($video->getMedia('videos')->first()->getPath());
    }
}
