<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $data['courses'] = Course::with('batches')->get();
        return view('welcome', $data);
    }
}
