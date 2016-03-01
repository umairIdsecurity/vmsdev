<?php

class ContentCache
{
    static $content = array();

    public static function put($key,$value){

        self::$content[$key] = $value;

    }

    public static function fetch($key){

        if(array_key_exists($key,self::$content))
        {
            return self::$content[$key];
        }

        return null;

    }

    public static function invalidate($key)
    {
        unset(self::$content[$key]);
    }
}