<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Permission;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class PermissionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = Permission::all();
        /***Start Log */
        $log_string_serialize=(json_encode(array("action"=>"Viwed Permission List","target_user"=>'NA', "target_company"=>'NA')));
        ActivityLogger::activity($log_string_serialize);
        /***End Log */
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $loggedin_user_role = Auth::user()->roles->first()->toArray();
        if($loggedin_user_role['id']===1){

            $permission = Permission::create($request->all());
            $permission->roles()->sync($loggedin_user_role['id']);
            
        }else{
            $permission = Permission::create($request->all());
        }
        /*****Log */
        $log_string_serialize=(json_encode(array("action"=>"Permission Added -> ".$request->title,"target_user"=>'NA', "target_company"=>'NA')));
        ActivityLogger::activity($log_string_serialize);
        /*****Log */
        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->all());

        /*****Log */
        $log_string_serialize=(json_encode(array("action"=>"Update Permission -> ".$permission->title,"target_user"=>'NA', "target_company"=>'NA')));
        ActivityLogger::activity($log_string_serialize);
        /*****Log */

        return redirect()->route('admin.permissions.index');
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        /*****Log */
        $log_string_serialize=(json_encode(array("action"=>"Viwed Permission -> ".$permission['title'],"target_user"=>'NA', "target_company"=>'NA')));
        ActivityLogger::activity($log_string_serialize);
        /*****Log */
        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permission_title=$permission['title'];
        $permission->delete();

        /*****Log */
        $log_string_serialize=(json_encode(array("action"=>"Deleted Permission -> ".$permission_title,"target_user"=>'NA', "target_company"=>'NA')));

        // $log_string_serialize=(json_encode(array("activity"=>"Delete permission","activity_for"=>$permission_title)));
        ActivityLogger::activity($log_string_serialize);
        /*****Log */

        return back();
    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        $permissions = Permission::whereIn('id', request('ids'))->get();
        Permission::whereIn('id', request('ids'))->delete();

        foreach($permissions as $key => $permission){
            /*****Log */
            $log_string_serialize=(json_encode(array("action"=>"Role Deleted -> ".$permission->title,"target_user"=>'NA', "target_company"=>'NA')));
            ActivityLogger::activity($log_string_serialize);
            /*****Log */
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
