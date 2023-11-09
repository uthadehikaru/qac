<?php

namespace App\Services;

use App\Http\Controllers\Member\CompleteLesson;
use App\Models\CompletedLesson;
use App\Models\Ecourse;
use App\Models\Lesson;
use App\Models\Section;

class SubscriptionService {

    public function getEcourse($slug, $member_id)
    {
        return Ecourse::with('lessons')
        ->where('slug',$slug)
        ->whereRelation('subscribers','member_id',$member_id)
        ->first();
    }

    public function getSections($ecourse_id)
    {
        return Section::whereRelation('lessons','ecourse_id',$ecourse_id)
        ->orderBy('order_no')
        ->get();
    }

    public function getCompletedLessons($ecourse_id, $member_id)
    {
        return CompletedLesson::whereRelation('lesson', 'ecourse_id', $ecourse_id)
        ->where('member_id', $member_id)
        ->get();
    }

    public function getVideos($ecourse_id)
    {
        return Lesson::where('ecourse_id',$ecourse_id)
        ->get();
    }

    public function getLesson($lesson_uu)
    {
        return Lesson::where('lesson_uu',$lesson_uu)
        ->first();
    }

    public function completeLesson($lesson_uu, $member_id)
    {
        $lesson = Lesson::where('lesson_uu',$lesson_uu)->first();
        return CompletedLesson::create([
            'lesson_id' => $lesson->id,
            'member_id' => $member_id,
        ]);
    }
}