<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $data['latestEvents'] = Event::latest('event_at')->simplePaginate(5);
        return view('event-list', $data);
    }

    public function detail($slug)
    {
        $event = Event::where('slug',$slug)->first();
        if(!$event)
            abort(404);
        $event->increment('views');
        return view('event-detail', ['event'=>$event]);
    }
}
