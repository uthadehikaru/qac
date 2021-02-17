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
                    ->editColumn('start_at', function($row){
                        $value = $row->start_at?$row->start_at->format('d-M-Y'):'';
                        $value .= $row->end_at?' s/d '.$row->end_at->format('d-M-Y'):'';
                        return $value;
                    })
                    ->editColumn('registration_start_at', function($row){
                        $value = $row->registration_start_at?$row->registration_start_at->format('d-M-Y'):'';
                        $value .= $row->registration_end_at?' s/d '.$row->registration_end_at->format('d-M-Y'):'';
                        return $value;
                    })
                    ->addColumn('members', function($row){
                        $btn = $row->members->count();
                        return $btn;
                    })
                    ->addColumn('action', function($row) use($course_id){
                        $btn = '<a href="'.route('admin.courses.batches.members', ['course'=>$course_id,'batch'=>$row->id]).'" class="text-blue-500">Members</a>';
                        $btn .= '<a href="'.route('admin.courses.batches.edit', ['course'=>$course_id,'batch'=>$row->id]).'" class="ml-3 text-yellow-500">Edit</a>';
                        $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';
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
        $data['batch'] = null;
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
            'start_at' => 'date|after_or_equal:registration_end_at',
            'end_at' => 'date|after_or_equal:start_at',
            'registration_start_at' => 'date|after_or_equal:today',
            'registration_end_at' => 'date|after_or_equal:registration_start_at',
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

        return redirect()->route('admin.courses.batches.index', $course_id)->with('status','Batch created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($course_id, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id, $id)
    {
        $data['course_id'] = $course_id;
        $data['batch'] = Batch::find($id);
        return view('admin.batch-form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_id, $id)
    {
        $request->validate([
            'description' => 'required|string',
            'start_at' => 'date|after_or_equal:today',
            'end_at' => 'date|after_or_equal:start_at',
            'registration_start_at' => 'date|after_or_equal:today',
            'registration_end_at' => 'date|after_or_equal:registration_start_at',
        ]);

        Batch::where('id',$id)->update([
            'description'=>$request->description,
            'start_at'=>$request->start_at,
            'end_at'=>$request->end_at,
            'registration_start_at'=>$request->registration_start_at,
            'registration_end_at'=>$request->registration_end_at,
        ]);

        return redirect()->route('admin.courses.batches.index', $course_id)->with('status','Batch created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_id, $id)
    {
        $batch = Batch::find($id);
        
        if($batch){
            $batch->delete();
            return response()->json(['status'=>'Deleted successfully']);
        }else
            return response()->json(['status'=>'No Batch Found for id '.$id], 404);
    }
}
