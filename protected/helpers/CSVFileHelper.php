<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 26/11/2015
 * Time: 9:15 PM
 */
class CsvFileHelper
{
    public $fileName = null;
    private $header = [];
    private $row = null;
    private $rows = null;
    private $currentRowNum = 0;


    //public function __construct($fileName){
    //    $this->fileName = $fileName;
    //    $this->readLine();
   // }

    public function open($fileName){
        $this->fileName = $fileName;
        $this->row = $this->readLine();
    }
    public function hasMore()
    {
        return $this->row!=null;
    }

    public function nextRow()
    {
        $result = $this->row;
        $this->row = $this->readLine();
        return $result;
    }

    private function readLine(){

        if($this->rows==null){
            $this->rows = file($this->fileName);
        }
        while($this->currentRowNum < sizeof($this->rows))
        {
            $vals = str_getcsv($this->rows[$this->currentRowNum],',','"',"\\");
            $this->currentRowNum++;
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