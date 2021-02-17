<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use DataTables;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Course::select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('batch', function($row){
                            $btn = '<a href="'.route('admin.batches.index', $row->id).'" class="pointer text-blue-500">'.$row->batches->count().'</a>';
                            return $btn;
                    })
                    ->addColumn('action', function($row){
                            $btn = '<a href="'.route('admin.courses.edit', $row->id).'" class="text-yellow-500">Edit</a>';
                            $btn .= '<a href="'.route('admin.courses.destroy', $row->id).'" class="ml-3 text-red-500">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['batch','action'])
                    ->make(true);
        }

        return view('admin/course-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.course-form');
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
            'description' => '',
        ]);

        Course::create([
            'name'=>$request->name,
            'fee'=>$request->fee,
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
