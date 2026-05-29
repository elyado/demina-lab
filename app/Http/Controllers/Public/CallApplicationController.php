<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\CallApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CallApplicationController extends Controller
{
    public function create()
    {
        return view('public.calls.gatillo-form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:80'],
            'whatsapp' => ['nullable', 'string', 'max:80'],
            'pseudonym' => ['nullable', 'string', 'max:180'],

            'capture_year' => ['nullable', 'string', 'max:50'],
            'technique_support' => ['nullable', 'string', 'max:255'],
            'dimensions' => ['nullable', 'string', 'max:255'],
            'edition' => ['nullable', 'string', 'max:255'],
            'production_cost' => ['nullable', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],

            'intention_note' => ['nullable', 'string', 'max:1200'],
            'bio' => ['nullable', 'string'],

            'photo_titles' => ['required', 'array', 'max:3'],
            'photo_titles.0' => ['required', 'string', 'max:220'],
            'photo_titles.1' => ['nullable', 'string', 'max:220'],
            'photo_titles.2' => ['nullable', 'string', 'max:220'],

            'photos' => ['required', 'array', 'max:3'],
            'photos.0' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'photos.1' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'photos.2' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $application = DB::transaction(function () use ($request, $validated) {
            $application = CallApplication::create([
                'folio' => $this->generateFolio(),
                'call_name' => 'Convocatoria Fotográfica Gatillo',
                'name' => $validated['name'],
                'age' => $validated['age'] ?? null,
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'whatsapp' => $validated['whatsapp'] ?? null,
                'pseudonym' => $validated['pseudonym'] ?? null,
                'capture_year' => $validated['capture_year'] ?? null,
                'technique_support' => $validated['technique_support'] ?? null,
                'dimensions' => $validated['dimensions'] ?? null,
                'edition' => $validated['edition'] ?? null,
                'production_cost' => $validated['production_cost'] ?? null,
                'sale_price' => $validated['sale_price'] ?? null,
                'intention_note' => $validated['intention_note'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'status' => 'received',
                'submitted_at' => now(),
            ]);

            foreach ($request->file('photos', []) as $index => $photo) {
                if (! $photo) {
                    continue;
                }

                $path = $photo->store(
                    'gatillo/' . $application->folio,
                    'r2'
                );

                $application->photos()->create([
                    'title' => $validated['photo_titles'][$index] ?? 'Sin título',
                    'file_path' => $path,
                    'original_filename' => $photo->getClientOriginalName(),
                    'mime_type' => $photo->getMimeType(),
                    'size' => $photo->getSize(),
                    'sort_order' => $index + 1,
                ]);
            }

            return $application;
        });

        return redirect()->route('gatillo.thanks', $application->folio);
    }

    public function thanks(string $folio)
    {
        $application = CallApplication::where('folio', $folio)->firstOrFail();

        return view('public.calls.gatillo-thanks', compact('application'));
    }

    private function generateFolio(): string
    {
        $year = now()->year;

        $next = CallApplication::whereYear('created_at', $year)->count() + 1;

        return 'GATILLO-' . $year . '-' . str_pad((string) $next, 4, '0', STR_PAD_LEFT);
    }
}
