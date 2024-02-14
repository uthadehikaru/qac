<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\MemberBatch;
use App\Services\EcourseService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class AddSubscriberFromBatch extends Controller
{
    public function __invoke(Request $request, SubscriptionService $subscriptionService, $ecourse_id)
    {
        $data = $request->validate([
            'batch_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date'
        ]);

        $batch = Batch::find($request->batch_id);
        $count = 0;
        foreach($batch->members as $member){
            if($member->pivot->status!=MemberBatch::STATUS_PAID)
                continue;

            $data['ecourse_id'] = $ecourse_id;
            $data['member_id'] = $member->id;
            $subscriptionService->addMember($data);
            $count++;
        }

        if($count)
            return redirect()->route('admin.ecourses.subscriptions.index', $ecourse_id)->with('message',$count.' Subcriber Added');
        else
            return redirect()->route('admin.ecourses.subscriptions.index', $ecourse_id)->with('error','No Subscriber Added');
    }
}
