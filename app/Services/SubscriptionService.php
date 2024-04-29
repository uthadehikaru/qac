<?php

namespace App\Services;

use App\Models\CompletedLesson;
use App\Models\Ecourse;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\Section;
use App\Models\Subscription;

class SubscriptionService
{
    public function addMember($data)
    {
        return Subscription::firstOrCreate([
            'ecourse_id' => $data['ecourse_id'],
            'member_id' => $data['member_id'],
        ], [
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ]);
    }

    public function getEcourse($slug, $member_id)
    {
        return Ecourse::with('lessons')
            ->where('slug', $slug)
            ->first();
    }

    public function getSections($ecourse_id)
    {
        return Section::whereRelation('lessons', 'ecourse_id', $ecourse_id)
            ->orderBy('order_no')
            ->get();
    }

    public function getSection($section_id)
    {
        return Section::find($section_id);
    }

    public function getCompletedLessons($ecourse_id, $member_id)
    {
        return CompletedLesson::whereRelation('lesson', 'ecourse_id', $ecourse_id)
            ->where('member_id', $member_id)
            ->get();
    }

    public function getVideos($ecourse_id, $section_id = 0)
    {
        $lessons = Lesson::where('ecourse_id', $ecourse_id)
            ->orderBy('order_no');
        if ($section_id > 0) {
            $lessons->where('section_id', $section_id);
        }

        return $lessons->get();
    }

    public function getLesson($lesson_uu)
    {
        return Lesson::where('lesson_uu', $lesson_uu)
            ->first();
    }

    public function completeLesson($lesson_uu, $member_id)
    {
        $lesson = Lesson::where('lesson_uu', $lesson_uu)->first();

        return CompletedLesson::create([
            'lesson_id' => $lesson->id,
            'member_id' => $member_id,
        ]);
    }

    public function ofMember($member_id)
    {
        return Subscription::where('member_id', $member_id)->latest('start_date')->paginate();
    }

    public function orders($member_id)
    {
        return Order::where('member_id', $member_id)->latest()->paginate();
    }
}
