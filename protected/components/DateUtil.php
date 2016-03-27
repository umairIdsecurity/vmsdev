<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 27/03/2016
 * Time: 10:51 AM
 */
class DateUtil
{
    private static $knownFormats = ['dd/MM/yyyy','yyyy-MM-dd','dd-MM-yyyy'];

    public static function reformat($dateString,$format){

        if(!$dateString) return "";
        $datetime = self::parse($dateString);
        return self::format($format,$datetime);

    }

    public static function reformatForDisplay($dateString){

        if(!$dateString) return null;
        $datetime = self::parse($dateString);
        return self::formatForDisplay($datetime);

    }

    public static function reformatForDatabase($dateString){

        if(!$dateString) return null;
        $datetime = self::parse($dateString);
        return self::formatForDatabase($datetime);

    }

    public static function formatTime($datetime){
        return self::format('h:ma',$datetime);
    }


    public static function formatForDisplay($datetime){
        return self::format('dd-MM-yyyy',$datetime);
    }

    public static function formatForDatabase($datetime){
        return self::format('yyyy-MM-dd',$datetime);
    }

    public static function format($format,$datetime){
        $formatter = new CDateFormatter(Yii::app()->locale);
        return $formatter->format($format,$datetime->getTimestamp());
    }

    public static function parse($dateString){

        foreach(DateUtil::$knownFormats as $format){

            $ts = CDateTimeParser::parse($dateString,$format);
            if($ts) {
                $result = new DateTime();
                $result->setTimestamp($ts);
                return $result;
            }

        }

        throw new CException("Unrecognised date format ".$dateString);

    }
}