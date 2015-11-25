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
            if(CSVHelper::countVals($vals)>1){
                if(sizeof($vals) > sizeof($header)){
                    $header = $vals;
                    continue;
                } else if($header!=null){
                    $result[] = array_combine($header,$vals);
                }
            }
        }
        return $result;
    }

    private static function countVals($vals){
        $r = 0;
        for($i=0;$i<sizeof($vals);$i++){
            if($vals[$i]>''){
                $r++;
            }
        }
        return $r;
    }


}