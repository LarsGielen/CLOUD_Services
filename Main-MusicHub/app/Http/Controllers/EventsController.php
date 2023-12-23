<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventsController extends Controller
{
    /**
     * Show the events view.
     */
    public function index(): View
    {
        $response = Http::get("http://127.0.0.1:5000/api/events");
        $eventData = json_decode($response, false)->events;

        return view('Events.search', [
            'events' => $eventData
        ]);
    }

    /**
     * Show the events view.
     */
    public function filter(Request $request): View
    {
        $url = "";
        switch ($request->post()['SortedBy']) {
            case 'None': 
                $url = "http://127.0.0.1:5000/api/events";
                break;
            case 'Popular': 
                $url = "http://127.0.0.1:5000/api/events/sorted/popular";
                break;
            case 'Alphabetical': 
                $url = "http://127.0.0.1:5000/api/events/sorted/alphabetical";
                break;
            case 'Price': 
                $url = "http://127.0.0.1:5000/api/events/sorted/price";
                break;
            case 'Date': 
                $url = "http://127.0.0.1:5000/api/events/sorted/date";
                break;
            case 'My booked events': 
                $url = "http://127.0.0.1:5000/api/booking/{$request->user()->id} ";
                break;
        }

        if ($request->post()['SortedBy'] == 'My booked events') {
            $eventData = [];
            foreach (json_decode(Http::get($url), false)->bookings as $booking) {
                $eventData = $booking->event;
            }
            $eventData = ['events' => $eventData];
        }
        else {
            $eventData = json_decode(Http::get($url), false)->events;
        }

        return view('Events.search', [
            'events' => $eventData,
            'selectedFilter' => $request->post()['SortedBy']
        ]);
    }

    /**
     * Shows an event in detail
     */
    public function showEvent(string $id, Request $request): View
    {
        $bookingFromUser = null;
        if ($request->user() != null) {
            foreach(json_decode(Http::get("http://127.0.0.1:5000/api/booking/{$request->user()->id}"), false)->bookings as $booking) {
                if ( $booking->event->id == $id ) {
                    $bookingFromUser = $booking;
                }
            }
        }

        return view('Events.event-detail', [
            'event' => json_decode(Http::get("http://127.0.0.1:5000/api/events/{$id}"), false)->event,
            'bookedByUser' => $bookingFromUser,
            'user' => $request->user(),
        ]);
    }

    /**
     * Shows a location in detail
     */
    public function showLocation(string $id, Request $request): View
    {
        return view('Events.location-detail', [
            'location' => json_decode(Http::get("http://127.0.0.1:5000/api/locations/{$id}"), false)->location,
            'events' => json_decode(Http::get("http://127.0.0.1:5000/api/locations/events/{$id}"), false)->events,
            'user' => $request->user(),
        ]);
    }
    
    /**
     * Shows an organizer in detail
     */
    public function showOrganizer(string $id, Request $request): View
    {
        return view('Events.organizer-detail', [
            'organizer' => json_decode(Http::get("http://127.0.0.1:5000/api/organizers/{$id}"), false)->organizer,
            'events' => json_decode(Http::get("http://127.0.0.1:5000/api/organizers/events/{$id}"), false)->events,
            'user' => $request->user(),
        ]);
    }
    
    /**
     * Post to book an event
     */
    public function book(Request $request): View
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("http://127.0.0.1:5000/api/booking", [
            'userID' => (int)$request->user()->id,
            'userEmail'=> $request->post()["userEmail"],
            'ticketAmount'=> (int)$request->post()['ticketAmount'],
            'eventID'=> (int)$request->post()['eventID']
        ]);

        if ($response->getStatusCode() == 404) {
            return view('error', [
                'message'=> 'An error accured while booking your event'
            ]);
        }

        if ($response->getStatusCode() == 400) {

            return view('error', [
                'message'=> json_decode($response, false)->error
            ]);
        }

        return view('Events.event-detail', [
            'event' => json_decode($response, false)->booking->event,
            'bookedByUser' => json_decode($response, false)->booking,
            'user' => $request->user(),
        ]);
    }
}
