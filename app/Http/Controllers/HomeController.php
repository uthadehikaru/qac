<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\System;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $data['testimonials'] = System::where('key','testimonials')->first();
        $data['faqs'] = System::where('key','faqs')->first();
        $data['courses'] = Course::with('batches')->get();
        $data['latest_events'] = Event::latest('event_at')->take(3)->get();
        $data['about_1'] = System::value('about_1');
        $data['about_2'] = System::value('about_2');
        return view('welcome', $data);
    }
}
