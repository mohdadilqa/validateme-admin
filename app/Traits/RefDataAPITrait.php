<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Auth;

trait RefDataAPITrait
{
    use CustomAPIFunctionTrait;
    /*****
     * API for saving Reference Data
     * Request ->JSON DATA
     * RESPONSE->
     * 
     */
    public function refDataUploadAPI($params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/referencedata/bulk";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic B64515a58399170c3AE0AB4ef6',
        ];
        $data=[
                'json' => [
                    'refData' => $params,
                    'createdBy' => "'".Auth::user()->id."'"
                ],
                'headers' => $headers,
                'http_errors' => false
            ];
        $response = $client->request('POST',$url, $data);
        return $this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
    }


    /*****
     * API for saving Reference Data
     * Request ->JSON DATA
     * RESPONSE->
     * 
     */
    public function refDataSaveAPI($request,$params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/referencedata";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=[
                'json' => $params,
                'headers' => $headers,
                'http_errors' => false
            ];
        $response = $client->request('POST',$url, $data);
        return $this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
    }
    /******
     * Get reference data
     * Inputs:pageNo->define page 
     *        limit ->define limit for a page
     * Output :Get all Reference data
     * 
     */
    public function getReferenceData($params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/referencedata?$params";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=['headers' => $headers,'http_errors' => false];
        $response = $client->request('GET',$url, $data);
        return $this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));      
    }

    
    /*****
     * API for getting RDTKey
     * Request ->JSON DATA
     * 
     */
    public function RDTKeyAPI($request,$params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/referencedatatypekeys?key=$params";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=['headers' => $headers,'http_errors' => false];
        $response = $client->request('GET',$url, $data);
        return $this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true)); 
    }
}
