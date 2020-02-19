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

/***
 * Send Email
 * input ->$user Data
 * Output->link send to user email
 * 
 * 
 */
    public function sendNotification($user){

        $client=$this->getGuzzleHttpInstance();   //Guzzle Client object
        $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);
        $link=env('APP_URL')."/password/reset/".$token;
        $url=env("VALIDATEME_NOTIFICATION_ENDPOINT")."/sendnotification";
        $headers = [
            'Content-type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
        ];
        $company=(isset($user['organization']->organization_name) && !empty($user['organization']->organization_name))?($user['organization']->organization_name):(__('cruds.user.fields.default_company'));
        $data=['json' => [
            "from"=>"Validate Me <no-reply@validateme.online>",
            "to"=>$user->email,
            "message"=>"Verify and reset password", 
            "category"=>"email",
            "subCategory"=>"ADMIN_RESET_PASSWORD",
            "resourceId"=>"",
            "data"=>[
                "company"=>["name"=>$company],
                "creator"=>["name"=>"#Creator#"],
                "name"=>$user->name,
                "link"=>$link,
                "requesterName"=>"#RequestorName#",
                "documentName"=>"#sample document#",
                "updatedBy"=>"#Updator#",
                "status"=>"#sample action#",
                "cancelledBy"=>"#Cancelling User#",
                "url"=>"#URL",
                "to"=>"#To User#",
                "by"=>"#By User#",
                "requestedFor"=> "#Requested For#",
                "action"=> "#action#",
                "actionCode"=> "SET_SOURCE",
                "requestor"=> "#Requestor#"
            ] 
        ]];
        $response = $client->request('POST',$url, $data);
        $finalResponse=$this->BEAPIStatusCode($response->getStatusCode(),json_decode($response->getBody()->getContents(),true));
        return $finalResponse; 
    }
}
