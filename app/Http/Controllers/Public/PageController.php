<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Exhibition;
use App\Models\Page;
use App\Models\SiteSetting;
use App\Models\Space;
use App\Models\Call;
use App\Models\MediaItem;
use App\Models\PressItem;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Person;
use App\Models\Partner;
use App\Models\Workshop;


class PageController extends Controller
{
    public function home()
    {
        $siteSetting = SiteSetting::first();

        $featuredEvents = Event::query()
            ->with(['activityType', 'space'])
            ->where('status', 'published')
            ->upcoming()
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->limit(6)
            ->get();

        $featuredExhibitions = Exhibition::query()
            ->whereIn('status', ['current', 'upcoming'])
            ->orderByDesc('start_date')
            ->limit(3)
            ->get();

        $spaces = Space::query()
            ->with(['images'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();


        $featuredCalls = Call::query()
            ->where('status', 'open')
            ->orderBy('end_date')
            ->limit(4)
            ->get();


        return view('public.home', compact(
            'featuredEvents',
            'featuredExhibitions',
            'spaces',
            'siteSetting',
            'featuredCalls'
        ));
    }

    public function agenda()
    {
        $events = Event::query()
            ->with(['activityType', 'space'])
            ->published()
            ->upcoming()
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->paginate(12);

        return view('public.agenda.index', compact('events'));
    }

    public function memoria()
    {
        $events = Event::query()
            ->with(['activityType', 'space'])
            ->published()
            ->past()
            ->orderByDesc('start_date')
            ->orderByDesc('start_time')
            ->paginate(12);

        return view('public.agenda.memoria', compact('events'));
    }


    public function event(string $slug)
    {
        $event = Event::query()
            ->with([
                'activityType',
                'space',
                'people',
                'categories',
                'tags',
                'filmScreenings.film',
                'workshops.facilitator',
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('public.events.show', compact('event'));
    }

    #Exposiciones
    public function exhibitions()
    {
        $exhibitions = Exhibition::query()
            ->with(['curator'])
            ->whereIn('status', ['current', 'upcoming', 'past'])
            ->orderByDesc('start_date')
            ->paginate(12);

        return view('public.exhibitions.index', compact('exhibitions'));
    }

    public function exhibition(string $slug)
    {
        $exhibition = Exhibition::query()
            ->with([
                'curator',
                'spaces',
                'people',
                'events',
                'artworks.artist',
            ])
            ->where('slug', $slug)
            ->whereIn('status', ['current', 'upcoming', 'past'])
            ->firstOrFail();

        return view('public.exhibitions.show', compact('exhibition'));
    }

    #Espacios
    public function spaces()
    {
        $spaces = Space::query()
            ->with(['images', 'equipment'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('public.spaces.index', compact('spaces'));
    }

    public function space(string $slug)
    {
        $space = Space::query()
            ->with(['images', 'equipment'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.spaces.show', compact('space'));
    }

    #Archivo
    public function archive()
    {
        $mediaItems = MediaItem::query()
            ->with(['tags'])
            ->where('show_in_archive', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'archivo',
                    'label' => 'Archivo',
                    'title' => $item->title,
                    'medium' => $item->medium ?? $item->type ?? null,
                    'author' => $item->author ?? null,
                    'date' => $item->published_at ?? $item->created_at,
                    'date_sort' => $item->published_at ?? $item->created_at,
                    'excerpt' => $item->excerpt ?? $item->description ?? $item->content ?? null,
                    'external_url' => $item->external_url ?? null,
                    'cover_image' => $item->thumbnail_path ?? null,
                    'tags' => $item->tags ?? collect(),
                ];
            });

        $pressItems = PressItem::query()
            ->where('status', 'published')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'prensa',
                    'label' => 'Prensa',
                    'title' => $item->title,
                    'medium' => $item->media_outlet,
                    'author' => $item->author,
                    'date' => $item->published_date,
                    'date_sort' => $item->published_date,
                    'excerpt' => $item->excerpt,
                    'external_url' => $item->external_url,
                    'cover_image' => $item->cover_image,
                    'tags' => collect(),
                ];
            });

        $items = $pressItems
            ->merge($mediaItems)
            ->sortByDesc('date_sort')
            ->values();

        $perPage = 12;
        $page = request()->integer('page', 1);

        $archiveItems = new \Illuminate\Pagination\LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('public.archive.index', compact('archiveItems'));
    }

    #CONVOCATORIAS
    public function calls()
    {
        $calls = Call::query()
            ->whereIn('status', ['open', 'closed'])
            ->orderByRaw("FIELD(status, 'open', 'closed')")
            ->orderByDesc('end_date')
            ->paginate(12);

        return view('public.calls.index', compact('calls'));
    }

    public function call(string $slug)
    {
        $call = Call::query()
            ->where('slug', $slug)
            ->whereIn('status', ['open', 'closed'])
            ->firstOrFail();

        return view('public.calls.show', compact('call'));
    }


    #Contacto
    public function contact()
    {
        $siteSetting = SiteSetting::first();

        return view('public.contact', compact('siteSetting'));
    }


    public function page(string $slug)
    {
        $page = Page::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('public.page', compact('page'));
    }


    public function people()
    {
        $teamPeople = Person::query()
            ->where('is_active', true)
            ->where('role_type', 'team')
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->get();

        $people = Person::query()
            ->where('is_active', true)
            ->where('role_type', '!=', 'team')
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->get();

        return view('public.people.index', compact('teamPeople', 'people'));
    }

    public function person(string $slug)
    {
        $person = Person::query()
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.people.show', compact('person'));
    }

    public function partners()
    {
        $partners = Partner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->groupBy('partner_type');

        return view('public.partners.index', compact('partners'));
    }

    public function workshops()
    {
        $workshops = Workshop::query()
            ->with(['event', 'facilitator'])
            ->whereIn('status', ['published', 'open', 'active'])
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('public.workshops.index', compact('workshops'));
    }

    public function workshop(string $slug)
    {
        $workshop = Workshop::query()
            ->with(['event', 'facilitator'])
            ->where('slug', $slug)
            ->whereIn('status', ['published', 'open', 'active'])
            ->firstOrFail();

        return view('public.workshops.show', compact('workshop'));
    }
}
