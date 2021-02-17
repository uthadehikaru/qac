<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Batch;
use DataTables;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $course_id)
    {
        if ($request->ajax()) {
            $data = Batch::select('*')->where('course_id',$course_id);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('start_at', '{{$start_at}} - {{$end_at}}')
                    ->editColumn('registration_start_at', '{{$registration_start_at}} - {{$registration_end_at}}')
                    ->addColumn('members', function($row){
                            $btn = $row->members->count();
                            return $btn;
                    })
                    ->addColumn('action', function($row){
                            $btn = '<a href="'.route('admin.courses.edit', $row->id).'" class="text-yellow-500">Edit</a>';
                            $btn .= '<a href="'.route('admin.courses.destroy', $row->id).'" class="ml-3 text-red-500">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $data['course'] = Course::find($course_id);
        return view('admin/batch-list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id)
    {
        $data['course_id'] = $course_id;
        return view('admin.batch-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $course_id)
    {
        $request->validate([
            'description' => 'required|string',
        ]);

        $batch_no = Batch::where('course_id', $course_id)->count();
        $batch_no++;

        Batch::create([
            'course_id'=>$course_id,
            'batch_no'=>$batch_no,
            'description'=>$request->description,
            'start_at'=>$request->start_at,
            'end_at'=>$request->end_at,
            'registration_start_at'=>$request->registration_start_at,
            'registration_end_at'=>$request->registration_end_at,
        ]);

        return redirect()->route('admin.batches.index', $course_id)->with('status','Course created');
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
