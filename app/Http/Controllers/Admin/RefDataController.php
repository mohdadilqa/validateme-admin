<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Gate;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use GuzzleHttp\Client;

class RefDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $RDT_keys=array("select"=>"Select");
        return view('admin.refdata.create',compact('RDT_keys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $client = new Client();//Guzzle Client object
            $fieldName=$request->field_name;
            $fieldType=$request->field_type;
            $fieldOption=$request->field_option;
            $url=env("VALIDATEME_BE_ENDPOINT")."/field";
            
            $headers = [
                'Content-Type' => 'application/json',
                'authorization' => 'Basic '.env("VALIDATEME_BE_API_AUTH_KEY"),
            ];

            $data=['json' => [
                        'field'=>[
                            "name"=>$fieldName,
                            "options"=>$fieldOption,
                            "type"=>$fieldType
                        ]
                    ],
                    'headers' => $headers,
                ];
            
            $response = $client->request('POST',$url, $data);
            if($response->statusCode==200){
                // /*****Log */
                $log_string_serialize=json_encode(array("action"=>"DocType Field Added","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
               
                return redirect()->route('admin.refdata.index')->with('message', 'DocType field has been added successfully.');
            }else{

                // /*****Log */
                $log_string_serialize=json_encode(array("action"=>"DocType Field Add failed","target_user"=>"NA", "target_company"=>"NA")); 
                ActivityLogger::activity($log_string_serialize);
                /*****Log */
                return back()->with('message', 'Server Error. Please try again.');
            }

        }catch(Exception $e){

            return back()->with('message', 'Exception found. Please try again.');
            /*****Log */
            $log_string_serialize=json_encode(array("action"=>"DocType Field Add failed","target_user"=>"NA", "target_company"=>"NA")); 
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

    protected function getReferenceDataKey(Request $request){
        echo "dfdf";die;

    }
}
