<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Services\EcourseService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(EcourseService $ecourseService, OrderService $orderService, Request $request)
    {
        
        $data['eventCategories'] = Category::where('type', 'event')->get();
        $data['selectedEventCategory'] = $request->has('category') ? $data['eventCategories']->where('slug', $request->category)->first() : $data['eventCategories']->first();
        $data['latest_events'] = $ecourseService->publicEcourses($data['selectedEventCategory']->id);
        $data['activeOrder'] = null;
        if(Auth::check()){
            $data['activeOrder'] = $orderService->activeOrder();
        }

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
