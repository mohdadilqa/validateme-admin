<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use App\Http\Requests\StoreDocTypeRequest;
use GuzzleHttp\Client;
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
        $params="";$i=0;$datas=array();
        $response=json_decode($this->GetDoctypeListAPI($params),true);
        
        if(!empty($response) && isset($response['data']['doctypeData']) && (!empty($response['data']['doctypeData']))){

            foreach($response['data']['doctypeData'] as $key=> $val){
                $datas[$i]['_id']=$val['_id'];
                $datas[$i]['name']=$val['name'];
                $datas[$i]['category']=$val['category']['label'];
                $datas[$i]['fields']=$this->object_to_string($val['fields'], 'title');
                $datas[$i]['nameRule']=$this->object_to_string($val['nameRule'], 'title');
                $datas[$i]['createdAt']=$val['createdAt'];
                $i++;
            }
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
            if(!empty($response) && ($response['status']===1)){
                // /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Document Data Added","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
                return redirect()->route('admin.doctype.index')->with('message', 'Document definition has been added successfully.');
            }else{
                // /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Document Data failed","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
                return back()->with('message', $response['msg']);
            }
        }catch(Exception $e){
            return back()->with('message','Exception found. Please try again.');
            /*****Log */
            $log_string_serialize=json_encode(array("action"=>"Document Data failed.","target_user"=>"NA", "target_company"=>"NA")); 
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

    public function referenceDataField(Request $request){
        try{
            $searchTerm=$request->q;
            $response= json_decode($this->GetReferenceDataFieldAPI($searchTerm),true);
            if(!empty($response) && isset($response['data'])){
                $responseData=json_encode(array("status"=>1,"data"=>$response['data']));
                 /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Reference data field searching->".$searchTerm,"target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
            }else{
                $responseData=json_encode(array("status"=>0,"data"=>''));
                /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Reference data field searching->".$searchTerm,"target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
            }
        }catch(Exception $e){
            /*****Log */
            $log_string_serialize=json_encode(array("action"=>"Reference data field searching Failed->".$searchTerm,"target_user"=>"NA", "target_company"=>"NA")); 
            ActivityLogger::activity($log_string_serialize);
            /*****Log */
            $responseData=json_encode(array("status"=>0,"data"=>''));
        }
        echo $responseData;die;
    }
}
