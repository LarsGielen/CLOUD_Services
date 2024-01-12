<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class InstrumentController extends Controller
{
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
                    imageUrl
                }
            }
        EOD;

        $filteredinstrumentTypes = <<<'EOD'
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
            'query' => $filteredinstrumentTypes
        ]);
        
        $instrumentPosts = json_decode($instrumentResponse)->data->instrumentPosts;
        $filteredinstrumentTypes = json_decode($instrumentTypeResponse)->data->instrumentTypes;

        return view('Instruments.search', [
            'instrumentPosts' => $instrumentPosts,
            'filteredinstrumentTypes' => $filteredinstrumentTypes,
            'instrumentTypes' => $filteredinstrumentTypes,
            'selectedFilters' => $selectedFilters,
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

        $filteredinstrumentTypes = json_decode($instrumentTypeResponse, false)->data->filterInstrumentTypes;

        $found = false;
        foreach ($filteredinstrumentTypes as $instrument) {
            if ($instrument->name === $selectedFilters['instrumentType']) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $selectedFilters['instrumentType'] = "All";
        }

        $instrumentTypes = <<<'EOD'
            query {
                instrumentTypes {
                    name
                }
            }
        EOD;
        $instrumentTypeResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://localhost:4000/', [
            'query' => $instrumentTypes
        ]);

        // Get InstrumentPosts
        $instrumentQuery = <<<'EOD'
            query($instrumentFamily: InstrumentFamily, $instrumentType: String, $priceMin: Int, $priceMax: Int, $condition: InstrumentCondition, $locationName: String, $sellerUserName: String) {
                filterInstrumentPosts(instrumentFamily: $instrumentFamily instrumentType: $instrumentType priceMin: $priceMin priceMax: $priceMax condition: $condition locationName: $locationName sellerUserName: $sellerUserName) {
                    id
                    title
                    price
                    imageUrl
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
            'filteredinstrumentTypes' => $filteredinstrumentTypes,
            'instrumentTypes' => $instrumentTypes,
            'selectedFilters' => $selectedFilters
        ]);
    }

    public function show(string $id): View
    {
        $query = <<<'EOD'
            query ($instrumentPostwithIdId: ID!) {
                instrumentPostwithID(id: $instrumentPostwithIdId) {
                    id
                    title
                    price
                    description
                    imageUrl
                    condition
                    age
                    type {
                        name
                        family
                        instrumentsForSale {
                            id
                            title
                            price
                            imageUrl
                        }
                    }
                    location {
                        city
                    }
                    seller {
                        userName
                        userID
                        email
                        instrumentsForSale {
                            id
                            title
                            price
                            imageUrl
                        }
                    }
                }
            }
        EOD;;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://localhost:4000/', [
            'query' => $query,
            'variables' => array("instrumentPostwithIdId" => $id)
        ]);

        $instrumentPost = json_decode($response)->data->instrumentPostwithID;

        return view('Instruments.detail', [
            'post'=> $instrumentPost,
            'messageServerUrl' => config('services.MessageService.url')
        ]);
    }

    public function create(Request $request): View
    {
        $postOptions = $request->post();

        $instrumentQuery = <<<'EOD'
            mutation (
                $title: String!
                $description: String!
                $imageUrl: String!
                $type: String!
                $age: Int!
                $condition: InstrumentCondition!
                $price: Float!
                $location: LocationInput!
                $seller: UserInput!
            ) {
                createInstrumentPost(
                title: $title
                description: $description
                imageUrl: $imageUrl
                type: $type
                age: $age
                condition: $condition
                price: $price
                location: $location
                seller: $seller
                ) {
                id
                title
                price
                description
                imageUrl
                condition
                age
                type {
                    name
                    family
                    instrumentsForSale {
                    id
                    title
                    price
                    imageUrl
                    }
                }
                location {
                    city
                }
                seller {
                    userName
                    userID
                    email
                    instrumentsForSale {
                    id
                    title
                    price
                    imageUrl
                    }
                }
                }
            }
        EOD;

        $instrumentVariables = array (
            "title" => $postOptions['title'],
            "description" => $postOptions['description'],  
            "imageUrl" => $postOptions['imageUrl'],
            "type" => strtoupper($postOptions['type']),  
            "age" => (int)$postOptions['age'],
            "condition" => strtoupper($postOptions['condition']),  
            "price" => (int)$postOptions['price'],
            "location" => array(
              "city" => $postOptions['location']
            ),
            "seller" => array (
              "userID" => Auth::user()->id,
              "userName" => Auth::user()->name,
              "email" => Auth::user()->email,
            )
        );

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://localhost:4000/', [
            'query' => $instrumentQuery,
            'variables' => $instrumentVariables
        ]);

        $post = json_decode($response)->data->createInstrumentPost;
        return view('Instruments.detail', [
            'post' => $post,
            'messageServerUrl' => config('services.MessageService.url')
        ]);
    }

    public function delete(string $id)
    {
        $query = <<<'EOD'
            mutation($postId: Int!) {
                deleteInstrumentPost(postID: $postId) {
                title
                }
            }
        EOD;;

        Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://localhost:4000/', [
            'query' => $query,
            'variables' => array("postId" => (int)$id)
        ]);

        return redirect()->route('instruments.index');
    }
}
