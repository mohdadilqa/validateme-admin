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

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles=$organizations=array();
        $loggedin_user_role = Auth::user()->roles->first()->toArray();
        $organizations=Organization::all()->pluck('name','id');

        if(strtolower($loggedin_user_role['title'])===strtolower('superadmin')){//if superadmin login
            
            $roles = Role::where('title','=','support staff')->get()->pluck('title', 'id');//shpw Support staff role
        
        }else if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
            
            $roles = Role::where('title','=','company admin')->get()->pluck('title', 'id');
        }
        return view('admin.users.create', compact('roles','organizations'));
    }

    public function store(StoreUserRequest $request)
    {
        $loggedin_user_id = Auth::user()->id;
        // $validator = Validator::make([
        //     'email' => [
        //         'required',
        //          Rule::unique('users')->ignore($loggedin_user_id),
        //     ],
        // ]);
        $data=$request->all();
        
        $data['created_by']=$loggedin_user_id;
        $user = User::create($data);
        $user->roles()->sync($request->input('roles', []));
        return redirect()->route('admin.users.index');
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
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));
        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
       
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');
        $user->load('organization');
       

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
