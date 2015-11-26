<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 26/11/2015
 * Time: 8:42 PM
 */
class FileCsvHelper
{
    public $fileName = null;
    private $handle = null;
    private $header = [];
    private $row = null;

    public function __construct($fileName){
        $this->fileName = $fileName;
        $this->handle = fopen($fileName, "r");
        $this->row =  $this->nextRow();
    }

    public function __destruct()
    {
        fclose($this->handle);
    }

    public function hasMore()
    {
        return $this->row!=null;
    }

    public function nextRow()
    {
        try{
            return $this->row;
        } finally {
            $this->row = $this->readLine();
        }
    }

    private function readLine(){

        while(($line = fgets($this->handle)) !== false)
        {
            $vals = str_getcsv($line,',','"',"\\");
            if(sizeof($vals)==0){
                continue;
            }

            if(sizeof($this->header)<sizeof($vals) && $this->row == null){
                $this->header = $vals;
                continue;
            }

            return CSVHelper::combine($this->header,$vals);

        }
        return null;
    }

}