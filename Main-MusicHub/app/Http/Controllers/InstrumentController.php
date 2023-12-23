<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstrumentController extends Controller
{
    /**
     * Show the instrument index view.
     */
    public function index(): View
    {
        $selectedFilters = array (
            "instrumentFamily" => "All",
            "instrumentType" => "All",
            "min" => null,
            "max" => null,
            "condition" => "All",
            "sellLocation" => null,
            "sellerUsername" => null
        );

        $instrumentQuery = <<<'EOD'
            query {
                instrumentPosts {
                    id
                    title
                    price
                }
            }
        EOD;

        $instrumentTypes = <<<'EOD'
            query {
                instrumentTypes {
                    name
                }
            }
        EOD;

        $instrumentResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://localhost:4000/', [
            'query' => $instrumentQuery
        ]);

        $instrumentTypeResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://localhost:4000/', [
            'query' => $instrumentTypes
        ]);
        
        $instrumentPosts = json_decode($instrumentResponse)->data->instrumentPosts;
        $instrumentTypes = json_decode($instrumentTypeResponse)->data->instrumentTypes;

        return view('Instruments.search', [
            'instrumentPosts' => $instrumentPosts,
            'instrumentTypes' => $instrumentTypes,
            'selectedFilters' => $selectedFilters
        ]);
    }

    public function filter(Request $request): View
    {
        $selectedFilters = $request->post();

        // Get InstrumentTypes
        $instrumentTypeQuery = <<<'EOD'
            query ($instrumentFamily: InstrumentFamily) {
                filterInstrumentTypes(instrumentFamily: $instrumentFamily) {
                    name
                }
            }
        EOD;

        $instrumentTypeVariables = array (
            "instrumentFamily" => ($selectedFilters["instrumentFamily"] == "All") ? null : $selectedFilters["instrumentFamily"],
        );

        $instrumentTypeResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://localhost:4000/', [
            'query' => $instrumentTypeQuery,
            'variables' => $instrumentTypeVariables
        ]);

        $instrumentTypes = json_decode($instrumentTypeResponse, false)->data->filterInstrumentTypes;

        $found = false;
        foreach ($instrumentTypes as $instrument) {
            if ($instrument->name === $selectedFilters['instrumentType']) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $selectedFilters['instrumentType'] = "All";
        }

        // Get InstrumentPosts
        $instrumentQuery = <<<'EOD'
            query($instrumentFamily: InstrumentFamily, $instrumentType: String, $priceMin: Int, $priceMax: Int, $condition: InstrumentCondition, $locationName: String, $sellerUserName: String) {
                filterInstrumentPosts(instrumentFamily: $instrumentFamily instrumentType: $instrumentType priceMin: $priceMin priceMax: $priceMax condition: $condition locationName: $locationName sellerUserName: $sellerUserName) {
                    id
                    title
                    price
                }
            }
        EOD;

        $instrumentVariables = array (
            "instrumentFamily" => ($selectedFilters["instrumentFamily"] == "All") ? null : $selectedFilters["instrumentFamily"],
            "instrumentType" => ($selectedFilters["instrumentType"] == "All") ? null : $selectedFilters["instrumentType"],
            "priceMin" => (int)$selectedFilters["min"],
            "priceMax" => (int)$selectedFilters["max"],
            "condition" => ($selectedFilters["condition"] == "All") ? null : $selectedFilters["condition"],
            "locationName" => $selectedFilters["sellLocation"],
            "sellerUserName" => $selectedFilters["sellerUsername"]
        );

        $instrumentResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://localhost:4000/', [
            'query' => $instrumentQuery,
            'variables' => $instrumentVariables
        ]);

        $instrumentPosts = json_decode($instrumentResponse, false)->data->filterInstrumentPosts;

        // Return view
        return view('Instruments.search', [
            'instrumentPosts' => $instrumentPosts,
            'instrumentTypes' => $instrumentTypes,
            'selectedFilters' => $selectedFilters
        ]);
    }

    /**
     * Shows an instrument in detail
     */
    public function show(string $id): View
    {
        $query = "
        query {
            instrumentPostwithID(id: $id) {
              id
              title
              price
              description
              condition
              age
              type {
                name
                family
                instrumentsForSale {
                    id
                    title
                    price
                }
              }
              location {
                city
              }
              seller {
                userName
                email
                instrumentsForSale {
                    id
                    title
                    price
                }
              }
            }
          }
        ";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://localhost:4000/', [
            'query' => $query
        ]);

        $instrumentPost = json_decode($response)->data->instrumentPostwithID;

        return view('Instruments.detail', [
            'post'=> $instrumentPost
        ]);
    }
}
