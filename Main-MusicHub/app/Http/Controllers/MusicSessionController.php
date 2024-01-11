<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MusicSessionController extends Controller
{
    /**
     * Show the Message view.
     */
    public function join(): View
    {
        return view('MusicSession.join', [ ]);
    }
}
