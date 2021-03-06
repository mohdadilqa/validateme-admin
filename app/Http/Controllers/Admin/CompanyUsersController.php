<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use GuzzleHttp\Client;

class CompanyUsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('company_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        try{
            $i=0;$datas=array();
            $loggedin_user_id = Auth::user()->id;
            $user=User::findorfail($loggedin_user_id);
            $user->load('organization');
            $orgDomain=$user['organization']->organization_domain;
            $orgName=$user['organization']->organization_name;

            $client = new Client();//Guzzle Client object
            $url=env("VALIDATEME_BE_ENDPOINT")."/company/user?domain=$orgDomain";
            
            $headers = [
                'Content-Type' => 'application/json',
                'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
            ];
            $response = $client->request('GET',$url, ['headers'=>$headers]);
            $result=json_decode($response->getBody()->getContents(),true);
            if(!empty($result)){
                foreach($result["response"] as $key=>$value){
                    $datas[$i]["uid"]=$value["uid"];
                    $datas[$i]["name"]=$value["name"];
                    $datas[$i]["email"]=$value["email"];
                    $datas[$i]["role"]=$value["role"];
                    $datas[$i]["createdAt"]=$value["createdAt"];
                    $datas[$i]['organization_name']=$orgName;
                    $i++;
                }
            }
            /*****Log */
            $log_string_serialize=json_encode(array("action"=>"Navigate to company users","target_user"=>"NA", "target_company"=>$user['organization']->organization_name)); 
            ActivityLogger::activity($log_string_serialize);
            /*****Log */

        }catch(Exception $e){
            /*****Log */
            $log_string_serialize=json_encode(array("action"=>"Navigate to company users failed","target_user"=>"NA", "target_company"=>$user['organization']->organization_name)); 
            ActivityLogger::activity($log_string_serialize);
            /*****Log */
        }
        return view('admin.company_users.index',compact('datas'));
    }

    public function create()
    {

    }

    public function store(StoreUserRequest $request)
    {
        
    }

    public function edit(User $user)
    {
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        
    }

    public function show(User $user)
    {
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('company_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {

    }

    public function verifyUser(Request $request){

        try{
            $client = new Client();//Guzzle Client object
            $uid=$request->uid;
            $name=$request->name;
            $organization_name=$request->organization_name;
            $url=env("VALIDATEME_BE_ENDPOINT")."/company/role/$uid";
            
            $headers = [
                'Content-Type' => 'application/json',
                'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
            ];

            $data=['json' => ['verify'=>true],  'headers' => $headers];
            
            $response = $client->request('PUT',$url, $data);
            if($response){
                $data=json_encode(array("message"=>"User has been verified.","status"=>1));
                 /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Verified company user.","target_user"=>$name, "target_company"=>$organization_name)); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
            }else{
                $data=json_encode(array("message"=>"User verification failed.","status"=>0));
                /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Verify company user failed.","target_user"=>$name, "target_company"=>$organization_name)); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
            }
            echo $data;die;
        }catch(Exception $e){
            
            /*****Log */
            $log_string_serialize=json_encode(array("action"=>"Verified company user failed","target_user"=>$name, "target_company"=>$organization_name)); 
            ActivityLogger::activity($log_string_serialize);
            /*****Log */
            $data=json_encode(array("message"=>"User verification failed.","status"=>0));
            echo $data;die;
        }
    }
}
