<?php

namespace App\Http\Controllers;
use App\DataForSeoCache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Input;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Get json from Mocky Service
     *
     * @param $website
     * @return bool|\Illuminate\Http\Client\Response
     */
    public function getResponseFromMocky()
    {
        $api_link = env('API_LINK');

        //Get response from api
        $response = Http::get($api_link);
        if($response){
            return $response->json();
        }
        return false;
    }


    /**
     * Get json from Data For Seo
     *
     * @param $website
     * @return \Illuminate\Http\Client\Response
     */
    public function geRequestToDataForSeo($website)
    {
        $api_username = env('API_USERNAME');
        $api_password = env('API_PASSWORD');
        $api_key = env('API_KEY');
        $api_link = env('API_LINK');

        $response = Http::withBasicAuth($api_username, $api_password)->get($api_link . $website);

        return $response;
    }
}
