<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Course;
use App\Models\Ecourse;
use App\Models\Event;
use App\Models\MemberBatch;
use App\Models\System;
use App\Services\EcourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function index(EcourseService $ecourseService, Request $request)
    {
        $data['banners'] = Banner::where('is_active', 1)->get();
        $data['categories'] = Category::where('type', 'course')->get();
        $data['eventCategories'] = Category::where('type', 'event')->get();
        $data['selectedEventCategory'] = $data['eventCategories']->first();
        $data['testimonials'] = MemberBatch::testimonial()->take(3)->get();
        $data['courses'] = Course::with('batches')->active()->get();
        $data['ecourses'] = Ecourse::latest()->take(4)->get();
        $data['latest_ecourses'] = $ecourseService->recommendedEcourses();
        $data['latest_events'] = $ecourseService->publicEcourses($data['selectedEventCategory']->id);
        $data['about_1'] = System::value('about_1');
        $data['about_2'] = System::value('about_2');
        $data['waitinglist'] = System::value('waitinglist');
        $data['why1'] = System::where('key', 'why1')->first();
        $data['why2'] = System::where('key', 'why2')->first();
        $popup_active = System::value('popup_active');
        $data['popup_image'] = null;
        $displayedBanner = $request->cookie('displayed_banner', false);
        if ($popup_active && ! $displayedBanner) {
            $data['popup_image'] = System::value('popup_image');
            Cookie::queue('displayed_banner', true, 60);
        }

        return view('welcome', $data);
    }

    public function testimonials()
    {
        $data['testimonials'] = MemberBatch::testimonial()->paginate(9);

        return view('testimonial-list', $data);
    }

    public function certificate($id)
    {
        $memberBatch = MemberBatch::where('member_batch_uu', $id)->first();
        if ($memberBatch && $memberBatch->file) {
            return "<img src='".$memberBatch->file->fileUrl('filename')."' />";
        }

        return abort(404);
    }
}
