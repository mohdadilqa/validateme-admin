<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
trait CustomAPIFunctionTrait
{
    private $client;
    /***
     * Singleton Object of GuzzleHttp Object
     * 
     */

    public static function getGuzzleHttpInstance(){
        static $client=null;
        if($client==null){
            $client = new Client();
        }
        return $client;
    }

    /***
     * Return Message 
     * Input ->status code
     * output->Json Message
     * 
     */
    
    public function BEAPIStatusCode($statusCode,$data){
        switch($statusCode){
           
           case 200:
                return json_encode(array('status'=>1,'msg'=>$data['message'],'data'=>$data['response']));
            case 400:
                return json_encode(array('status'=>0,'msg'=>"Error. Please try again.",'data'=>''));
            case 422:
                return json_encode(array('status'=>0,'msg'=>'Error. Please try again.','data'=>''));
            case 500:
                return json_encode(array('status'=>0,'msg'=>'Error. Please try again.','data'=>''));
            // case 800:
            //     return json_encode(array('status'=>0,'msg'=>'Exception. Please try again.','data'=>''));
            default:
                return json_encode(array('status'=>0,'msg'=>'Exception. Please try again.','data'=>''));
        }
    }

    
    /***
     * convert Array of specific field to comma seprated string
     * Input ->Array/Obejct,$field
     * Output ->string
     * 
    */
    public function object_to_string($objects, $field='', $glue=', ') {
        $output = array();
        if(!empty($field)){
            if(!empty($objects) && count($objects) > 0) {
                foreach($objects as $object) {
                    if(is_array($object) && isset($object[$field])) {
                        $output[] = $object[$field];
                    } else  if(is_object($object) && isset($object->$field)) {
                        $output[] = $object->$field;
                    }
                }
            }
        }
        return join($glue, $output);
    }
}
