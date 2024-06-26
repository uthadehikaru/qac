<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\MemberBatch;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class AddSubscriberFromCourse extends Controller
{
    public function __invoke(Request $request, SubscriptionService $subscriptionService, $ecourse_id)
    {
        $data = $request->validate([
            'course_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
        ]);

        $course = Course::with(['batches', 'batches.members'])->find($request->course_id);
        $count = 0;
        foreach ($course->batches as $batch) {
            foreach ($batch->members as $member) {
                if ($member->pivot->status < MemberBatch::STATUS_PAID) {
                    continue;
                }

                $data['ecourse_id'] = $ecourse_id;
                $data['member_id'] = $member->id;
                $subscriptionService->addMember($data);
                $count++;
            }
        }

        if ($count) {
            return redirect()->route('admin.ecourses.subscriptions.index', $ecourse_id)->with('message', $count.' Subcriber Added');
        } else {
            return redirect()->route('admin.ecourses.subscriptions.index', $ecourse_id)->with('error', 'No Subscriber Added');
        }
    }
}
