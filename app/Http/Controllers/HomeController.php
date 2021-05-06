<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\System;
use App\Models\Event;
use App\Models\MemberBatch;

class HomeController extends Controller
{
    public function index()
    {
        $data['testimonials'] = MemberBatch::testimonial()->take(3)->get();
        $data['faqs'] = System::where('key','faqs')->first();
        $data['courses'] = Course::with('batches')->get();
        $data['latest_events'] = Event::latest('event_at')->take(3)->get();
        $data['about_1'] = System::value('about_1');
        $data['about_2'] = System::value('about_2');
        return view('welcome', $data);
    }

    public function testimonials()
    {
        $data['testimonials'] = MemberBatch::testimonial()->paginate(9);
        return view('testimonial-list', $data);
    }
}
