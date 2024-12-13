<?php

class Lang{
    protected static $date;

    public static function  load($lang_code){
        $lang_file_path = ROOT.DS.'lang'.DS.strtolower($lang_code).'.php';

        if(file_exists($lang_file_path)){
            self::$date = include($lang_file_path);
        }else{
            throw new Exception('Lang file not found'.$lang_file_path);
        }

    }

    public  static  function  get($key, $default_value =''){
        return isset(self::$date[strtolower($key)]) ? self::$date[strtolower($key)] : $default_value;
    }
}