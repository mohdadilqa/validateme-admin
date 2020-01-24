<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

trait BEAPITrait
{
    private $client;
    public static function getGuzzleHttpInstance(){
        static $client=null;
        if($client==null){
            $client = new Client();
        }
        return $client;
    }
    /*****
     * API for getting RDTKey
     * Request ->JSON DATA
     * RESPONSE->
     * 
     */
    public function RDTKeyAPI(Request $request,$params){
        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/RDTkeys?key=$params";
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];
        $data=['headers' => $headers];
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

    public function refDataSaveAPI(Request $request,$data){
        $client = new Client();//Guzzle Client object
        $url=env("VALIDATEME_BE_ENDPOINT")."/referencedata";
        
        $headers = [
            'Content-Type' => 'application/json',
            'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
        ];

        $params=[
                'json' => $data,
                'headers' => $headers,
                ];
        $response = $client->request('POST',$url, $data);
        $resBody=$response->getBody()->getContents();
    }
}
