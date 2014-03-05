<?php

class Utility {
    public static function dd($input){
        echo "<pre>";
        if( is_array($input) ){
            print_r($input);
        } else {
            echo $input;
        }
        die();
    }
}