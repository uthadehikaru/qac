<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ecourse;
use App\Services\EcourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EcourseController extends Controller
{
    public function index(EcourseService $ecourseService, Request $request)
    {
        $data['ecourses'] = [];
        if ($request->category) {
            $data['ecourses'] = $ecourseService->publishedEcourses($request->category);
        }else{
            $data['ecourses'] = $ecourseService->recommendedEcourses();
        }

        $data['categories'] = Category::where('type', 'course')->get();
        $data['selected_category'] = $request->category;

        return view('ecourse-list', $data);
    }

    public function show(EcourseService $ecourseService, Ecourse $ecourse)
    {
        if(!Auth::check()) {
            session()->put('url.intended', route('ecourses.index'));
            return redirect()->route('login')->with('error', 'Silakan login/daftar terlebih dahulu untuk mengakses program ini');
        }
        if (! $ecourse->published) {
            return abort(404);
        }

        $data['ecourse'] = $ecourse;
        $data['order'] = $ecourseService->memberOrder();
        $data['ecourses'] = $ecourseService->latestEcourses(3);

        return view('ecourse-detail', $data);
    }
}
