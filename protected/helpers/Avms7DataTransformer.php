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
        1=>Roles::ROLE_SUPERADMIN, //5
        2=>Roles::ROLE_AIRPORT_OPERATOR, //12
        3=>Roles::ROLE_ISSUING_BODY_ADMIN, //11
        4=>Roles::ROLE_VISITOR, //10
        5=>Roles::ROLE_VISITOR, //10
        6=>Roles::ROLE_AGENT_AIRPORT_ADMIN, //13
        7=>Roles::ROLE_AGENT_AIRPORT_OPERATOR,// 14
        8=>Roles::ROLE_ISSUING_BODY_ADMIN, //11
        9=>Roles::ROLE_AGENT_AIRPORT_ADMIN, //13
        10=>Roles::ROLE_VISITOR, //10
    ];


    private $db;
    private $dataHelper;

    public function __construct($db)
    {
        $this->db = $db;
        $this->dataHelper = new DataHelper($this->db);
    }

    public function exportTenant($code){

        $data = [];
        $data = array_merge_recursive($data,$this->getTenant($code));

        echo json_encode($data,JSON_PRETTY_PRINT);

    }

    public function getTenant($code){

        $default_condition = "";
        $tenant = "";
        $userTable = "";

        return [

            'photo'                             =>"SELECT photoID as id, filename as unique_filename,null as relativepath,null as db_image) "
                                                    ."FROM users_photo "
                                                    ." JOIN users on users.Id = users_photo.UserID AND `Default` = 1;" ,

            'company_laf_preferences'           =>['JOIN company ON company_laf_preferences.id = company.company_laf_preferences '.
                $default_condition],

            'company'                           =>[$default_condition." OR (id=".$tenant.") "],


            'tenant'                            =>['WHERE id='.$tenant.''],

            'tenant_agent'                      =>['WHERE tenant_id='.$tenant.''],

            'user'                              =>[$default_condition],


            'contact_person'                    =>['WHERE tenant='.$tenant],

            'reasons'                            =>['WHERE tenant='.$tenant],

            'password_change_request'           =>['JOIN '.$userTable.' ON '.$userTable.'.id = password_change_request.user_id '.
                $default_condition],

            'tenant_agent_contact'              =>['WHERE tenant_id='.$tenant],

            'tenant_contact'                    =>['WHERE tenant='.$tenant],

            'user_notification'                 =>['JOIN '.$userTable.' ON '.$userTable.'.id = user_notification.user_id '.
                $default_condition],

            'notification'                      =>['JOIN user_notification ON user_notification.user_id = user_notification.user_id '.
                'JOIN '.$userTable.' ON '.$userTable.'.id = user_notification.user_id '.
                $default_condition],

            'workstation'                       =>[$default_condition],

            'workstation_card_type'             =>["JOIN workstation ON workstation.id = workstation_card_type.workstation ".
                $default_condition],

            'user_workstation'                  =>['JOIN '.$userTable.' ON '.$userTable.'.id = user_workstation.user_id '.
                $default_condition],

            'visitor_type'                      =>[$default_condition],
            'visit_reason'                      =>[$default_condition],

            'visitor'                           =>[$default_condition],

            'card_generated'                    =>["WHERE tenant=".$tenant],

            'visit'                             =>[$default_condition],

            'visitor_type_card_type'            =>[$default_condition],

            'visitor_password_change_request'   =>['JOIN visitor ON visitor.id = visitor_password_change_request.visitor_id '.
                $default_condition],



            'reset_history'                     =>['JOIN visitor ON visitor.id = reset_history.visitor_id '.
                $default_condition],

            'cardstatus_convert'                =>['JOIN visitor ON visitor.id = cardstatus_convert.visitor_id '.
                $default_condition],

            'contact_person'                    =>['WHERE tenant = '.$tenant],

            //'contact_support'                   =>['JOIN '.$userTable.' ON user.id = contact_support.user_id '.$default_condition],

            //'audit_trail'                       =>['JOIN '.$userTable.' ON user.id = audit_trail.user_id '.$default_condition],

        ];

    }
    public function getTenantVisitors($code){

        return [
            'company'=>$this->getTenantVisitorCompanies($code),
            'user'=>$this->getTenantVisitorUsers($code),
            'visitor'=>[
                'visitor'=>$this->getTenantVisitorVisitors($code),
                'visitor'=>$this->getTenantVisitorVisits($code),
                ]
            ];
    }

    public function getTenantVisitorCompanies($code){
        $companies = "";
    }

    public function getTenantVisitorUsers($code){
        $users = $this->dataHelper->getRows(
            "SELECT DISTINCT ".
            "FirstName as first_name, ".
            "LastName as last_name, ".
            "EmailAddress as email, ".
            "Telephone as contact_number, ".
            "DateOfBirth as date_of_birth, ".
            "Password as password, ".
            "1 as allowed_module, ".
            "Level as role, ".
            "2 as user_type, ".
            "1 as user_status, ".
            "1 as created_by, ".
            "0 as is_deleted, ".
            "Photo as photo, ".
            "asic_number as asic_no, ".
            "asic_expiry as asic_expiry ".
            "FROM users ".
            "JOIN asic_data ON asic_data.UserId = users.ID ".
            "JOIN oc_set ON users.ID = oc_set.UserID ".
            "WHERE AirportCode = '".$code."' ".
            "AND Level = '5'");

        $result = [];
        foreach($users as $user){

            $user['role'] = $this->roleLevel[$user['role']];

            if($user['photo']>'') {
                $user['photo'] = "https://avms7.idsecurity.com.au/store/files/" . $user["photo"];
            }
            $result[] = $user;

        }
        return $result;
    }


    public function getTenantAgents($code){

        $tenantAgents = $this->dataHelper->getRows(
            "SELECT concat_ws(' ',FirstName, LastName) as contact, ".
                "Company as name, ".
                "Company as trading_name, ".
                "IBCode as code, ".
                "EmailAddress as email_address, ".
                "trim(concat_ws(' ',concat(Unit,'/'),StreetNo,Street,StreetType,Suburb,State,PostCode)) as billing_address, ".
                "Telephone as office_number, ".
                "Mobile as mobile_number ".
            "FROM users ".
            "WHERE (EmailAddress > '' OR FirstName > '' OR LastName > '') ".
            "AND IBCode='".$code."' ".
            "AND level = '6' "
        );
        $result = [];
        foreach($tenantAgents as $company){

            $company['company_type'] = CompanyType::COMPANY_TYPE_AGENT;
            $company['is_deleted'] = false;
            $company['created_by_user'] = 1;
            $tenantAgent = ['company'=>[],'user'=>[]];
            $tenantAgent['company'][] = $company;
            $tenantAgent['user'] = $this->getTenantAgentUsers($code,$company);


            $result[] = $tenantAgent;

        }
        return $result;

    }
    public function getTenantAgentUsers($code,$company)
    {
        $users = $this->dataHelper->getRows(
            "SELECT ".
                "FirstName as first_name, ".
                "LastName as last_name, ".
                "EmailAddress as email, ".
                "Telephone as contact_number, ".
                "DateOfBirth as date_of_birth, ".
                "Password as password, ".
                "1 as allowed_module, ".
                "Level as role, ".
                "1 as user_type, ".
                "1 as user_status, ".
                "1 as created_by, ".
                "0 as is_deleted, ".
                "Photo as photo, ".
                "asic_number as asic_no, ".
                "asic_expiry as asic_expiry ".
            "FROM users ".
            "JOIN asic_data ON asic_data.UserId = users.ID ".
            "WHERE IBCode = '".$code."' ".
            "AND (EmailAddress like '%@". explode('@',$company['email_address'] )[1]."' ".
            "OR company = '".$company['name']."') ".
            "AND Level in ('6','7','9')");

        $result = [];
        foreach($users as $user){

            $user['role'] = $this->roleLevel[$user['role']];

            if($user['photo']>'') {
                $user['photo'] = "https://avms7.idsecurity.com.au/store/files/" . $user["photo"];
            }
            $result[] = $user;

        }

        return $result;

    }
    public function getTenantCompany($code){

        $ib = $this->getIssuingBody($code);



        $tenantCompany = [
            'code' => $ib['IBCode'],
            'name' => $ib['IssuingBody']." Airport",
            'trading_name' => $ib['Company'],
            'company_type' => CompanyType::COMPANY_TYPE_TENANT,
            'created_by_user=1'
        ];

        $userArributes =$this->dataHelper->getFirstRow(
            "SELECT concat_ws(' ',FirstName, LastName) as contact, ".
                "EmailAddress as email_address, ".
                "trim(concat_ws(' ',concat(Unit,'/'),StreetNo,Street,StreetType,Suburb,State,PostCode)) as billing_address, ".
                "Telephone as office_number, ".
                "Mobile as mobile_number ".
            "FROM users ".
            "WHERE (EmailAddress > '' OR FirstName > '' OR LastName > '') ".
            "AND IBCode='".$code."' ".
            "AND level = 3 "
        );

        return array_merge_recursive($tenantCompany,$userArributes);
    }

    public function getTenantUsers($code){

        $users = $this->dataHelper->getRows(
                "SELECT ".
                    "FirstName as first_name, ".
                    "LastName as last_name, ".
                    "EmailAddress as email, ".
                    "Telephone as contact_number, ".
                    "DateOfBirth as date_of_birth, ".
                    "Password as password, ".
                    "1 as allowed_module, ".
                    "Level as role, ".
                    "1 as user_type, ".
                    "1 as user_status, ".
                    "1 as created_by, ".
                    "0 as is_deleted, ".
                    "Photo as photo, ".
                    "asic_number as asic_no, ".
                    "asic_expiry as asic_expiry ".
                "FROM users ".
                "JOIN asic_data ON asic_data.UserId = users.ID ".
                "WHERE IBCode = '".$code."' ".
                "AND Level in ('2','3','8')");
        $result = [];
        foreach($users as $user){

            $user['role'] = $this->roleLevel[$user['role']];

            if($user['photo']>'') {
                $user['photo'] = "http://avms7.idsecurity.com.au/store/files/" . $user["photo"];
            }
            $result[] = $user;
        }

        return ['user'=>$result];

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