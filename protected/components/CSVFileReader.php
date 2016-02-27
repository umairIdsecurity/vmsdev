<?php

class CSVFileReader
{
    public $fileName = null;
    private $header = [];
    private $row = null;
    private $previousRow = null;
    private $rows = null;
    private $currentRowNum = 0;
    private $file = null;

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
        $this->previousRow = $this->row;
        $this->row = $this->readLine();
        return $result;
    }

    private function readLine(){

        if($this->file==null){
            $this->file = fopen($this->fileName,"r");
        }

        //while($this->currentRowNum < sizeof($this->rows))
        while(!feof($this->file))
        {
            $vals = fgetcsv($this->file);
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