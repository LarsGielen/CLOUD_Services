<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OpenopusWikiController extends Controller
{
    public function index(): View
    {
        $composers = json_decode(Http::get(config("services.Openopus.url") . "/composer/list/rec.json"), false)->composers;

        return view('Openopus.main', [
            'composers'=> $composers
        ]);
    }

    public function show(int $id): View
    {
        $composer = json_decode(Http::get(config("services.Openopus.url") . "/composer/list/ids/{$id}.json"), false)->composers[0];
        $works = json_decode(Http::get(config("services.Openopus.url") . "/work/list/composer/{$id}/genre/Popular.json"), false);

        if (property_exists($works, 'works')) {
            $works = $works->works;
        }
        else {
            $works = array();
        }

        return view('Openopus.detail', [
            'composer'=> $composer,
            'works'=> $works
        ]);
    }
}
