<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

trait BEAPITrait
{
    private $client;
    /***
     * Singleton Object of GuzzleHttp Object
     * 
     */

    public static function getGuzzleHttpInstance(){
        static $client=null;
        if($client==null){
            $client = new Client();
        }
        return $client;
    }

    public function HeaderStatusCode($statusCode,$data){
        switch($statusCode){
           case 200:
                return json_encode(array('status'=>1,'msg'=>'','data'=>$data['response']));
                // break;
            case 400:
                return json_encode(array('status'=>0,'msg'=>'Bad request. Please try again.','data'=>''));
                // break;
            case 422:
                return json_encode(array('status'=>0,'msg'=>'Unprocessable Entity. Please try again.','data'=>''));
                // break;
            case 500:
                return json_encode(array('status'=>0,'msg'=>'Server Error. Please try again.','data'=>''));
                // break;
            default:
                return json_encode(array('status'=>1,'msg'=>'','data'=>$data['response']));
        }
    }
    /*****
     * API for getting RDTKey
     * Request ->JSON DATA
     * RESPONSE->
     * 
     */
    public function RDTKeyAPI($request,$params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/RDTkeys?key=$params";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=['headers' => $headers,'http_errors' => false];
        $response = $client->request('GET',$url, $data);
        $resBody=$response->getBody()->getContents();
        return $resBody;
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
        $finalResponse=$this->HeaderStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
        return $finalResponse;
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
        //echo "<pre/>";print_r(json_decode($response->getBody()->getContents(),true));die;
        $finalResponse=$this->HeaderStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
        return $finalResponse;       
    }

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
       // echo "<pre/>";print_r($params);die;
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
        $finalResponse=$this->HeaderStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
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
        //echo "<pre/>";print_r(json_decode($response->getBody()->getContents(),true));die;
        $finalResponse=$this->HeaderStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
        return $finalResponse;       
    }    

    /******
     * Get reference Field data
     * Inputs:search string(Title) 
     *    
     * Output :Get all Reference Field Data(matching with title)
     * 
     */

    public function GetReferenceDataFieldAPI($params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/doctype/field?key=$params";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=['headers' => $headers,'http_errors' => false];
        $response = $client->request('GET',$url, $data);
        $finalResponse=$this->HeaderStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
        return $finalResponse;       
    }
}
