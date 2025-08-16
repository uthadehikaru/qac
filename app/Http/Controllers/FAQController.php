<?php

namespace App\Http\Controllers;

use App\Models\System;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        $faq = System::value('faq');
        
        return view('faq', compact('faq'));
    }
}
