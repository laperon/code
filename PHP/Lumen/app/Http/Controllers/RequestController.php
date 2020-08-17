<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ApiController;

use App\RequestEmail;
use App\DataForSeoCache;


class RequestController extends Controller
{
    protected $maiSender;

    protected $api;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MailController $mail, ApiController $api)
    {
        $this->maiSender = $mail;
        $this->api = $api;
    }

    /**
     * Get Hash from url
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory or data
     */
    public function getHash(Request $request)
    {
        $hash = $request->input('hash_id');
        $record = DataForSeoCache::where('hash_id' , $hash)
            ->orderBy('api_request_date', 'desc')
            ->first();

        if($record){
            return response($record->data, 200);
        }
        return response('data was not found', 500);
    }

    /**
     * Main Request
     *
     * @param  Request  $request
     * @return bool|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function getRequest(Request $request)
    {
        $website = parse_url($request->input('website'));
        $email = $request->input('email');
        $hash_id = hash('sha256', time() . rand());
        $dataForSeoModel = new DataForSeoCache();
        $requestEmailModel = new RequestEmail();

        $requestEmailModel->email = $email;
        $requestEmailModel->website = $website['host'];
        $requestEmailModel->save();

        $checkHash = $dataForSeoModel->getDataByWebsite($website['host']);
        if(count($checkHash)>0){
            $hashId = $checkHash[0]->hash_id;
            $mail = $this->maiSender->sendUserEmail($hashId, $email);
        } else {
            $dataForSeoModel->website = $website['host'];
            $dataForSeoModel->hash_id = $hash_id;
            $dataForSeoModel->data = json_encode($this->getDataFromServiceApi());
            $dataForSeoModel->save();

            if(!$dataForSeoModel) {
                return response('The request can\'t be done', 500);
            }
            $mail = $this->maiSender->sendUserEmail($hash_id, $email);
        }

        if($mail != null){
            response($mail);
        }

        return response('The request success' , 200);
    }

    /**
     * Get data from API
     *
     * @return bool|\Illuminate\Http\Client\Response|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function getDataFromServiceApi()
    {
        $response = $this->api->getResponseFromMocky();
        if(empty($response)) {
            return response('The data was not found', 500);
        }
        return response($response , '200');
    }
}
