<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use GuzzleHttp\Client;
use App\Traits\BEAPITrait;

class RefDataFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */    
    use BEAPITrait;

    public function index()
    {
        $roles=array();
        return view('admin.refdata.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.refdata.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loggedin_user_id = Auth::user()->id;
        try{
            $data=[
                    "title"=>$request->title,
                    "rdtKey"=>$request->RDT_key,
                    "code"=>$request->code,
                    "createdBy"=>$loggedin_user_id
                ];
            $response= $this->RDTKeyAPI($request,$data);
            if(!empty($response) && !empty($resBody->response)){
                // /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Reference Data Added","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
               
                return redirect()->route('admin.refdata.index')->with('message', 'Reference Data has been added successfully.');
            }else{

                // /*****Log */
                $log_string_serialize=json_encode(array("action"=>"Reference Data failed","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
                return back()->with('message', 'Server Error. Please try again.');
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

    public function referenceDataKey(Request $request){

        try{
            $client = new Client();//Guzzle Client object
            $searchTerm=$request->term;
            $response= $this->RDTKeyAPI($request,$searchTerm);
            if($response){
                $responseData=json_encode(array("status"=>1,"data"=>$response));
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
}
