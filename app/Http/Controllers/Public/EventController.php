<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['activityType', 'space'])
            ->published()
            ->upcoming()
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();

        return view('public.events.index', compact('events'));
    }

   public function show(Event $event)
{
    abort_unless($event->status === 'published', 404);

    $event->load(['activityType', 'space']);

    if ($event->activityType?->slug === 'cineclub') {
        return view('public.events.cineclub-show', compact('event'));
    }

    return view('public.events.show', compact('event'));
}
}