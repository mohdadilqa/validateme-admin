<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index()
    {
        //abort_if(Gate::denies('company_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
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
