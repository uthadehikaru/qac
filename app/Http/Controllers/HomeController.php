<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Ecourse;
use App\Models\System;
use App\Models\Event;
use App\Models\MemberBatch;
use App\Services\EcourseService;

class HomeController extends Controller
{
    public function index(EcourseService $ecourseService)
    {
        $data['testimonials'] = MemberBatch::testimonial()->take(3)->get();
        $data['courses'] = Course::with('batches')->active()->get();
        $data['latest_events'] = Event::latest('event_at')->take(3)->get();
        $data['latest_ecourses'] = $ecourseService->latestEcourses(4);
        $data['about_1'] = System::value('about_1');
        $data['about_2'] = System::value('about_2');
        $data['waitinglist'] = System::value('waitinglist');
        return view('welcome', $data);
    }

    public function testimonials()
    {
        $data['testimonials'] = MemberBatch::testimonial()->paginate(9);
        return view('testimonial-list', $data);
    }

    public function certificate($id)
    {
        $memberBatch = MemberBatch::where('member_batch_uu',$id)->first();
        if($memberBatch && $memberBatch->file){
            return "<img src='".$memberBatch->file->fileUrl('filename')."' />";
        }

        return abort(404);
    }
}
