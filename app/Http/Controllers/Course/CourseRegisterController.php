<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;

class CourseRegisterController extends Controller
{
    public function index($course_id, $batch_id = null)
    {
        if(!Auth::check()) {
            session()->put('url.intended', route('kelas.register', ['course_id' => $course_id, 'batch_id' => $batch_id]));
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu untuk melanjutkan pendaftaran');
        }
        $data['course'] = Course::find($course_id);
        $data['batch'] = Batch::find($batch_id);
        $data['provinces'] = Province::orderBy('name')->get();
        return view('kelas.register', $data);
    }
}