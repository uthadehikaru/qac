<?php

namespace App\Http\Controllers;

use App\Models\Ecourse;
use App\Services\EcourseService;

class EcourseController extends Controller
{
    public function index(EcourseService $ecourseService)
    {
        $data['ecourses'] = $ecourseService->publishedEcourses();

        return view('ecourse-list', $data);
    }

    public function show(EcourseService $ecourseService, Ecourse $ecourse)
    {
        if (! $ecourse->published) {
            return abort(404);
        }

        $data['ecourse'] = $ecourse;
        $data['order'] = $ecourseService->memberOrder();
        $data['ecourses'] = $ecourseService->latestEcourses(3);

        return view('ecourse-detail', $data);
    }
}
