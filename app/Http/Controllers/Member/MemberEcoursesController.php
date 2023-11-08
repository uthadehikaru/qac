<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\EcourseService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberEcoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EcourseService $ecourseService)
    {
        $data['ecourses'] = $ecourseService->memberEcourses(Auth::user()->member->id);
        return view('member.ecourses', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionService $subscriptionService, string $slug)
    {
        $ecourse = $subscriptionService->getEcourse($slug, Auth::user()->member->id);
        $data['ecourse'] = $ecourse;
        $data['lessons'] = $subscriptionService->getSections($ecourse->id);
        return view('member.ecourse', $data);
    }
}
