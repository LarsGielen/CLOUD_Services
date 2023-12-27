<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MessageController extends Controller
{
    /**
     * Show the Message view.
     */
    public function index(): View
    {
        return view('Messages.main', [
            'messageServerUrl' => config('services.MessageService.url')
        ]);
    }
}
