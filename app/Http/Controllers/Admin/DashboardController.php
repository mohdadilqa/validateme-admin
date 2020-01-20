<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Auth;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class DashboardController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dashboard_index'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        /***Start Log */
        $log_string_serialize=(json_encode(array("action"=>"Viwed Dashboard","target_user"=>'NA', "target_company"=>'NA')));
        ActivityLogger::activity($log_string_serialize);
       /***End Log */
        return view('admin.dashboard.index');
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
       
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        
    }
}
