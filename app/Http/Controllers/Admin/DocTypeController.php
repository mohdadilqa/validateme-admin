<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use App\Http\Requests\StoreDocTypeRequest;
use App\Http\Requests\UpdateDocTypeRequest;
use App\Traits\DocTypeAPITrait;

class DocTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */    
    use DocTypeAPITrait;
    public function index()
    {
        abort_if(Gate::denies('doctype_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $params="";$datas=array();
        $response=json_decode($this->GetDoctypeListAPI($params),true);
        if(!empty($response) && isset($response['data']['doctypeData']) && (!empty($response['data']['doctypeData']))){
            $datas=$response['data']['doctypeData'];
        }
        return view('admin.doctype.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('doctype_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories=array();
        $categoryData=json_decode($this->getAllCategory(),true);
        if(isset($categoryData['data']) && !empty($categoryData['data'])){
            $categories=$categoryData['data'];
        }
        return view('admin.doctype.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocTypeRequest $request)
    {
        $loggedin_user_id = Auth::user()->id;
        try{
            $data=[
                    "name"=>$request->name,
                    "fields"=>str_replace('"', '', $request->ref_data_field),
                    "nameRule"=>str_replace('"', '',$request->name_rule),
                    "category"=>$request->category,
                    "createdBy"=>"'$loggedin_user_id'"
                ];
            $response= json_decode($this->DocTypeDataSaveAPI($request,$data),true);
            if(!empty($response) && isset($response['status']) && ($response['status']===1)){
                $log_string_serialize=json_encode(array("action"=>"Document Data Added","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return redirect()->route('admin.doctype.index')->with('message', $response['msg']);
            }else{
                $log_string_serialize=json_encode(array("action"=>"Document Data Add failed","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return back()->with('message', $response['msg']);
            }
        }catch(Exception $e){
            $log_string_serialize=json_encode(array("action"=>"Document Data Add failed.","target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
            return back()->with('message',trans('cruds.doctype.messages.exception'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=array();
        if(!empty($id)){
            try{
                $response= json_decode($this->DoctypeDataViewAPI($id),true);
                if(isset($response['data']) && isset($response['data'])){
                    $data=$response['data'];
                }
                $log_string_serialize=json_encode(array("action"=>"View reference data","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
            }catch(Exception $e){
                $log_string_serialize=json_encode(array("action"=>"View reference data failed","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                $response= $this->BEAPIStatusCode('',array());
                return back()->with('message', trans('cruds.doctype.messages.exception'));
            }
        }else{
            return back()->with('message', trans('cruds.doctype.messages.error'));
        }
        return view('admin.doctype.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('doctype_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(!empty($id)){
            try{
                $data=array();$categories=array();
                $categoryData=json_decode($this->getAllCategory(),true);
                if(isset($categoryData['data']) && !empty($categoryData['data'])){
                    $categories=$categoryData['data'];
                }
                $doctypeData= json_decode($this->DoctypeDataViewAPI($id),true);
                if(isset($doctypeData['data']) && isset($doctypeData['data'])){
                    $data=$doctypeData['data'];
                    return view('admin.doctype.edit',compact('data','categories'));
                }else{
                    return back()->with('message', trans('cruds.refdata.messages.error'));
                }
            }catch(Exception $e){
                return back()->with('message', trans('cruds.doctype.messages.exception'));
            }
        }else{
            return back()->with('message', trans('cruds.doctype.messages.error'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocTypeRequest $request, $id)
    {
        try{ 
            $loggedin_user_id = Auth::user()->id;
            $data=[
                "id"=>$id,
                "name"=>$request->name,
                "fields"=>str_replace('"', '', $request->ref_data_field),
                "nameRule"=>str_replace('"', '',$request->name_rule),
                "category"=>$request->category,
                "updatedBy"=>"'$loggedin_user_id'"
            ];
            $response= json_decode($this->DoctypeDataUpdateAPI($data),true);
            if(isset($response['status']) && $response['status']===1){
                $log_string_serialize=json_encode(array("action"=>"Document updated.","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return redirect()->route('admin.doctype.index')->with('message', $response['msg']);
            }else{
                $log_string_serialize=json_encode(array("action"=>"Document update failed.","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return redirect()->route('admin.doctype.index')->with('message', $response['msg']);
            }  
        }catch(Exception $e){
            return redirect()->route('admin.doctype.index')->with('message', trans('cruds.doctype.messages.exception'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('doctype_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(!empty($id)){
            try{
                $response= json_decode($this->DoctypeDataDeleteAPI($id),true);
                $log_string_serialize=json_encode(array("action"=>"Document deleted.","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return redirect()->route('admin.doctype.index')->with('message', $response['msg']);
            }catch(Exception $e){
                $log_string_serialize=json_encode(array("action"=>"Document delete failed","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return back()->with('message', trans('cruds.doctype.messages.exception'));
            }
        }else{
            return back()->with('message', trans('cruds.doctype.messages.error'));
        }
    }

    public function referenceDataField(Request $request){
        try{
            $searchTerm=$request->q;
            $response= $this->GetReferenceDataFieldAPI($searchTerm);
            $log_string_serialize=json_encode(array("action"=>"Reference data field searching->".$searchTerm,"target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
            echo $response;die;
        }catch(Exception $e){
            $response= $this->BEAPIStatusCode('',array()); 
        }
        echo $response;die;
    }
}
