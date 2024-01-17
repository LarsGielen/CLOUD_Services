<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MusicSessionController;
use App\Http\Controllers\OpenopusWikiController;
use App\Http\Controllers\TunerController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SheetMusicController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', [HomeController::class,'show'])->name('home');

// Instrument Library API- GraphQL
Route::get('/instruments', [InstrumentController::class, 'index'])->name('instruments.index');
Route::post('/instruments', [InstrumentController::class, 'filter'])->name('instruments.filter');
Route::get('/instruments/{id}', [InstrumentController::class, 'show'])->name('instruments.show')->middleware('auth');
Route::post('/instruments/create', [InstrumentController::class, 'create'])->name('instruments.create')->middleware('auth');
Route::get('/instruments/delete/{id}', [InstrumentController::class, 'delete'])->name('instruments.delete')->middleware('auth');

// Event Booking API - REST
Route::get('/events', [EventsController::class, 'index'])->name('events.index');
Route::post('/events', [EventsController::class, 'filter'])->name('events.filter');
Route::get('/events/create', [EventsController::class, 'createView'])->name('events.createView')->middleware('auth');
Route::post('/events/create', [EventsController::class, 'create'])->name('events.create')->middleware('auth');
Route::get('/events/{id}', [EventsController::class, 'showEvent'])->name('events.show.event')->middleware('auth');
Route::get('/events/locations/{id}', [EventsController::class, 'showLocation'])->name('events.show.location');
Route::get('/events/organizers/{id}', [EventsController::class, 'showOrganizer'])->name('events.show.organizer');
Route::post('/events/book', [EventsController::class, 'book'])->name('events.book')->middleware('auth');
Route::post('/events/book/cancel', [EventsController::class, 'cancelBooking'])->name('events.cancelbooking')->middleware('auth');

// Sheet Music API - SOAP
Route::get('/sheetmusic', [SheetMusicController::class, 'index'])->name('sheetmusic.index');
Route::post('/sheetmusic', [SheetMusicController::class, 'filter'])->name('sheetmusic.filter');
Route::post('/sheetmusic/create', [SheetMusicController::class, 'create'])->name('sheetmusic.create')->middleware('auth');
Route::get('/sheetmusic/{id}', [SheetMusicController::class, 'show'])->name('sheetmusic.show')->middleware('auth');
Route::get('/sheetmusic/pdf/{id}', [SheetMusicController::class, 'generatePDF'])->name('sheetmusic.generatePDF')->middleware('auth');

// Message Service (gRPC)
Route::get('/messages', [MessageController::class, 'index'])->name('messages.index')->middleware('auth');

// Music Session Service (Websockets)
Route::get('/musicsession', [MusicSessionController::class, 'show'])->name('musicSession.show');

// Tuner Service (MQTT)
Route::get('/tuner', [TunerController::class,'show'])->name('tuner.show');

// Openopus wiki (externe service)
Route::get('/openopus', [OpenopusWikiController::class,'index'])->name('openopus.index');
Route::get('/openopus/{id}', [OpenopusWikiController::class,'show'])->name('openopus.show');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
