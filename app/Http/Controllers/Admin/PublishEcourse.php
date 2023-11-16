<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\MemberBatch;
use App\Services\EcourseService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class PublishEcourse extends Controller
{
    public function __invoke(EcourseService $ecourseService, $ecourse_id)
    {
        $ecourseService->publish($ecourse_id);
        return back()->with('message','Data updated');
    }
}
