<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $data['latestEvents'] = Event::latest('event_at')->simplePaginate(5);

        return view('event-list', $data);
    }

    public function detail($slug)
    {
        $event = Event::where('slug', $slug)->first();
        if (! $event) {
            abort(404);
        }

        if (! $event->is_public) {
            if (! Auth::check()) {
                session(['url.intended' => url()->current()]);

                return redirect()->route('login')->withError('Silahkan login terlebih dahulu');
            } elseif ($event->course && ! $event->isAllowed(Auth::user())) {
                return redirect()->route('event.list')->with('error', 'Anda tidak memiliki akses ke event '.$event->title);
            }
        }

        $event->increment('views');

        $incomingEvents = Event::oldest()->where('event_at', '>=', Carbon::now())->take(3)->get();

        return view('event-detail', ['event' => $event, 'incomingEvents' => $incomingEvents]);
    }
}
