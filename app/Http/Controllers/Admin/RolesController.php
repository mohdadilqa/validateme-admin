<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Permission;
use App\Role;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class RolesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles=array();
        $loggedin_user_role = Auth::user()->roles->first()->toArray();

        if(strtolower($loggedin_user_role['title'])===strtolower('superadmin')){

            $roles = Role::all();

        }else if(strtolower($loggedin_user_role['title'])===strtolower('support staff')){
           
            $roles = Role::where('title','=','company admin')->get();
        }

         /***Start Log */
         
         $log_string_serialize=(json_encode(array("action"=>"Navigated to Role List","target_user"=>'NA', "target_company"=>'NA')));

        //  $log_string_serialize=(json_encode(array("activity"=>"Role List","activity_for"=>'')));
         ActivityLogger::activity($log_string_serialize);
         /***End Log */
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all()->pluck('title', 'id');

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        /*****Log */
        $log_string_serialize=(json_encode(array("action"=>"Added new role -> ".$request->title,"target_user"=>'NA', "target_company"=>'NA')));

        // $log_string_serialize=(json_encode(array("activity"=>"Role Added","activity_for"=>$request->title)));
        ActivityLogger::activity($log_string_serialize);
        /*****Log */

        return redirect()->route('admin.roles.index')->with('message', 'Role has been created successfully.');
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all()->pluck('title', 'id');

        $role->load('permissions');

        return view('admin.roles.edit', compact('permissions', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        /*****Log */
        $log_string_serialize=(json_encode(array("action"=>"Role Updated -> ".$request->title,"target_user"=>'NA', "target_company"=>'NA')));
        ActivityLogger::activity($log_string_serialize);
        /*****Log */

        return redirect()->route('admin.roles.index')->with('message', 'Role has been updated successfully.');
    }

    public function show(Role $role)
    {
        abort_if(Gate::denies('role_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->load('permissions');

        /*****Log */
        $log_string_serialize=(json_encode(array("action"=>"Roles viewed -> ".$role['title'],"target_user"=>'NA', "target_company"=>'NA')));

        // $log_string_serialize=(json_encode(array("activity"=>"View Roles","activity_for"=>$role['title'])));
        ActivityLogger::activity($log_string_serialize);
        /*****Log */

        return view('admin.roles.show', compact('role'));
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role_title=$role['title'];
        $role->delete();

        /*****Log */
        $log_string_serialize=(json_encode(array("action"=>"Role Deleted -> ".$role_title,"target_user"=>'NA', "target_company"=>'NA')));

        // $log_string_serialize=json_encode(array("activity"=>"Delete Role","activity_for"=>$role_title));
        ActivityLogger::activity($log_string_serialize);
        /*****Log */

        return back()->with('message', 'Role has been deleted successfully.');
    }

    public function massDestroy(MassDestroyRoleRequest $request)
    {
        $roles = Role::whereIn('id', request('ids'))->get();
        Role::whereIn('id', request('ids'))->delete();
        foreach($roles as $key => $role){
            /*****Log */
            $log_string_serialize=(json_encode(array("action"=>"Role Deleted -> ".$role->title,"target_user"=>'NA', "target_company"=>'NA')));
            ActivityLogger::activity($log_string_serialize);
            /*****Log */
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
