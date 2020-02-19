<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;
use App\Traits\CompanyUserAPITrait;

class ForgotPasswordController extends Controller
{
    use CompanyUserAPITrait;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function showLinkRequestForm(){
        return view('auth.passwords.email');
    }
    public function sendResetLinkEmail(Request $request){
        try{
            $email=$request->email;
            if(!empty($email)){
                $user = User::where("email","=",$email)->first();
                if(!empty($user) && $user!=null){
                    $emailResponse=$this->sendNotification($user);
                    if(!empty($emailResponse) && !empty($emailResponse->response)){
                        $log_string_serialize=json_encode(array("action"=>"Verfication email sent.","target_user"=>$user->name, "target_company"=>$user['organization']->organization_name)); 
                        ActivityLogger::activity($log_string_serialize);
                        return redirect()->route('login')->with("message",trans('cruds.forgotpassword.messages.success'));
                    }else{
                        $log_string_serialize=json_encode(array("action"=>"Verfication email sent failed.","target_user"=>$user->name, "target_company"=>$user['organization']->organization_name)); 
                        ActivityLogger::activity($log_string_serialize);
                        return redirect()->route('login')->with("message",trans('cruds.forgotpassword.messages.error'));
                    }
                }else{
                    return back()->with("message",trans('cruds.forgotpassword.messages.email_not_found'));
                }
            }else{
                return back()->with("message",trans('cruds.forgotpassword.messages.email_empty'));
            }
        }catch(Excetion $e){
            return back()->with("message",trans('cruds.forgotpassword.messages.exception'));
        }
    }
}
