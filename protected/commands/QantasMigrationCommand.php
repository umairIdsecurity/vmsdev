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
    private $visitReason = null;
    private $ibcode = null;

    public function actionTest()
    {
        //$result = AddressHelper::parse(strtoupper("1/32 Kilarney Heights"));
        echo $this->parseDateForSql('1/1/13');
        //echo $result;
    }

    public function actionImportFromDirectory($dirName){

    }

    public function actionImportFile($fileName)
    {
        // load the file
        $rows = CSVHelper::ImportCsvFromFile($fileName);

        $vms = new DataHelper(Yii::app()->db);
        $transaction = Yii::app()->db->beginTransaction();
        try {



            $this->vms = $vms;
            $this->ibcode = 'PER';

            $this->createdBy = 1;

            // get the tenant
            $this->tenant = $vms->getFirstRow("select * from company where code = '" . $this->ibcode . "' and is_deleted = 0 and company_type=1");
            if ($this->tenant == null) throw new CException("Tenant for " . $this->ibcode . " not found");

            // ensure a tenant agent
            $this->ensureTenantAgent();

            // ensure a visitor type
            $this->ensureVisitorType();

            // ensure a visit reason
            $this->ensureVisitReason();

            foreach ($rows as $row) {
                $company = $this->ensureCompanyFromData($row);
                $sponsor = $this->ensureSponsorFromData($row, $company);
                $visitor = $this->ensureVisitorFromData($row, $company);
                $cardGenerated = $this->ensureCardGeneratedFromData($row);
                $visit = $this->ensureVisitFromData($row,$cardGenerated,$visitor,$sponsor);
            }
            $transaction->commit();

        } catch (CException $e){

            echo "\r\n".$e->getMessage();
            $transaction->rollback();
        }

    }


    function ensureTenantAgent(){

        $tenantAgentName = 'Qantas';
        $this->tenantAgent = $this->vms->getFirstRow("select * from company where tenant = ".$this->tenant['id']." and company_type=2 and name like '%$tenantAgentName%' and is_deleted = 0");
        if($this->tenantAgent==null){
            $this->createTenantAgent();
        }
    }

    function ensureVisitorType(){
        $visitorTypeName = 'Other: Data Import';
        $sql = "select * from visitor_type where name='$visitorTypeName' and tenant = ".$this->tenant['id'];
        $this->visitorType = $this->vms->getFirstRow($sql);

        if($this->visitorType==null){
            $newRow = [
                'name'=>$visitorTypeName,
                'created_by'=>$this->createdBy,
                'tenant'=>$this->tenant['id'],
                'tenant_agent'=>$this->tenantAgent['id'],
                'is_deleted'=>'0',
                'module'=>'AVMS'
            ];
           $this->visitorType = $this->vms->insertRow('visitor_type',$newRow,true);
        }
    }

    function ensureVisitReason(){
        $reason = 'Other: Data Import';
        $this->visitReason = $this->vms->getFirstRow("select * from visit_reason where reason='$reason' and tenant = ".$this->tenant['id']);
        if($this->visitReason==null){
            $newRow = [
                'reason'=>$reason,
                'created_by'=>$this->createdBy,
                'tenant'=>$this->tenant['id'],
                'tenant_agent'=>$this->tenantAgent['id'],
                'is_deleted'=>'0',
                'module'=>'AVMS'
            ];
            $this->visitReason = $this->vms->insertRow('visit_reason',$newRow,true);
        }
    }


    function ensureCompanyFromData($row){

        if($this->company==null){
            $companyName = 'Qantas: Data Import';
            $company =  $this->vms->getFirstRow("
                                      select *
                                      from company
                                      where name = '$companyName'
                                      and tenant=".$this->tenant['id']."
                                      and tenant_agent =".$this->tenantAgent['id']."
                                      and company_type=2");
            if($company==null){
                $newRow  = [
                    'name'=>$companyName,
                    'trading_name'=>$companyName,
                    'contact'=>'Unknown Contact',
                    'created_by_user'=>$this->createdBy,
                    'tenant'=>$this->tenant['id'],
                    'tenant_agent'=>$this->tenantAgent['id'],
                    'is_deleted'=>'0'
                ];
                $this->company = $this->vms->insertRow('company',$newRow ,true);
            } else {
                $this->company = $company;
            }
        }
        return $this->company;
    }

    function ensureSponsorFromData($row,$company){
        $nameParts = explode(' ',$row['ASIC Sponsor Name']);
        $firstName = $nameParts[0];
        $middleName = null;
        if(sizeof($nameParts)==3){
            $lastName = $nameParts[2];
            $middleName = $nameParts[1];
        } else {
            if(sizeof($nameParts)>=2) {
                $lastName = $nameParts[1];
            } else {
                $lastName='Unknown';
            }
        }
        $qFirstName = $this->vms->db->quoteValue($firstName);
        $qLastName = $this->vms->db->quoteValue($lastName);

        $sponsor =  $this->vms->getFirstRow("
                                  select *
                                  from visitor
                                  where first_name = $qFirstName
                                  and last_name = $qLastName
                                  and asic_no = '".$row['ASIC SponsorNumber']."'
                                  and tenant=".$this->tenant['id']."
                                  and tenant_agent =".$this->tenantAgent['id']);

        if($sponsor==null){
            $newRow = [
                'first_name'=>$firstName,
                'middle_name'=>$middleName,
                'last_name'=>$lastName,
                'email'=>$firstName.".".$lastName."@unknowncompany",
                'contact_number'=>$this->valueIfEmpty($row['Mobile Number'],'0000000000'),
                'company'=>$company['id'],
                'role'=>'10',
                'visitor_type'=>$this->visitorType['id'],
                'visitor_workstation'=>$this->workstation['id'],
                'profile_type'=>'ASIC',
                'tenant'=>$this->tenant['id'],
                'tenant_agent'=>$this->tenantAgent['id'],
                'is_deleted'=>'0'
            ];
            return $this->vms->insertRow('visitor',$newRow,true);
        }

        return $sponsor;

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

        $row = [
            'name'=>'Qantas',
            'trading_name'=>'Qantas',
            'contact'=>'Unknown Contact',
            'created_by_user'=>$this->createdBy,
            'tenant'=>$this->tenant['id'],
            'is_deleted'=>'0'
        ];
        $this->tenantAgent = $this->vms->insertRow('company', $row, true );

        $newRow = [
            'id'=>$this->tenantAgent['id'],
            'tenant_id'=>$this->tenant['id'],
            'for_module'=>'AVMS',
            'is_deleted'=>'0',
            'created_by'=>$this->createdBy,
            'date_created'=>date('Y-m-d H:i:s')
        ];
        $this->vms->insertRow('tenant_agent',$newRow,false);

        $newRow =  [
            'name'=>'Quantas',
            'contact_name'=>'Unknown Contact',
            'contact_number'=>'000000000',
            'contact_email_address'=>'import@quantas.com',
            'tenant'=>$this->tenant['id'],
            'tenant_agent'=>$this->tenantAgent['id'],
            'is_deleted'=>'0',
            'timezone_id'=>'128'
        ];
        $this->workstation = $this->vms->insertRow('workstation',$newRow,true);

    }

    function ensureVisitorFromData($row,$company){

        $addressParts = AddressHelper::parse($row['Address1']);

        $visitor =  $this->vms->getFirstRow("select *
                                  from visitor
                                  where first_name = ".$this->vms->db->quoteValue($row['VFirstName'])."
                                  and last_name = ".$this->vms->db->quoteValue($row['VLastName'])."
                                  and date_of_birth = '".$this->parseDateForSql($row['DOB'])."'
                                  and tenant=".$this->tenant['id']."
                                  and tenant_agent =".$this->tenantAgent['id']
                                    );

        if($visitor==null){

            $identificationType= $row["Document Type"]=='Driving Licence'?'DRIVERS_LICENSE':
                ($row["Document Type"]=="Passport"?'PASSPORT':null);
            $newRow = [
                'first_name'                    =>$row['VFirstName'],
                'middle_name'                   =>null,
                'last_name'                     =>$row['VLastName'],
                'email'                         =>$row['VFirstName'].".".$row['VLastName']."@unknowncompany",
                'contact_number'                =>$this->valueIfEmpty($row['Mobile Number'],'0000000000'),
                'date_of_birth'                 =>$this->parseDateForSql($row['DOB']),
                'company'                       =>$company['id'],
                'role'                          =>'10',
                'visitor_type'                  =>$this->visitorType['id'],
                'visitor_workstation'           =>$this->workstation['id'],
                'profile_type'                  =>$row['ASIC Applicant']=='NO'?'VIC':'ASIC',
                'identification_type'           =>$identificationType,
                'identification_country_issued' =>'13',
                'identification_document_no'    =>$row['Document ID'],
                'contact_unit'                  =>$addressParts['Unit'],
                'contact_street_no'             =>$addressParts['StreetNumber'],
                'contact_street_name'           =>$addressParts['StreetName'],
                'contact_street_type'           =>$addressParts['StreetType'],
                'contact_suburb'                =>$row['Address2'],
                'contact_state'                 =>$row['State'],
                'contact_country'               =>$this->vms->getFirstRow("select * from country where name = '".$row['Country']."'")['id'],
                'contact_postcode'              =>$row['Post Code'],
                'asic_no'                       =>null,
                'asic_expiry'                   =>null,
                'date_created'                  =>date('Y-m-d'),
                'tenant'                        =>$this->tenant['id'],
                'tenant_agent'                  =>$this->tenantAgent['id'],
                'is_deleted'=>'0'
            ];
            return $this->vms->insertRow('visitor',$newRow,true);
        }
        return $visitor;
    }

    function ensureCardGeneratedFromData($row){

        $id = $this->vms->getFirstRow('select max(id)+1 as id from card_generated')['id'].'';
        $num = $this->ibcode.substr('0000000'.$id,-6);
        $startDate =$this->parseDateForSql($row['Date of Issue']);
        $endDate = $this->parseDateForSql($row['Date of Expiry']);
        $newRow = [
            'card_number'=> $num,
            'date_printed'=>$startDate,
            'date_expiration'=>$endDate,
            'date_cancelled'=>null,
            'date_returned'=>$endDate
        ];
        return $this->vms->insertRow('card_generated',$newRow,true);
    }

    public function ensureVisitFromData($row,$cardGenerated,$visitor,$sponsor)
    {
        $newRow = [
            'visitor'           => $visitor['id'],
            'card_type'         =>'3',
            'card'              =>$cardGenerated['id'],
            'visitor_type'      =>$this->visitorType['id'],
            'visitor_status'    =>'1',
            'host'              =>$sponsor['id'],
            'created_by'        =>$this->createdBy,
            'date_in'           =>$this->parseDateForSql($row['Date of Issue']),
            'date_out'          =>$this->parseDateForSql($row['Date of Expiry']),
            'time_in'           =>'00:00:00',
            'time_out'          =>'23:59:59',
            'date_check_in'     =>$this->parseDateForSql($row['Date of Issue']),
            'date_check_out'    =>$this->parseDateForSql($row['Date of Expiry']),
            'time_check_in'     =>'00:00:00',
            'time_check_out'    =>'23:59:59',
            'visit_status'      =>'3',
            'workstation'       =>$this->workstation['id'],
            'tenant'            =>$this->tenant['id'],
            'tenant_agent'      =>$this->tenantAgent['id'],
            'is_deleted'        =>'0',
            'finish_date'       =>$this->parseDateForSql($row['Date of Expiry']),
            'finish_time'       =>'23:59:59',
            'card_returned_date'=>$this->parseDateForSql($row['Date of Expiry']),
            'company'           =>$this->company['id'],
            'visit_reason'      =>$row['Reasonfor VIC Issue']
        ];
        return $this->vms->insertRow('visit',$newRow,true);
    }

    public function parseDateForSql($strDate){
        return DateTime::createFromFormat('d/m/Y',$strDate)->format('Y-m-d');
    }

    public function valueIfEmpty($val,$emptyVal){
        if($val==null || trim($val,' ')==''){
            return $emptyVal;
        }
        return $val;
    }

}