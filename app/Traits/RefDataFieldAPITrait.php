<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Auth;

trait RefDataFieldAPITrait
{
    use RefDataAPITrait;
     /******
     * Field Data Save
     * Inputs:      
    *           "code"=>$request->code,
                "title"=>$request->title,
                "rdtKey"=>$request->RDT_key,
                "type"=>$request->UXType,
                "createdBy"=>$loggedin_user_id

     * Output :JSON Response
     * 
     */
    public function filedDataSaveAPI($request,$params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/doctypefield";
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
        $finalResponse=$this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
        return $finalResponse;
    }

    /******
     * Get reference Field data
     * Inputs:pageNo->define page 
     *        limit ->define limit for a page
     * Output :Get all Reference Field Data
     * 
     */
    public function getReferenceFieldData($params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/doctypefield?$params";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=['headers' => $headers,'http_errors' => false];
        $response = $client->request('GET',$url, $data);
        $finalResponse=$this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
        return $finalResponse;       
    }

    /*****
     * API for saving field Reference Data
     * Request ->JSON DATA
     */
    public function fieldDataUploadAPI($params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/doctypefield/bulk";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic B64515a58399170c3AE0AB4ef6',
        ];
        $data=[
                'json' => [
                    'docTypeFieldData' => $params,
                    'createdBy' => "'".Auth::user()->id."'"
                ],
                'headers' => $headers,
                'http_errors' => false
            ];
        $response = $client->request('POST',$url, $data);
        return $this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
    }
}
