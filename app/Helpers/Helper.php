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
}
?>