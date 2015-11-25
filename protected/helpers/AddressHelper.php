<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 25/11/2015
 * Time: 12:49 PM
 */
class AddressHelper
{

    private static $regex = '((?<strPOBox>((POBox|PO\sBox)\s*\d*)),?\s?)?(((?<strUnit>([\w\d\s\,]*)),\s?)?( (?<strStreet>([\w\s\-]*\w\s(st\s)?[\w]*\s(street|st|road|rd|close|cl|avenue|ave|av|path|ph|drive|drv|LOOP|COURT|CT|CIRCLE|LANE|LN)) ),?\s?))?((?<strTown>([\p{Ll}\p{Lu}\p{Lo}\p{Pc}\p{Lt}\p{Lm}\s]*)),?\s?)?((?<strState>(Victoria|VIC|New South Wales|NSW|South Australia|SA|Northern Territory|NT|West Australia|WA|Tasmania|TAS|ACT|Queensland|QLD))\s*)?(?<strPostalCode>(\d{4}),?\s?)?(?<strCountry>(Australia))?';

    public static function parse($address){
        $result = [];
        preg_match_all(AddressHelper::$regex,$address,$result);
        return $result;
    }

}