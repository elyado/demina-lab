<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\EventController;
use App\Http\Controllers\Public\PageController;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/p/{slug}', [PageController::class, 'page'])->name('public.page');

Route::get('/agenda', [PageController::class, 'agenda'])->name('agenda.index');
Route::get('/exposiciones', [PageController::class, 'exhibitions'])->name('exhibitions.index');
Route::get('/exposiciones/{slug}', [PageController::class, 'exhibition'])->name('exhibitions.show');
Route::get('/espacios', [PageController::class, 'spaces'])->name('spaces.index');
Route::get('/espacios/{slug}', [PageController::class, 'space'])->name('spaces.show');
Route::get('/archivo', [PageController::class, 'archive'])->name('archive.index');
Route::get('/contacto', [PageController::class, 'contact'])->name('contact');
Route::get('/agenda/{event:slug}', [EventController::class, 'show'])
    ->name('events.show');
Route::get('/convocatorias', [PageController::class, 'calls'])->name('calls.index');
Route::get('/convocatorias/{slug}', [PageController::class, 'call'])->name('calls.show');
Route::get('/personas', [PageController::class, 'people'])->name('people.index');
Route::get('/personas/{slug}', [PageController::class, 'person'])->name('people.show');
Route::get('/aliados', [PageController::class, 'partners'])->name('partners.index');
Route::get('/talleres', [PageController::class, 'workshops'])->name('workshops.index');
Route::get('/talleres/{slug}', [PageController::class, 'workshop'])->name('workshops.show');
