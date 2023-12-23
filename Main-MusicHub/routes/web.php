<?php

use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', function () {
    return view('home.home');
})->name('home');

// Instrument Library API- GraphQL
Route::get('/instruments', [InstrumentController::class, 'index'])->name('instruments.index');
Route::post('/instruments', [InstrumentController::class, 'filter'])->name('instruments.filter');
Route::get('/instruments/{id}', [InstrumentController::class, 'show'])->name('instruments.show');

// Event Booking API - REST
Route::get('/events', [EventsController::class, 'index'])->name('events.index');
Route::post('/events/filter', [EventsController::class, 'filter'])->name('events.filter');
Route::get('/events/{id}', [EventsController::class, 'showEvent'])->name('events.show.event');
Route::get('/events/locations/{id}', [EventsController::class, 'showLocation'])->name('events.show.location');
Route::get('/events/organizers/{id}', [EventsController::class, 'showOrganizer'])->name('events.show.organizer');
Route::post('/events/book', [EventsController::class, 'book'])->name('events.book')->middleware('auth');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
