<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/admin/users';
    public function redirectTo(){
        
        // User role
        $role = Auth::user()->roles->first()->toArray();

        
        // Check user role
        switch (strtolower($role['title'])) {
            case 'superadmin':
                    return '/admin/dashboard';
                break;
            case 'support staff':
                    return '/admin/dashboard';
                break;
            case 'company admin':
                    return '/admin/dashboard';
                break; 

            default:
                    return '/login'; 
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
