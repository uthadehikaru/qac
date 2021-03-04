<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\System;

class HomeController extends Controller
{
    public function index()
    {
        $data['testimonials'] = System::where('key','testimonials')->first();
        $data['faqs'] = System::where('key','faqs')->first();
        $data['courses'] = Course::with('batches')->get();
        return view('welcome', $data);
    }
}
