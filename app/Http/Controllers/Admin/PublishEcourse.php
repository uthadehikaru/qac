<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EcourseService;

class PublishEcourse extends Controller
{
    public function __invoke(EcourseService $ecourseService, $ecourse_id)
    {
        $ecourseService->publish($ecourse_id);

        return back()->with('message', 'Data updated');
    }
}
