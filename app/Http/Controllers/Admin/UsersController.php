<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use App\Organization;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
//use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use GuzzleHttp\Client;


class UsersController extends Controller
{
    public function index()
    {

        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users=array();
        $loggedin_user_role = Auth::user()->roles->first()->toArray();
        if(strtolower($loggedin_user_role['title'])===strtolower('superadmin')){    //if superadmin login
            
            $users=User::whereHas('roles',function($query){

                $query->where('title','=','support staff');
            })->get();

        }else if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){

            $users=User::with('organization')->whereHas('roles',function($query){

                $query->where('title','=','company admin');
            })->get();

        }
        /****Log */
        $log_string_serialize=json_encode(array("action"=>"Navigate to User List","target_user"=>'NA', "target_company"=>'NA'));
        ActivityLogger::activity($log_string_serialize);
        /***End Log */

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles=$organizations=array();
        $loggedin_user_role = Auth::user()->roles->first()->toArray();

        if(strtolower($loggedin_user_role['title'])===strtolower('superadmin')){//if superadmin login
            
            $roles = Role::where('title','=','support staff')->get()->pluck('title', 'id');//shpw Support staff role
        
        }else if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
            
            $roles = Role::where('title','=','company admin')->get()->pluck('title','id');
        }
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $loggedin_user_id = Auth::user()->id;
        $data=$request->all();
        $validation=Validator::make($data, [
            'email' => [
                Rule::unique('users'),
            ]]);
        $loggedin_user_role = Auth::user()->roles->first()->toArray();
        if(!$validation->fails()){

            if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
            
                /***Check Organization exist*/

                $org_record = Organization::where([['organization_name','=',$data['organization_name']],['organization_domain','=', $data['organization_domain']]])->first();
                if($org_record === null){
                    // Organization doesn't exist
                    $organization_id=Organization::create($data)->id;
                    $data['organization_id']=$organization_id;
                }else{
                    $organization_id=$org_record['id'];
                    $data['organization_id']=$organization_id;
                }
                /******End Organization check */
                //generate a random password
                $data['password']=rand();
            }
            $data['created_by']=$loggedin_user_id;
            $user = User::create($data);
            $user->roles()->sync($request->input('roles', []));

            
            if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
                /*****Log */
                $log_string_serialize=json_encode(array("action"=>"User Added.","target_user"=>$request->name, "target_company"=>$data['organization_name']));
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
                //Trigger Mail for reset password
                $this->sendEmailNotification($user);
            }else{
                /*****Log */
                $log_string_serialize=json_encode(array("action"=>"User Added.","target_user"=>$request->name, "target_company"=>"ValidateMe"));
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
            }
           
            return redirect()->route('admin.users.index')->with('message', 'User has been added successfully.');
            
        }else{
            /*****Log */
            // if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
            //     $log_string_serialize=json_encode(array("action"=>"User has been already registered with this email.","target_user"=>$request->name, "target_company"=>$data['organization_name']));
            // }else{
            //     $log_string_serialize=json_encode(array("action"=>"User has been already registered with this email.","target_user"=>$request->name, "target_company"=>"ValidateMe"));
            // }
            // ActivityLogger::activity($log_string_serialize);
            /*****Log */
            return back()->with('message', 'User has been already registered with this email. Please try with another email.');
        }
        
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles=array();
        $loggedin_user_role = Auth::user()->roles->first()->toArray();
        if(strtolower($loggedin_user_role['title'])===strtolower('superadmin')){//if superadmin login
            
            $roles = Role::where('title','=','support staff')->get()->pluck('title', 'id');//show Support staff role
        
        }else if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
            
            $roles = Role::where('title','=','company admin')->get()->pluck('title', 'id');
        }
        $user->load('roles');
        return view('admin.users.edit', compact('roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validate=Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$user->id,
            ]);
        $loggedin_user_role = Auth::user()->roles->first()->toArray();
        if(!$validate->fails()){
            
            $user->load('organization');
            $user->update($request->all());
            $user->roles()->sync($request->input('roles', []));
            
            /*****Log */
            if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
                $log_string_serialize=json_encode(array("action"=>"Edited User","target_user"=>$request->name, "target_company"=>$user['organization']->organization_name));
            }else{
                $log_string_serialize=json_encode(array("action"=>"Edited User","target_user"=>$request->name, "target_company"=>"ValidateMe"));
            }
            ActivityLogger::activity($log_string_serialize);
            /*****Log */
            return redirect()->route('admin.users.index')->with('message', 'User has been updated successfully.');
        }else{
            return back()->with('message', 'User has been already registered with this email.');
            /*****Log */
            // if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
            //     $log_string_serialize=json_encode(array("action"=>"User has been already registered with this email.","target_user"=>$request->name, "target_company"=>$user['organization']->organization_name));
            // }else{
            //     $log_string_serialize=json_encode(array("action"=>"User has been already registered with this email.","target_user"=>$request->name, "target_company"=>"ValidateMe"));
            // }
            // ActivityLogger::activity($log_string_serialize);
            /*****Log */
        }
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $user->load('roles');
        $user->load('organization');
        $loggedin_user_role = Auth::user()->roles->first()->toArray();
        
        /*****Log */
        if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
            $log_string_serialize=json_encode(array("action"=>"View User profile","target_user"=>$user['name'], "target_company"=>$user['organization']['organization_name']));
        }else{
            $log_string_serialize=json_encode(array("action"=>"View User profile","target_user"=>$user['name'], "target_company"=>'Validate Me'));
        }
        ActivityLogger::activity($log_string_serialize);
        /*****Log */
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user->load('organization');
        $user_name=$user->name;
        $user->delete();
        
        $loggedin_user_role = Auth::user()->roles->first()->toArray();
        
        /*****Log */
        if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
            $log_string_serialize=json_encode(array("action"=>"Deleted User","target_user"=>$user_name, "target_company"=>$user['organization']->organization_name));
        }else{
            $log_string_serialize=json_encode(array("action"=>"Deleted User","target_user"=>$user_name, "target_company"=>'Validate Me'));
           
        }
        ActivityLogger::activity($log_string_serialize);
        /*****Log */
        return back()->with('message', 'User has been deleted successfully.');
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $users = User::with('organization')->whereIn('id', request('ids'))->get();
        User::whereIn('id', request('ids'))->delete();
        $loggedin_user_role = Auth::user()->roles->first()->toArray();
        
        foreach($users as $key => $user){
           /*****Log */
            if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
                $log_string_serialize=json_encode(array("action"=>"Deleted User","target_user"=>$user->user_name, "target_company"=>$user['organization']->organization_name));
            }else{
                $log_string_serialize=json_encode(array("action"=>"Deleted User","target_user"=>$user->user_name, "target_company"=>'Validate Me'));
            
            }
            ActivityLogger::activity($log_string_serialize);
            /*****Log */
        } 
        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**Return Organization Listing
     * Parameter q->search 
     * Response array of organizations
     * 
     * 
     */
    public function allOrganization(Request $request){
        try{
            $queryString=$request->q;
            $url=env('VALIDATEME_ORG_API_ENDPOINT')."/companies/suggest?query=".$queryString;
            $client = new \GuzzleHttp\Client();
            $request = $client->get($url);
            $response = $request->getBody()->getContents();
            print_r($response);
            exit;
        }catch(Exception $e){

        }
    }

    /******
     * Send Email using Nodejs Notification API
     * 
     * 
     */
    protected function sendEmailNotification($user){
        try{
            $user->load('organization');
            $client = new Client();
            $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);
            $link=env('APP_URL')."/password/reset/".$token;
            $url=env("VALIDATEME_NOTIFICATION_ENDPOINT")."/sendnotification";
            
            $headers = [
                'Content-type' => 'application/json; charset=utf-8',
                'Accept' => 'application/json',
                //'Authorization' => 'Basic ' . base64_encode($username . ':' . $password),
            ];
            $data=['json' => [
                "from"=>"Validate Me <no-reply@validateme.online>",
                "to"=>$user->email,
                "message"=>"Verify and reset password", 
                "category"=>"email",
                "subCategory"=>"ADMIN_RESET_PASSWORD",
                "resourceId"=>"",
                "data"=>[
                    "company"=>["name"=>$user['organization']->organization_name],
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
            $emailResponse=json_decode($response->getBody()->getContents());
            if(!empty($emailResponse) && !empty($emailResponse->response)){
                /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Verfication email sent.","target_user"=>$user->name, "target_company"=>$user['organization']->organization_name)); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
            }else{
                /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Verfication email sent failed.","target_user"=>$user->name, "target_company"=>$user['organization']->organization_name)); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
            }
        
        }catch(Exception $e){
            /*****Log */
            $log_string_serialize=json_encode(array("action"=>"Verfication email failed","target_user"=>$user->name, "target_company"=>$user['organization']->organization_name)); 
            ActivityLogger::activity($log_string_serialize);
            /*****Log */
        }
    }
}
