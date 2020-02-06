<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait CompanyUserAPITrait
{
    use CustomAPIFunctionTrait;
    /******
     * Verify User API
     * Inputs:UID
     *    
     * Output :Verified user
     * 
     */
    public function verifyUserAPI($params){
        
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/company/role/$params";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=[
                'json' => ['verify'=>true],
                'headers' => $headers,
                'http_errors' => false
            ];
        $response = $client->request('PUT',$url, $data);
        $finalResponse=$this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
        return $finalResponse;       
    }
}
