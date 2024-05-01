<?php

namespace App\Services;

use App\Models\Batch;
use App\Models\Ecourse;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\Section;
use App\Models\Subscription;
use App\Models\System;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EcourseService
{
    public function latestEcourses($limit = 8)
    {
        return Ecourse::published()->latest()->take($limit)->get();
    }

    public function publishedEcourses()
    {
        return Ecourse::published()->bundle()->latest()->get();
    }

    public function updateOrCreate($data, $id = null): Ecourse
    {
        if ($id) {
            $ecourse = Ecourse::find($id);
            $ecourse->update($data);

            return $ecourse;
        }

        $data['slug'] = Str::slug($data['title']);

        return Ecourse::create($data);
    }

    public function find($id): Ecourse
    {
        return Ecourse::with('lessons')->find($id);
    }

    public function findBySlug($slug): Ecourse
    {
        return Ecourse::where('slug', $slug)->first();
    }

    public function getSections()
    {
        return Section::all();
    }

    public function getLesson($id): Lesson
    {
        return Lesson::find($id);
    }

    public function getLessonByUUID($lesson_uu): Lesson
    {
        return Lesson::where('lesson_uu', $lesson_uu)->first();
    }

    public function updateOrCreateLesson($data): Lesson
    {
        $lesson = null;

        if ($data['id']) {
            $lesson = Lesson::find($data['id']);
            $lesson->update($data);
        } else {
            $data['lesson_uu'] = Str::uuid();
            $lesson = Lesson::create($data);
        }

        return $lesson;
    }

    public function updateOrCreateSubscription($data): Subscription
    {
        $subscription = null;

        if ($data['id']) {
            $subscription = Subscription::find($data['id']);
            $subscription->update($data);
        } else {
            $subscription = Subscription::create($data);
        }

        return $subscription;
    }

    public function memberEcourses($member_id)
    {
        $ecource_access_month = System::value('ecource_access_month', 1);
        $courses = Batch::whereHas('paidMembers', function ($query) use ($member_id) {
            $query->where('member_id', $member_id);
        })
            ->where('start_at', '<=', date('Y-m-d'))
            ->whereRaw('DATE_ADD(end_at, INTERVAL '.$ecource_access_month." MONTH) >= '".date('Y-m-d')."'")
            ->pluck('course_id');
        $ecourses = Ecourse::whereIn('course_id', $courses)->get();

        $activeOrder = Order::latest()
            ->active()
            ->whereNotNull('verified_at')
            ->where('member_id', $member_id)
            ->first();
        if (! $activeOrder && $ecourses->count() == 0) {
            return $ecourses;
        }

        $published = Ecourse::published()->bundle()->get();

        return $ecourses->merge($published);
    }

    public function getNext($videos, $lesson_uu = null): ?Lesson
    {
        $current = false;
        foreach ($videos as $video) {
            if ($current) {
                return $video;
            }

            if (! $lesson_uu || $video->lesson_uu == $lesson_uu) {
                $current = true;
            }
        }

        return null;
    }

    public function publish($ecourse_id)
    {
        $ecourse = Ecourse::find($ecourse_id);
        if ($ecourse->published_at) {
            $ecourse->published_at = null;
        } else {
            $ecourse->published_at = Carbon::now();
        }

        $ecourse->save();
    }

    public function memberOrder()
    {
        if (! Auth::check()) {
            return null;
        }

        return Order::where('member_id', Auth::user()->member?->id)
            ->whereNull('verified_at')
            ->first();

    }
}
