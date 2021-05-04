<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\DataTables\CourseDataTable;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CourseDataTable $dataTable)
    {
        $data['title'] = "Data Anggota";
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
            'fee' => 'required|numeric|min:0',
            'level' => 'required|numeric|min:1',
            'description' => 'required',
        ]);

        Course::create([
            'name'=>$request->name,
            'fee'=>$request->fee,
            'level'=>$request->level,
            'description'=>$request->description,
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
            'fee' => 'required|numeric|min:0',
            'level' => 'required|numeric|min:1',
            'description' => 'required',
        ]);

        Course::where('id',$id)->update([
            'name'=>$request->name,
            'fee'=>$request->fee,
            'level'=>$request->level,
            'description'=>$request->description,
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
