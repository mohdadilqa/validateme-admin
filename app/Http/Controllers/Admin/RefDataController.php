<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use App\Http\Requests\StoreRefDataRequest;
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
                // /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Reference Data Added","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
                return redirect()->route('admin.refdata.index')->with('message', $response['msg']);
            }else{
                // /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Reference Data failed","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
                return back()->with('message', $response['msg']);
            }

        }catch(Exception $e){

            return back()->with('message', 'Exception found. Please try again.');
            /*****Log */
            $log_string_serialize=json_encode(array("action"=>"Reference Data failed.","target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
            // /*****Log */
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

    /*****
     * Reference data key
     * input->Search string
     * output->list of all refrence data key
     * 
     */
    public function referenceDataKey(Request $request){
        try{
            $searchTerm=$request->term;
            $response= json_decode($this->RDTKeyAPI($request,$searchTerm),true);
            if(!empty($response) && !empty($response['response'])){
                $responseData=json_encode(array("status"=>1,"data"=>$response['response']));
                 /*****Log */
                $log_string_serialize=json_encode(array("action"=>"RDTKey searching->".$searchTerm,"target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
            }else{
                $responseData=json_encode(array("status"=>0,"data"=>''));
                /*****Log */
                $log_string_serialize=json_encode(array("action"=>"RDTKey searching->".$searchTerm,"target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
            }
           
        }catch(Exception $e){
            
            /*****Log */
            $log_string_serialize=json_encode(array("action"=>"RDTKey searching Failed->".$searchTerm,"target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
            /*****Log */
            $responseData=json_encode(array("message"=>"RDTKey searching Failed.","status"=>0));
        }
        echo $responseData;die;
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
            if(!empty($response) && !empty($response['response'])){
                 /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Upload Reference Data","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
            }else{
                /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Reference data uploaded","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
            }
            echo json_encode($response);die;
        }catch(Exception $e){
            /*****Log */
            $log_string_serialize=json_encode(array("action"=>"Reference data uploaded failed","target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
            /*****Log */
            $response= $this->BEAPIStatusCode('',array());
            echo $response;die;
        }
    }
}
