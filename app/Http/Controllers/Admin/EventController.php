<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\File;
use App\Notifications\EventCreated;
use DataTables;
use Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::select('*')->orderBy('event_at','desc');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<a href="'.route('event.detail', $row->slug).'" target="_BLANK" class="ml-3 text-blue-500">View</a>';
                            $btn .= '<a href="'.route('admin.events.edit', $row->id).'" class="ml-3 text-yellow-500">Edit</a>';
                            $btn .= '<a href="#" id="delete-'.$row->id.'" class="delete ml-3 text-red-500" data-id="'.$row->id.'">Delete</a>';
                            return $btn;
                    })
                    ->editColumn('event_at', function ($row){
                        return $row->event_at->format('d M Y H:i');
                    })
                    ->editColumn('is_public', function ($row){
                        return $row->is_public?'Umum':'Khusus Anggota';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin/event-list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['event'] = null;
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
            'is_public' => 'required|boolean',
        ]);

        $slug = Str::slug($request->title.' '.Str::random(5));
        $event = Event::create([
            'title'=>$request->title,
            'slug'=>$slug,
            'event_at'=>$request->event_at,
            'content'=>$request->content,
            'is_public'=>$request->is_public,
        ]);

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
            'is_public' => 'required|boolean',
        ]);

        $event = Event::find($id);
        $event->update([
            'title'=>$request->title,
            'event_at'=>$request->event_at,
            'content'=>$request->content,
            'is_public'=>$request->is_public,
        ]);

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
}
