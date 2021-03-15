<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Auth;

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

        if(!$event->is_public && !Auth::check()){
            session(['url.intended' => url()->current()]);
            return redirect()->route('login')->withError('Silahkan login terlebih dahulu');
        }

        $event->increment('views');

        $incomingEvents = Event::oldest()->where('event_at','>=',Carbon::now())->take(3)->get();
        return view('event-detail', ['event'=>$event, 'incomingEvents'=>$incomingEvents]);
    }
}
