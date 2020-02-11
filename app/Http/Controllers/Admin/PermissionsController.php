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
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class PermissionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = Permission::all();
        $log_string_serialize=(json_encode(array("action"=>"Viwed Permission List","target_user"=>'NA', "target_company"=>'NA')));
        ActivityLogger::activity($log_string_serialize);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        try{
            $validation=Validator::make($request->all(), [
                'title' => [
                    Rule::unique('permissions'),
                ]]);
            if(!$validation->fails()){
    
                $loggedin_user_role = Auth::user()->roles->first()->toArray();
                if($loggedin_user_role['id']===1){
    
                    $permission = Permission::create($request->all());
                    $permission->roles()->sync($loggedin_user_role['id']);
                    
                }else{
                    $permission = Permission::create($request->all());
                }
                $log_string_serialize=(json_encode(array("action"=>"Permission Added -> ".$request->title,"target_user"=>'NA', "target_company"=>'NA')));
                ActivityLogger::activity($log_string_serialize);
                return redirect()->route('admin.permissions.index')->with('message', trans('cruds.permission.messages.success_add'));
            }else{
                return back()->with('message', trans('cruds.permission.messages.permission_duplicate'));
            }
        }catch(Excetion $e){
            return back()->with('message', trans('cruds.permission.messages.exception'));
        }
    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        try{
            $validate=Validator::make($request->all(), [
                'title' => 'required|unique:permissions,title,'.$permission->id,
                ]);
            if(!$validate->fails()){
                $permission->update($request->all());
                $log_string_serialize=(json_encode(array("action"=>"Update Permission -> ".$permission->title,"target_user"=>'NA', "target_company"=>'NA')));
                ActivityLogger::activity($log_string_serialize);
                return redirect()->route('admin.permissions.index')->with('message', trans('cruds.permission.messages.success_edit'));
            }else{
                return back()->with('message', trans('cruds.permission.messages.permission_duplicate'));
            }
        }catch(Exception $e){
            return back()->with('message', trans('cruds.permission.messages.exception'));
        }
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $log_string_serialize=(json_encode(array("action"=>"Viwed Permission -> ".$permission['title'],"target_user"=>'NA', "target_company"=>'NA')));
        ActivityLogger::activity($log_string_serialize);
        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy(Permission $permission)
    {
        try{   
            abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $permission_title=$permission['title'];
            $permission->delete();
            $log_string_serialize=(json_encode(array("action"=>"Deleted Permission -> ".$permission_title,"target_user"=>'NA', "target_company"=>'NA')));
            ActivityLogger::activity($log_string_serialize);
            return back()->with('message', trans('cruds.permission.messages.success_delete'));
        }catch(Exception $e){
            return back()->with('message', trans('cruds.permission.messages.exception'));
        }
    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        $permissions = Permission::whereIn('id', request('ids'))->get();
        Permission::whereIn('id', request('ids'))->delete();
        foreach($permissions as $key => $permission){
            $log_string_serialize=(json_encode(array("action"=>"Role Deleted -> ".$permission->title,"target_user"=>'NA', "target_company"=>'NA')));
            ActivityLogger::activity($log_string_serialize);
        }
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
