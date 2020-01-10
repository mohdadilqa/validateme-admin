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

class CompanyUsersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('company_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $company_users=array();
        return view('admin.company_users.index',compact('company_users'));
    }

    public function create()
    {
        abort_if(Gate::denies('company_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles=array();
        return view('admin.company_users.create',compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        return redirect()->route('admin.company_users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('company_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.company_users.edit');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return redirect()->route('admin.company_users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('company_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.company_users.show');
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('company_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
