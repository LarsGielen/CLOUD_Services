<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TunerController extends Controller
{
    /**
     * Show the Message view.
     */
    public function show(): View
    {
        return view('Tuner.tuner', [ 
            'url' => config('services.TunerService.url')
        ]);
    }
}
