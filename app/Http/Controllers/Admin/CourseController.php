<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\DataTables\CourseDataTable;
use App\DataTables\MemberCourseDataTable;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CourseDataTable $dataTable)
    {
        $data['title'] = "Data Kelas";
        return $dataTable->render('admin.datatable', $data);
    }

    public function members(MemberCourseDataTable $dataTable, $course_id)
    {
        $course = Course::find($course_id);
        $data['title'] = "Data Peserta Kelas ".$course->name;
        $data['button'] = '<a class="ml-3 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 float-right" href="'.route('admin.courses.index').'">Kembali</a>';
        $dataTable->setCourse($course_id);
        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['course'] = null;
        return view('admin.course-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|numeric|min:1',
            'description' => 'required',
        ]);

        Course::create([
            'name'=>$request->name,
            'fee'=>0,
            'level'=>$request->level,
            'description'=>$request->description,
            'is_active'=>$request->is_active,
        ]);

        return redirect()->route('admin.courses.index')->with('status','Course created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['course'] = Course::find($id);
        return view('admin.course-form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|numeric|min:1',
            'description' => 'required',
        ]);

        Course::where('id',$id)->update([
            'name'=>$request->name,
            'fee'=>0,
            'level'=>$request->level,
            'description'=>$request->description,
            'is_active'=>$request->is_active,
        ]);

        return redirect()->route('admin.courses.index')->with('status','Course updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Course::find($id)->delete();

        return response()->json(['status'=>'Deleted successfully']);
    }
}
