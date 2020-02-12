<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use App\Http\Requests\StoreRefDataRequest;
use App\Http\Requests\UpdateRefDataRequest;
use GuzzleHttp\Client;
use App\Traits\RefDataAPITrait;

class RefDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */    
    use RefDataAPITrait;

    public function index()
    {
        abort_if(Gate::denies('refdata_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $params="";$datas=array();
        $response=json_decode($this->getReferenceData($params),true);
        if(!empty($response) && isset($response['data']['refData'])){
            $datas=$response['data']['refData'];
        }
        return view('admin.refdata.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('refdata_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.refdata.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRefDataRequest $request)
    {
        $loggedin_user_id = Auth::user()->id;
        try{
            $data=[
                    "title"=>$request->title,
                    "referenceDataTypeKey"=>$request->RDT_key,
                    "code"=>$request->code,
                    "createdBy"=>"'$loggedin_user_id'"
                ];
            $response= json_decode($this->refDataSaveAPI($request,$data),true);
            if(!empty($response) && ($response['status']===1)){
                $log_string_serialize=json_encode(array("action"=>"Reference Data Added","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return redirect()->route('admin.refdata.index')->with('message', $response['msg']);
            }else{
                $log_string_serialize=json_encode(array("action"=>"Reference Data Add failed","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return back()->with('message', $response['msg']);
            }
        }catch(Exception $e){
            $log_string_serialize=json_encode(array("action"=>"Reference Data Add failed.","target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
            return back()->with('message', trans('cruds.refdata.messages.exception'));
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
        abort_if(Gate::denies('refdata_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data=array();
        if(!empty($id)){
            try{
                $response= json_decode($this->ReferenceDataViewAPI($id),true);
                if(isset($response['data']) && isset($response['data'])){
                    $data=$response['data'];
                }
                $log_string_serialize=json_encode(array("action"=>"View reference data","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return view('admin.refdata.show',compact('data'));
            }catch(Exception $e){
                $log_string_serialize=json_encode(array("action"=>"View reference data failed","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                $response= $this->BEAPIStatusCode('',array()); 
                return back()->with('message', trans('cruds.refdata.messages.exception'));
            }
        }else{
            return back()->with('message', trans('cruds.refdata.messages.error'));
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('refdata_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try{
            $response= json_decode($this->ReferenceDataViewAPI($id),true);
            if(isset($response['data']) && isset($response['data'])){
                $data=$response['data'];
                return view('admin.refdata.edit',compact('data'));
            }else{
                return back()->with('message', trans('cruds.refdata.messages.error'));
            }
        }catch(Exception $e){
            return back()->with('message', trans('cruds.refdata.messages.exception'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRefDataRequest $request, $id)
    {
        try{
            $loggedin_user_id = Auth::user()->id;
            $data=[
                "id"=>$id,
                "title"=>$request->title,
                "referenceDataTypeKey"=>$request->RDT_key,
                "code"=>$request->code,
                "updatedBy"=>"'$loggedin_user_id'"
            ];
            $response= json_decode($this->ReferenceDataUpdateAPI($data),true);
            if(isset($response['status']) && $response['status']===1){
                $log_string_serialize=json_encode(array("action"=>"Reference data updated.","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return redirect()->route('admin.refdata.index')->with('message', $response['msg']);
            }else{
                $log_string_serialize=json_encode(array("action"=>"Reference data update failed.","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return redirect()->route('admin.refdata.index')->with('message', $response['msg']);
            }  
        }catch(Exception $e){
            return redirect()->route('admin.refdata.index')->with('message', trans('cruds.refdata.messages.exception'));
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
        abort_if(Gate::denies('refdata_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(!empty($id)){
            try{
                $response= json_decode($this->ReferenceDataDeleteAPI($id),true);
                return redirect()->route('admin.refdata.index')->with('message', $response['msg']);
            }catch(Exception $e){
                return back()->with('message', trans('cruds.refdata.messages.exception'));
            }
        }else{
            return back()->with('message', trans('cruds.refdata.messages.error'));
        }
    }

    /*****
     * Reference data key
     * input->Search string
     * output->list of all refrence data key
     * 
     */
    public function referenceDataKey(Request $request){
        try{
            $searchTerm=$request->term;
            $response= $this->RDTKeyAPI($request,$searchTerm);
            $log_string_serialize=json_encode(array("action"=>"RDTKey searching->".$searchTerm,"target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
        }catch(Exception $e){
            $log_string_serialize=json_encode(array("action"=>"RDTKey searching Failed->".$searchTerm,"target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
            $response= $this->BEAPIStatusCode('',array()); 
        }
        echo $response;die;
    }
    /*****
     * for saving Reference data
     * input ->Json Data
     * Output->remaing data not saved
     * 
     */
    public function refDataUpload(Request $request){
        try{
            $data=$request->jsonData;
            $response= json_decode($this->refDataUploadAPI($data),true);
            if(!empty($response) && isset($response['response']) && !empty($response['response'])){
                $log_string_serialize=json_encode(array("action"=>"Reference data uploaded","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
            }else{
                $log_string_serialize=json_encode(array("action"=>"Reference data upload falied","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
            }
            echo json_encode($response);die;
        }catch(Exception $e){
            $log_string_serialize=json_encode(array("action"=>"Reference data upload failed","target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
            $response= $this->BEAPIStatusCode('',array());
            echo $response;die;
        }
    }
}
