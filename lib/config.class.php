<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 03.03.2016
 * Time: 0:42
 */

class config{
    protected static $settings = array();

    public static function get($key){
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }
    public static function set($key,$value){
        self::$settings[$key] = $value;
    }

}