<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\QueueDataTable;
use App\Models\Course;
use App\Models\Queue;
use App\Models\Member;
use App\Models\MemberBatch;
use App\Models\Batch;
use DB;
use App\Notifications\MemberBatchRegistration;

class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(QueueDataTable $dataTable, $course_id)
    {
        $course = Course::find($course_id);
        $data['title'] = 'Data Waiting List - <a href="'.route('admin.courses.index').'" class="pointer text-blue-500">Kelas '.$course->name.'</a>';

        $data['buttons'] = [];
        $batch = $course->batches()->open()->first();
        if($batch){
            $data['buttons'][] = [
                'name'=>'Send Invitation Batch '.$batch->name,
                'href'=>route('admin.courses.batches.invite.waitinglist',[$course_id, $batch->id]),
            ];
        }
        
        $dataTable->setCourse($course_id);
        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id)
    {
        $data['course'] = Course::find($course_id);
        $data['members'] = Member::whereNotExists(function($query)use($course_id)
            {
                $query->select(DB::raw(1))
                    ->from('queues')
                    ->whereRaw('queues.member_id=members.id and queues.course_id='.$course_id);
            })->orderBy('full_name')->get();
        return view('admin.queue-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $course_id)
    {
        Queue::create([
            'course_id'=>$course_id,
            'member_id'=>$request->member_id,
        ]);

        return redirect()->route('admin.courses.queues.index', $course_id)->with('message','Added successfully');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_id, $id)
    {
        Queue::find($id)->delete();
        return response()->json(['status'=>'Deleted successfully']);
    }

    public function register($course_id, $id)
    {
        $queue = Queue::find($id);

        $openBatch = Batch::open()->where('course_id',$course_id)->first();
        if(!$openBatch)
            return back()->with('error','No open batch available');
        
        $data = [
            'batch_id'=>$openBatch->id,
            'status'=>1,
            'member_id'=>$queue->member_id,
        ];
        
        $memberBatch = MemberBatch::create($data);
        if($memberBatch)
            $queue->member->user->notify(new MemberBatchRegistration($memberBatch));

        $queue->delete();
        
        return back()->with('message',$queue->member->full_name.' registered to '.$openBatch->full_name);
    }
}
