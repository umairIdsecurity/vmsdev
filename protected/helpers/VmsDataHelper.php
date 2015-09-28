<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 26/09/15
 * Time: 8:55 PM
 */
class VmsDataHelper
{

    private $db;
    private $dataHelper;

    public function __constructor($db)
    {
        $this->db = $db;
        $this->dataHelper = new DataHelper($this->db);
    }


    private $referenceTables = [
        'card_status',
        'card_type',
        'company_type',
        'country',
        'helpdesk',
        'helpdesk_group',
        'helpdesk_group_user_role',
        'module',
        'reasons',
        'roles',
        'tbl_migration',
        'user_status',
        'user_type',
        'visitor_card_status',
        'visitor_status',
        'visit_status',
    ];


    private $startupDataQueries = [
        ['table'=>'tenant','condition'=>'id=1'],
        ['table'=>'company_laf_preferences','condition'=>'id=1'],
        ['table'=>'company','condition'=>'id=1'],
        ['table'=>'user','condition'=>'id=1'],
        ['table'=>'license_details','condition'=>'id=1'],
    ];

    public function actionExportMinimalDatabase()
    {
        $this->actionExportSchema();
        $this->actionExportReferenceData();
        $this->actionExportStartupData();


    }

    public function actionExportReferenceData(){
        $data = [];
        foreach($this->referenceTables as $table){
            $data[] = $this->dataHelper->buildExportData($table,null);
        }
        $fileName = realpath($yii=dirname(__FILE__)."/../../database")."/json/referencedata.json";
        file_put_contents($fileName, CJSON::encode($data));
    }

    public function actionExportStartupData(){
        $data = [];
        foreach($this->startupDataQueries as $query){
            $data[] = $this->dataHelper->buildExportData($query['table'],$query['condition']);
        }
        $fileName = realpath($yii=dirname(__FILE__)."/../../database")."/json/startupdata.json";
        file_put_contents($fileName, CJSON::encode($data));
    }
}