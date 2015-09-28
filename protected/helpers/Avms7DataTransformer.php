<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 26/09/15
 * Time: 6:44 PM
 */
class Avms7DataTransformer
{
    private $levels = [
        '1' => 'Admin',
        '3' => 'Issuing-Body',
        '2' => 'Airport Operator',
        '8' => 'Airport Operator Supervisor',
        '6' => 'Agent',
        '7' => 'Agent Operator',
        '9' => 'Agent Operator Supervisor',
        '4' => 'Company',
        '10' => 'ASIC-Sponsor',
        '5' => 'Individual'
    ];
    private $roleLevel = [
        Roles::ROLE_SUPERADMIN=>[1],
        Roles::ROLE_AIRPORT_OPERATOR=>[2],
        Roles::ROLE_ISSUING_BODY_ADMIN=>[3],
        Roles::ROLE_VISITOR=>[5],
        Roles::ROLE_AGENT_ADMIN=>[6],
        Roles::ROLE_AGENT_AIRPORT_OPERATOR=>[7],
        Roles::ROLE_VISITOR=>[4,10,5]
    ];

    private $tenantQueries = [

    ];

    private $db;
    private $dataHelper;

    public function __constructor($db)
    {
        $this->db = $db;
        $this->dataHelper = new DataHelper($this->db);
    }

    public function importTenant($code){

        $data = [];
        $data["company"]        = $this->getCompanies($code);
        $data["user"]           = $this->getUsers($code);
        $data["tenant"]         = $this->getTenant($code);
        $data["tenant_agent"]   = $this->getTenantAgents($code);
        $data["visitor"]        = $this->getVisitors($code);
        $data["visit"]          = $this->getVisit($code);

    }

    public function getCompanies($code)
    {
        $ib = $this->getIssuingBody($code);
        $sql = "SELECT ".
                "FROM company ".
                "JOIN oc_set ON company.CompanyID = oc_set.CompanyID ".
                "JOIN user ON user.ID = oc_set.UserID";


    }

    private function getIssuingBody($code)
    {
        $fileName = Yii::app()->basePath."/helpers/ASIC-Issuing-Bodies.csv";
        $lines = file($fileName);

        foreach($lines as $line){
            $parts = explode(",",$line);
            if($parts[1]==strtoupper($code)){
                return [
                    "IssuingBody" => $parts[0],
                    "IBCode" => $parts[1],
                    "IBType" => $parts[2],
                    "Company" => $parts[3],
                    "paid" => $parts[4]
                ];
            }
        }
        return null;
    }


}