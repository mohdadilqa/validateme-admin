<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use App\Http\Requests\StoreDocTypeRequest;
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
