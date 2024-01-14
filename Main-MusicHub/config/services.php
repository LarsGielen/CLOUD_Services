<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'SheetMusicAPI'=> [
        'url' => "http://" . env('API_URL_SHEETMUSIC', "localhost:5050"),
        'wsdl' => "http://" . env('API_URL_SHEETMUSIC', "localhost:5050") . "/SheetMusicAPI.php?wsdl",
    ],

    'InstrumentLibraryAPI'=> [
        'url' => "http://" . env('API_URL_INSTRUMENTLIBRARY', "localhost:5051"),
    ],
    
    'MessageAPI'=> [
        'url' => "http://" . env('API_URL_MESSAGESERVICE', "localhost:5052"),
    ],

    'EventBookingAPI'=> [
        'url' => "http://" . env('API_URL_EVENTBOOKING', "localhost:5053"),
    ],

    'MusicSessionService'=> [
        'url' => "ws://" . env('API_URL_MUSICSESSION', "localhost:5054") . "/ws",
    ],

    'TunerService'=> [
        'url' => "wss://" . env('API_URL_TUNERSERVICE', "c3a83306c2b24c68835c34e6983a57b1.s2.eu.hivemq.cloud:8884/mqtt"),
    ],
];
