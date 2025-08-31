<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ecourse;
use App\Services\EcourseService;
use App\Services\MemberService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EcourseController extends Controller
{
    public function index(EcourseService $ecourseService, OrderService $orderService, MemberService $memberService, Request $request)
    {
        $data['ecourses'] = [];
        if ($request->category) {
            $data['ecourses'] = $ecourseService->publishedEcourses($request->category);
        }else{
            $data['ecourses'] = $ecourseService->recommendedEcourses();
        }
        $data['activeOrder'] = null;
        if(Auth::check()){
            $data['activeOrder'] = $orderService->activeOrder();
        }

        $data['isAlumni'] = false;
        if(Auth::check() && Auth::user()->member){
            $data['isAlumni'] = $memberService->isAlumni(Auth::user()->member->id);
        }

        $data['categories'] = Category::where('type', 'course')->get();
        $data['selected_category'] = $request->category;

        return view('ecourse-list', $data);
    }

    public function show(EcourseService $ecourseService, Ecourse $ecourse, MemberService $memberService)
    {
        if(!Auth::check()) {
            session()->put('url.intended', route('ecourses.index'));
            return redirect()->route('login')->with('error', 'Silakan login/daftar terlebih dahulu untuk mengakses program ini');
        }
        if (! $ecourse->published) {
            return abort(404);
        }
        $isAlumni = $memberService->isAlumni(Auth::user()->member?->id);
        if($ecourse->level >= 1 && !$isAlumni){
            return back()->with('error', 'Kamu belum menjadi alumni QAC, silakan daftar QAC 1.0 Lite 1b terlebih dahulu');
        }

        $data['ecourse'] = $ecourse;
        $data['order'] = $ecourseService->memberOrder();
        $data['ecourses'] = $ecourseService->latestEcourses(3);

        return view('ecourse-detail', $data);
    }
}
