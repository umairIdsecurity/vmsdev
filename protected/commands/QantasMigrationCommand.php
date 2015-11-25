<?php
/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 21/11/2015
 * Time: 10:28 AM
 */
class QantasMigrationCommand extends CConsoleCommand
{
    private $vms = null;
    private $tenant = null;
    private $tenantAgent = null;
    private $workstation = null;
    private $createdBy = null;
    private $company = null;
    private $visitorType = null;

    public function actionTest()
    {
        $result = AddressHelper::parse("1/32 Kilarney Heights Kallaroo WA 6025");
        echo $result;
    }

    public function actionImport()
    {
        // load the file
        $rows = CSVHelper::ImportCsvFromFile("~/Downloads/201505 Qantas VIC MAY 2015.csv");

        $vms = new DataHelper(Yii::app()->db);
        $ibcode = 'PER';

        $this->createdBy = 1;

        // get the tenant
        $this->tenant = $vms->getFirstRow("select * from company where code = '$ibcode' and is_deleted = 0 and company_type=1");
        if($this->tenant==null) throw new CException("Tenant for $ibcode not found");

        // ensure a tenant agent
        $this->ensureTenantAgentForQuantas();

        // ensure a visitor type
        $this->ensureVisitorTypeForQuantas();

        // import the file

        foreach($rows as $row){
            $company        = $this->ensureCompanyFromData($row);
            $sponsor        = $this->ensureSponsorFromData($row,$company);
            $visitor        = $this->ensureVisitorFromData($row,$sponsor,$company);
            $cardGenerated  = $this->ensureCardGeneratedFromData($row,$visitor);
            $visit          = $this->ensureVisitFromData($row,$cardGenerated,$visitor);
        }
    }


    function ensureTenantAgentForQuantas(){

        $this->tenantAgent = $this->vms->getFirstRow("select * from company where tenant = ".$this->tenant['id']." and company_type=2 and name like '%$tenantAgentName%' and isDeleted = 0");
        if($this->tenantAgent==null){
            $this->createTenantAgentFor();
        }
    }

    function ensureVisitorTypeForQuantas(){
        $visitorTypeName = 'Other for data import';
        $this->visitorType = $this->vms->getFirstRow("select * from visitor_type where name='$visitorTypeName' and tenant = ".$this->tenant['id']);
        if($this->visitorType==null){
           $this->visitorType = $this->vms->insertRow('visitor_type',
               [
                   'name'=>$visitorTypeName,
                   'created_by'=>$this->createdBy,
                   'tenant'=>$this->tenant['id'],
                   'tenant_agent'=>$this->tenant_agent['id'],
                   'is_deleted'=>0,
                   'module'=>'AVMS'
               ],
               true
           );
        }
    }


