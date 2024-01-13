<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SoapClient;


class HomeController extends Controller
{
    /**
     * Show the Home page.
     */
    public function show(): View
    {
        if (!Auth::check()) { 
            return view('Home.home');
        }

        $userID = Auth::user()->id;
        $userName = Auth::user()->name;

        // user instrument posts
        $instrumentQuery = <<<'EOD'
        query($sellerUserName: String) {
            filterInstrumentPosts(sellerUserName: $sellerUserName) {
                id
                title
                price
            }
        }
        EOD;

        $instrumentVariables = array (
            "sellerUserName" => $userName
        );

        $instrumentResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(config("services.InstrumentLibraryAPI.url"), [
            'query' => $instrumentQuery,
            'variables' => $instrumentVariables
        ]);

        $userInstrumentPosts = json_decode($instrumentResponse, false)->data->filterInstrumentPosts;

        // popular events
        $url = config("services.EventBookingAPI.url") . "/api/events/sorted/popular/3";
        $popularEventData = json_decode(Http::get($url), false)->events;

        // user events
        $url = config("services.EventBookingAPI.url") . "/api/booking/{$userID}";
        $userEventData = [];
        $userEventData = null;
        foreach (json_decode(Http::get($url), false)->bookings as $booking) {
            $eventData = $booking->event;
        }
        if (isset($eventData)) {
            $userEventData = ['events' => $eventData];
        }

        // user sheetMusic
        $soapClient = new SoapClient(config('services.sheetmusicAPI.wsdl'));
        $userSheetMusic = (new SheetMusicController)->convertSheetsMusicToObject($soapClient->getMusicByUserID ($userID));

        return view('Home.home', [
            'userInstrumentPosts'=> $userInstrumentPosts,
            'popularEvents' => $popularEventData,
            'userEvents' => $userEventData,
            'userSheetMusic'=> $userSheetMusic
        ]);
    }
}
