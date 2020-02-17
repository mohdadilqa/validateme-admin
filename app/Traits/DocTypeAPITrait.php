<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Auth;

trait DocTypeAPITrait
{
    use CustomAPIFunctionTrait;
    /******
     * Get reference Field data
     * Inputs:search string(Title) 
     *    
     * Output :Get all Reference Field Data(matching with title)
     * 
     */
    public function GetReferenceDataFieldAPI($params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/doctypefield/field?key=$params";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=['headers' => $headers,'http_errors' => false];
        $response = $client->request('GET',$url, $data);
        $finalResponse=$this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
        return $finalResponse;       
    }
    
    /******
     * Doctype Data Save
     * Inputs:      
*           "name"=>$request->name,
            "fields"=>$request->ref_data_field,
            "nameRule"=>$request->name_rule,
            "category"=>$request->category,
            "createdBy"=>"'$loggedin_user_id'"

     * Output :JSON Response
     * 
     */
    public function DocTypeDataSaveAPI($request,$params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/doctype";
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
    * Get Doctype data list
    * Inputs:pageNo,limit
    *    
    * Output :Get all Doctype Data
    * 
    */
    public function GetDoctypeListAPI($params){
       $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
       $url=env("VALIDATEME_BE_ENDPOINT")."/doctype?$params";
       $headers = [
           'Content-Type' => 'application/json',
           'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
       ];
       $data=['headers' => $headers,'http_errors' => false];
       $response = $client->request('GET',$url, $data);
       $finalResponse=$this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
       return $finalResponse;       
   }


   /******
    * Get Category data
    * 
    * Output :Get all category data
    * 
    */

   public function getAllCategory(){
       $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
       $url=env("VALIDATEME_BE_ENDPOINT")."/category/all";
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
     * API for deleting doctype 
     * input ->$id
     * output ->success message
     */
    public function DoctypeDataDeleteAPI($params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/doctype/$params";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=['headers' => $headers,'http_errors' => false];
        $response = $client->request('DELETE',$url, $data);
        return $this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true)); 
    }

    /*****
     * API for getting detail of Doctype 
     * input ->$id
     * output ->JSON Reference Field
     */
    public function DoctypeDataViewAPI($params){
        $client=$this->getGuzzleHttpInstance();
        $url=env("VALIDATEME_BE_ENDPOINT")."/doctype/$params";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=['headers' => $headers,'http_errors' => false];
        $response = $client->request('GET',$url, $data);
        return $this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true)); 
    }


    /*****
     * API for updating Doctype
     * input ->$data
     * output ->success message
     */
    public function DoctypeDataUpdateAPI($params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/doctype";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=[
            'json' => $params,
            'headers' => $headers,
            'http_errors' => false
        ];
        $response = $client->request('PUT',$url, $data);
        return $this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true)); 
    }
}