    function ensureCompanyFromData($row){

        if($this->company==null){
            $companyName = 'Qantas company for data import';
            $company =  $this->vms->getFirstRow("
                                      select *
                                      from company
                                      where name = $companyName
                                      and tenant=".$this->tenant[id]."
                                      and tenant_agent =".$this->tenantAgent['id']."
                                      and company_type=2");
            if($company==null){
                $this->company = $this->vms->insertRow('company',
                    [
                        'name'=>$companyName,
                        'trading_name'=>$companyName,
                        'contact'=>'Unknown Contact',
                        'created_by_user'=>$this->createdBy,
                        'tenant'=>$this->tenant['id'],
                        'tenant_agent'=>$this->tenant_agent['id']
                    ],
                    true
                );
            } else {
                $this->company = $company;
            }
        }
        return $this->company;
    }

    function ensureSponsorFromData($row,$company){
        $nameParts = explode(' ',$row['ASIC SponsorName']);
        $firstName = $nameParts[0];
        $middlelName = null;
        if(sizeof($nameParts)==3){
            $lastName = $nameParts[2];
            $middleName = $nameParts[1];
        } else {
            $lastName = $nameParts[1];
        }
        $sponsor =  $this->vms->getFirstRow("
                                  select *
                                  from visitor
                                  where first_name = '$firstName'
                                  and last_name = '$lastName'
                                  and asic_no = '".$row['ASIC SponsorNumber']."'
                                  and tenant=".$this->tenant[id]."
                                  and tenant_agent =".$this->tenantAgent['id']);

        if($sponsor==null){
            $identificationType= $row["Document Type"]=='Driving Licence'?'DRIVERS_LICENSE':
                ($row["Document Type"]=="Passport"?'PASSPORT':null);

            return $this->vms->insertRow('visitor',
                [
                    'first_name'=>$firstName,
                    'middle_name'=>$middleName,
                    'last_name'=>$lastName,
                    'email'=>$firstName.".".$lastName."@unknowncompany",
                    'contact_number'=>$row['Mobile Number'],
                    'company'=>$company['id'],
                    'role'=>10,
                    'visitor_type'=>$this->visitorType['id'],
                    'visitor_workstation'=>$this->workstation['id'],
                    'profile_type'=>'ASIC'
                ],
                true
            );
        }

        return $sponsor;
        //'identification_document_type'=>$identificationType,
        //            'identification_country_issued'=>13,
        //            'identification_document_no'=>$row['Document ID']


        //strtotime(str_replace('/','-',$row['DOB']))
    }

    function protectFileImport($fileName,$rows){
        $crc = crc32(implode("\r\n",$rows));
        $existing = $this->vms->getFirstRow("Select * from imported_file where crc='$crc'");
        if($existing!=null){
            return false;
        } else {
            $this->vms->insertRow([
                'crc'=>$crc,
                'file_name'=>$fileName,
                'created_by_user'=>$this->createdBy,
                'imported_datetime'=>date('Y-m-d H:i:s')
            ]);
        }
        return true;
    }

    function createTenantAgent(){

        $id = $this->vms->insertRow('company',
            [
                'name'=>'Qantas',
                'trading_name'=>'Qantas',
                'contact'=>'Unknown Contact',
                'created_by_user'=>$this->createdBy,
                'tenant'=>$this->tenant['id']
            ],
            true
        );
        $this->tenantAgent = $this->vms->getFirstRow("select * from company where id = $id");

        $this->vms->insertRow('tenant_agent',
            [
                'id'=>$id,
                'tenant_id'=>$this->tenant['id'],
                'for_module'=>'AVMS',
                'is_deleted'=>0,
                'created_by'=>$this->createdBy,
                'date_created'=>date('Y-m-d H:i:s')
            ],
            false
        );

        $id = $this->vms->insertRow('workstation',
            [
                'name'=>'Quantas',
                'contact_name'=>'Unknown Contact',
                'contact_number'=>'000000000',
                'contact_email_address'=>'import@quantas.com',
                'tenant'=>$this->tenant['id'],
                'tenant_agent'=>$this->tenant_agent['id'],
                'is_deleted'=>0,
                'timezone_id'=>128
            ],
            true
        );
        $this->workstation = $this->vms->getFirstRow("select * from workstation where id = $id");

    }

    function ensureVisitorFromData($row){


        $visitor =  $this->vms->getFirstRow("
                                  select *
                                  from visitor
                                  where first_name = '".$row['VFirstName']."'
                                  and last_name = '".$row['VLastName']."'
                                  and date_of_birth = '".strtotime(str_replace('/','-',$row['DOB']))."'
                                  and tenant=".$this->tenant[id]."
                                  and tenant_agent =".$this->tenantAgent['id']);

        if($visitor==null){

            $identificationType= $row["Document Type"]=='Driving Licence'?'DRIVERS_LICENSE':
                ($row["Document Type"]=="Passport"?'PASSPORT':null);

            return $this->vms->insertRow('visitor',
                [
                    'first_name'                    =>$row['VFirstName'],
                    'middle_name'                   =>null,
                    'last_name'                     =>$row['VLastName'],
                    'email'                         =>$row['VFirstName'].".".$row['VLastName']."@unknowncompany",
                    'contact_number'                =>$row['Mobile Number'],
                    'date_of_birth'                 =>strtotime(str_replace('/','-',$row['DOB'])),
                    'company'                       =>$this->company['id'],
                    'role'                          =>10,
                    'visitor_type'                  =>$this->visitorType['id'],
                    'visitor_workstation'           =>$this->workstation['id'],
                    'profile_type'                  =>$row['ASIC Applicant']==NO?'VIC':'ASIC',
                    'identification_document_type'  =>$identificationType,
                    'identification_country_issued' =>13,
                    'identification_document_no'    =>$row['Document ID'],
                    'contact_unit'                  =>null,
                    'contact_street_no'=>null,
                    'contact_street_name'=>null,
                    'contact_street_type'=>null,
                    'contact_suburb'=>null,
                    'contact_state'=>null,
                    'contact_country'=>null,
                    'contact_postcode'=>null,
                    'asic_no'=>null,
                    'asic_expiry'=>null,
                    'date_created'=>null,



                ],
                true
            );
        }

        return $visitor;



        //strtotime(str_replace('/','-',$row['DOB']))
    }

}