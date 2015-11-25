<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 23/11/2015
 * Time: 9:06 PM
 */
class CSVHelper
{

    public static function ImportCsvFromFile($fileName)
    {
        $rows = file($fileName);
        $header = [];
        $result = [];
        foreach($rows as $row)
        {
            $vals = str_getcsv($row,',','"',"\\");
            if(sizeof($vals)>1){
                if(sizeof($vals) > sizeof($header) && sizeof($header) > 1){
                    $header = $vals;
                    continue;
                } else {
                    $result[] = array_combine($header,$vals);
                }
            }
        }
        return $result;
    }


}