<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\User;
use Illuminate\Http\Request;
use SoapClient;

class SheetMusicController extends Controller
{
    /**
     * Show the sheet music view.
     */
    public function index(): View
    {
        // create a new soap client from the wsdl file provided by the service
        $soapClient = new SoapClient(config('services.sheetmusicAPI.wsdl'));

        // call the function via the soap client and get the response
        $data = $this->convertSheetsMusicToObject($soapClient->getMusic());

        return view("SheetMusic.search", [
            "SheetMusics"=> $data,
            "searchTitle" => ""
        ]);
    }

    /**
     * Show the sheet music view filtered on title.
     */
    public function filter(Request $request): View
    {
        $title = $request->post()['title'];

        // create a new soap client from the wsdl file provided by the service
        $soapClient = new SoapClient(config('services.sheetmusicAPI.wsdl'));

        // call the function via the soap client and get the response
        $data = $this->convertSheetsMusicToObject($soapClient->getMusicLikeTitle($title));

        return view("SheetMusic.search", [
            "SheetMusics"=> $data,
            "searchTitle" => $title
        ]);
    }

    /**
     * Show the details of a music sheet.
     */
    public function show(int $id): View
    {
        // create a new soap client from the wsdl file provided by the service
        $soapClient = new SoapClient(config('services.sheetmusicAPI.wsdl'));

        // call the function via the soap client and get the response
        $data = $this->convertSheetsMusicToObject($soapClient->getMusicByID($id))[0];
        $otherMusicFromUser = $this->convertSheetsMusicToObject($soapClient->getMusicByUserID ($data->userID));

        return view("SheetMusic.detail", [
            "SheetMusic"=> $data,
            "sheetMusicfromComposer" => $otherMusicFromUser,
            "messageServerUrl" => config("services.MessageService.url")
        ]);
    }

    /**
     * Show the details of a music sheet.
     */
    public function generatePDF(int $id)
    {
        // create a new soap client from the wsdl file provided by the service
        $soapClient = new SoapClient(config('services.sheetmusicAPI.wsdl'));

        // call the function via the soap client and get the response
        $link = json_decode($soapClient->convertMusicToPdfById($id))->data;

        return response()->json(['link' => config('services.sheetmusicAPI.url') . "/" . $link]);
    }

    public function convertSheetsMusicToObject($sheetMusicString) 
    {
        // convert to object
        $data = json_decode(str_replace('\n', '\\\\n', $sheetMusicString))->data;

        // Iterate through each object in the array and add the 'username' property
        foreach ($data as $sheetMusic) {
            $user = User::find($sheetMusic->userID);
            $sheetMusic->username = $user == null ? "unknown user" : $user->name;
        }

        return $data;
    }
}
