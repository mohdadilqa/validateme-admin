<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Log;
use Gate;
use Auth;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('log_index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $logs=array();
        $loggedin_user_role = Auth::user()->roles->first()->toArray();
        if(strtolower($loggedin_user_role['title'])===strtolower('superadmin')){    //if superadmin login
            $logs=Log::with('user')->get();
            $logs->load('user.organization');
        }else if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
            $logs=Log::with('user')->whereHas('user.roles',function($query){
            $query->Where('title', '=','company admin')->orWhere('title', '=','support staff');
            })->get();
            $logs->load('user.organization');
        }
        
        /***Start Log */
        $log_string_serialize=(json_encode(array("action"=>"Viwed Log List","target_user"=>'NA', "target_company"=>'NA')));
        ActivityLogger::activity($log_string_serialize);
        /***End Log */
        return view('admin.log.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
