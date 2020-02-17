<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helper
{
    public static function object_to_string($objects, $field='', $glue=', ') {
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

    /****
     * Function to return name rule on selected fields value
     * Input ->array
     * Output->String (name Rule)
     * 
    */
    public static function nameRuleFunction($fieldsArray){
        $nameRule="";
        if(!empty($fieldsArray)){
            foreach($fieldsArray as $key=>$val){
                $nameRule.="{".$val['title']."}_";
            }
        }
        return rtrim($nameRule,"_");
    }
}
?>