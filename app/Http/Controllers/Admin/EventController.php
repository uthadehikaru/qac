<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\File;
use App\Models\Course;
use App\Models\MemberBatch;
use App\Notifications\EventCreated;
use App\DataTables\EventDataTable;
use Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, EventDataTable $dataTable)
    {
        $data['title'] = "Data Event";
        if($request->has('deleted'))
            $dataTable->deleted();
        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['event'] = null;
        $data['courses'] = Course::active()->get();
        return view('admin.event-form', $data);
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
            'title' => 'required|string|max:255',
            'event_at' => 'required|date',
            'content' => 'required',
        ]);

        $is_public = $request->course_id==null;

        $slug = Str::slug($request->title.' '.Str::random(5));
        $data = [
            'title'=>$request->title,
            'slug'=>$slug,
            'event_at'=>$request->event_at,
            'content'=>$request->content,
            'is_public'=>$is_public,
        ];

        if(!$is_public)
            $data['course_id'] = $request->course_id;
        
        $event = Event::create($data);

        return redirect()->route('admin.events.index')->with('status','Event created');
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
        $data['event'] = Event::find($id);
        $data['courses'] = Course::active()->get();
        return view('admin.event-form', $data);
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
            'title' => 'required|string|max:255',
            'event_at' => 'required|date',
            'content' => 'required',
        ]);

        $is_public = $request->course_id==null;

        $event = Event::find($id);
        $data = [
            'title'=>$request->title,
            'event_at'=>$request->event_at,
            'content'=>$request->content,
            'is_public'=>$is_public,
        ];

        if(!$is_public)
            $data['course_id'] = $request->course_id;

        $event->update($data);

        return redirect()->route('admin.events.index')->with('status','Event updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Event::find($id)->delete();
        return response()->json(['status'=>'Deleted successfully']);
    }

    public function share($id)
    {
        $event = Event::find($id);
        $count = 0;
        if($event->course){
            $memberBatches = MemberBatch::with('member.user')
            ->whereRaw("member_batch.status='6' AND EXISTS(SELECT 1 from batches b WHERE b.id=member_batch.batch_id AND b.course_id=".$event->course_id.")" )
            ->orderBy('login_at','desc')
            ->orderBy('updated_at','desc')
            ->get();
            foreach($memberBatches as $memberBatch){
                $memberBatch->member->user->notify(new EventCreated($event));
                $count++;
            }
        }else{
            $users = User::where('role','member')
            ->orderBy('login_at','desc')
            ->orderBy('updated_at','desc')
            ->get();
            foreach($users as $user){
                $user->notify(new EventCreated($event));
                $count++;
            }
        }
        return back()->with('status','Sent event notification to '.$count.' members');
    }
}
