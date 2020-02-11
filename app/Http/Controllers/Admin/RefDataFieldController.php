<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use App\Http\Requests\StoreRefDataFieldRequest;
use App\Traits\RefDataFieldAPITrait;

class RefDataFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */    
    use RefDataFieldAPITrait;

    public function index()
    {
        abort_if(Gate::denies('refdatafield_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $params="";$datas=array();
        $response=json_decode($this->getReferenceFieldData($params),true);
        if(!empty($response) && isset($response['data']['doctypeFieldDefinationData'])){
            $datas=$response['data']['doctypeFieldDefinationData'];
        }
        return view('admin.refdatafield.index',compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('refdatafield_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fieldTypes=array("select"=>"Select","reference"=>"Reference");
        return view('admin.refdatafield.create',compact('fieldTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRefDataFieldRequest $request)
    {
        $loggedin_user_id = Auth::user()->id;
        try{
            $data=[
                    "code"=>$request->code,
                    "title"=>$request->title,
                    "referenceDataTypeKey"=>$request->RDT_key,
                    "type"=>$request->field_type,
                    "createdBy"=>"'$loggedin_user_id'"
                ];
            $response= json_decode($this->filedDataSaveAPI($request,$data),true);
            if(!empty($response) && isset($response['status']) && ($response['status']===1)){

                $log_string_serialize=json_encode(array("action"=>"Field Definition Added","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return redirect()->route('admin.refdatafield.index')->with('message', $response['msg']);
            }else{
                $log_string_serialize=json_encode(array("action"=>"Field Definition failed","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                return back()->with('message', $response['msg']);
            }
        }catch(Exception $e){
            $log_string_serialize=json_encode(array("action"=>"Reference Data Field Definition failed.","target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
            return back()->with('message', trans('cruds.refdatafield.messages.exception'));
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
     * for saving Field data
     * input ->Json Data
     * Output->Dowload duplicate data
     * 
     */
    public function fieldDataUpload(Request $request){
        try{
            $data=$request->jsonData;
            $response= json_decode($this->fieldDataUploadAPI($data),true);
            if(!empty($response) && isset($response['response']) && ($response['response']===1)){
                $log_string_serialize=json_encode(array("action"=>"Field data uploaded","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
            }else{
                $log_string_serialize=json_encode(array("action"=>"Field data uploaded failed","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
            }
            echo json_encode($response);die;
        }catch(Exception $e){
            $log_string_serialize=json_encode(array("action"=>"Field data uploaded failed","target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
            $response= $this->BEAPIStatusCode('',array());
            echo $response;die;
        }
    }
}
