<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    /**
     * Show the events view.
     */
    public function index(): View
    {
        $response = Http::get(config("services.EventsAPI.url") . "/api/events");
        $eventData = json_decode($response, false)->events;

        return view('Events.search', [
            'events' => $eventData
        ]);
    }

    public function createView(): View
    {
        return view('Events.create', [
            'url'=> config("services.EventsAPI.url")
        ]);
    }

    public function create(Request $request): View
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(config("services.EventsAPI.url") . "/api/events", [
            'locationID' => $request->post()['locationID'],
            'organizerID' => $request->post()['organizerID'],
            'date' => $request->post()['date'] . " " . $request->post()['time'],
            'name' => $request->post()['name'],
            'description' => $request->post()['description'],
            'ticketPrice' => $request->post()['ticketPrice'],
            'seats' => $request->post()['seats'],
            'remainingSeats' => $request->post()['seats'],
            'imageURL' => $request->post()['imageURL'],
        ]);

        return $this->showEvent(json_decode($response)->event->id);
    }

    /**
     * Show the events view.
     */
    public function filter(Request $request): View
    {
        $url = "";
        switch ($request->post()['SortedBy']) {
            case 'None': 
                $url = config("services.EventsAPI.url") . "/api/events";
                break;
            case 'Popular': 
                $url = config("services.EventsAPI.url") . "/api/events/sorted/popular";
                break;
            case 'Alphabetical': 
                $url = config("services.EventsAPI.url") . "/api/events/sorted/alphabetical";
                break;
            case 'Price': 
                $url = config("services.EventsAPI.url") . "/api/events/sorted/price";
                break;
            case 'Date': 
                $url = config("services.EventsAPI.url") . "/api/events/sorted/date";
                break;
            case 'My booked events': 
                $url = config("services.EventsAPI.url") . "/api/booking/{$request->user()->id} ";
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
    public function showEvent(string $id): View
    {
        $userID = Auth::user()->id;
        $bookingFromUser = null;
        foreach(json_decode(Http::get(config("services.EventsAPI.url") . "/api/booking/{$userID}"), false)->bookings as $booking) {
            if ( $booking->event->id == $id ) {
                $bookingFromUser = $booking;
            }
        }

        return view('Events.event-detail', [
            'event' => json_decode(Http::get(config("services.EventsAPI.url") . "/api/events/{$id}"), false)->event,
            'bookedByUser' => $bookingFromUser,
            'user' => Auth::user(),
        ]);
    }

    /**
     * Shows a location in detail
     */
    public function showLocation(string $id, Request $request): View
    {
        return view('Events.location-detail', [
            'location' => json_decode(Http::get(config("services.EventsAPI.url") . "/api/locations/{$id}"), false)->location,
            'events' => json_decode(Http::get(config("services.EventsAPI.url") . "/api/locations/events/{$id}"), false)->events,
            'user' => $request->user(),
        ]);
    }
    
    /**
     * Shows an organizer in detail
     */
    public function showOrganizer(string $id, Request $request): View
    {
        return view('Events.organizer-detail', [
            'organizer' => json_decode(Http::get(config("services.EventsAPI.url") . "/api/organizers/{$id}"), false)->organizer,
            'events' => json_decode(Http::get(config("services.EventsAPI.url") . "/api/organizers/events/{$id}"), false)->events,
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
        ])->post(config("services.EventsAPI.url") . "/api/booking", [
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
