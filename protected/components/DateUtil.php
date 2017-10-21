<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 27/03/2016
 * Time: 10:51 AM
 */
class DateUtil
{

    private static $database_date_format = 'yyyy-MM-dd';
    private static $database_time_format = 'HH:mm:ss';
    private static $display_date_format = 'dd-MM-yyyy';
    private static $display_time_format = 'hh:mmA';

    private static $knownDateFormats = ['dd/MM/yyyy','yyyy-MM-dd','dd-MM-yyyy','dd/MM/yy'];
    private static $knownTimeFormats = ['hh:mma','HH:mm:ss'];


    public static function getDateDisplayDateFormat(){
        return self::$display_date_format;
    }

    public function getDisplayTimeFormat(){
        return self::$display_time_format;
    }

    public static function reformat($dateString,$format){

        if(!$dateString) return "";
        $datetime = self::parseDate($dateString);
        return self::format($format,$datetime);

    }

    public static function reformatDateForDisplay($dateString){

        if(!$dateString) return null;
        $datetime = self::parseDate($dateString);
        return self::formatDateForDisplay($datetime);

    }

    public static function reformatDateForDatabase($dateString){

        if(!$dateString) return null;
        $datetime = self::parseDate($dateString);
        return self::formatDateForDatabase($datetime);

    }

    public static function reformatTimeForDisplay($timeString){

        if(!$timeString) return null;
        $datetime = self::parseTime($timeString);
        return self::formatTimeForDisplay($datetime);

    }

    public static function reformatTimeForDatabase($timeString){

        if(!$timeString) return null;
        $datetime = self::parseTime($timeString);
        return self::formatTimeForDatabase($datetime);

    }


    public static function formatTimeforDisplay($datetime){
        return self::format(self::$display_time_format,$datetime);
    }


    public static function formatDateForDisplay($datetime){
        return self::format(self::$display_date_format,$datetime);
    }

    public static function formatDateForDatabase($datetime){
        return self::format(self::$database_date_format,$datetime);
    }

    public static function formatTimeForDatabase($datetime){
        return self::format(self::$database_time_format,$datetime);
    }

    public static function format($format,$datetime){
        if($datetime==null) return null;
        $formatter = new CDateFormatter(Yii::app()->locale);
		
        return $formatter->format($format,$datetime->getTimestamp());
    }


    public static function userLocalDateTime(){
        $session = new CHttpSession;

        if($session['timezone'] != ""){
            $user_timezone = $session['timezone'];
			
        } else {
			
        		$user_timezone = "Australia/Perth";
        }
		
        return (new DateTime("NOW", new DateTimeZone($user_timezone)));

    }

    public static function formatUserLocalDateForDisplay(){
		$session = new CHttpSession;
		if($session['timezone'] != ""){
            $user_timezone = $session['timezone'];
        } else {
        		$user_timezone = "Australia/Perth";
        }
		date_default_timezone_set($user_timezone);
        return self::format(self::$display_date_format,self::userLocalDateTime());
    }

    public static function formatUserLocalTime($format="hh:mm a"){
		$session = new CHttpSession;
		if($session['timezone'] != ""){
            $user_timezone = $session['timezone'];
        } else {
        		$user_timezone = "Australia/Perth";
        }
		date_default_timezone_set($user_timezone);
		$date_time=self::userLocalDateTime();
		//$formatter = new CDateFormatter(Yii::app()->locale);
		//$result= $formatter->format($format,$date_time->getTimestamp());
		//print_r($result);
		//Yii::app()->end();
        return self::format($format,$date_time);
    }


    public static function parseDate($dateString){

        foreach(DateUtil::$knownDateFormats as $format){

            $ts = CDateTimeParser::parse($dateString,$format);
            if($ts) {
                $result = new DateTime();
                $result->setTimestamp($ts);
                return $result;
            }

        }
        return null;
        //throw new CException("Unrecognised date format ".$dateString);

    }

    public static function parseTime($timeString){

        foreach(DateUtil::$knownTimeFormats as $format){

            $ts = CDateTimeParser::parse($timeString,$format);
            if($ts) {
                $result = new DateTime();
                $result->setTimestamp($ts);
                return $result;
            }

        }
        return null;
        //throw new CException("Unrecognised date format ".$dateString);

    }
}