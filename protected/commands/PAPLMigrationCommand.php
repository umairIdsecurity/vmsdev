<?php

class PAPLMigrationCommand extends CConsoleCommand
{

    private $vms = null;
    private $tenant = null;
    private $tenantAgentNameMappings = [
        'Air BP'=>'Air BP',
        'Air Services'=>'Air Services Australia',
        'Airflite'=>'Airflite',
        'Cobham'=>'Cobham',
        'Hawker Pacific'=>'Hawker Pacific',
        'Maxem'=>'Maxem Aviation',
        'Shell'=>'Shell',
        'Skippers'=>'Skippers',
        'Toll'=>'Toll',
        'Universal'=>'Universal Aviation',
    ];
    private $workstationAgentNameMappings = [
        'Skippers'=>'Skippers',
        'Airflite'=>'Airflite',
        'Cobham'=>'Cobham',
        'Hawker Pacific'=>'Hawker Pacific',
        'Maxem Aviation'=>'Maxem Aviation',
        'Toll'=>'Toll',
        'Universal Aviation'=>'Universal Aviation',
        'Quantas'=>'Qantas'
    ];
    private $workstation = [];
    private $tenantAgents = [];
    private $createdBy = null;
    private $company = null;
    private $visitorType = null;
    private $visitReason = null;
    private $ibcode = null;

    public function actionTest()
    {
        $fileName = "/Users/gistewart/Downloads/VIC Register-Deidentified.csv";
        $rows = new CSVFileReader();
        $skipped = 0;
        $rows->open($fileName);
        $i = 0;
        echo "\r\n".date('Y-m-d H:i:s');
        while($rows->hasMore()){


            $row = $rows->nextRow();

            if(isset($row['Residential Address']) && $row['Residential Address']>'') {
                $result = AddressHelper::parse($row['Residential Address']);

                if(!isset($result['PostCode']) || $result['PostCode']=='0000'){
                    $skipped++;
                }
                echo "\r\n" . json_encode($result);
            }
            $i++;
            if ($i > 1000) {
                echo "\r\n" . date('Y-m-d H:i:s').", Skipped $skipped";
                return;
            }
        }

    }

    public function actionMigrate($fileName = "/Users/geoffstewart/Downloads/VIC Register-Deidentified.csv")
    {
        // load the file
        $rows = new CSVFileReader();
        $rows->open($fileName);

        $vms = new DataHelper(Yii::app()->db);
        $transaction = Yii::app()->db->beginTransaction();
        try {

            $this->vms = $vms;
            $this->ibcode = 'PER';
            $this->createdBy = 1;

            // get the tenant
            $this->tenant = $vms->getFirstRow("select * from company where code = '" . $this->ibcode . "' and is_deleted = 0 and company_type=1");
            if ($this->tenant == null) throw new CException("Tenant for " . $this->ibcode . " not found");

            // ensure the visitor type
            $this->ensureVisitorType();

            // ensure visit reason
            $this->ensureVisitReason();
            $count = 0;
            while ($rows->hasMore()) {

                // get next row
                $row = $rows->nextRow();

                // add rows
                $company = $this->ensureCompanyFromData($row);
                $sponsor = $this->ensureSponsorFromData($row, $company);
                $visitor = $this->ensureVisitorFromData($row, $company);
                $cardGenerated = $this->ensureCardGeneratedFromData($row);
                $visit = $this->ensureVisitFromData($row,$cardGenerated,$visitor,$sponsor);
                $count++;
            }

            echo "\r\n imported $count records";

            $transaction->commit();

        } catch (CException $e){

            echo "\r\n".$e->getMessage()."\r\n".$e->getTraceAsString();
            $transaction->rollback();
        }

    }


    function getTenantAgent($row){

        if(!$this->isTenantAgent($row))
            return null;

        $tenantAgentName = $this->tenantAgentNameMappings[$row['Issuing Agent']];

        $tenantAgent = $this->vms->getFirstRow("select * from company where tenant = ".$this->tenant['id']." and company_type=2 and name = '$tenantAgentName' and is_deleted = 0");
        if($tenantAgent==null){
            throw new CException("Tenant agent $tenantAgentName not found.");
        }
        return $tenantAgent;
    }

    function getWorkstation($row){

        $tenantAgent = $this->getTenantAgent($row);
        $sql = "select * from workstation where tenant=".$this->tenant['id'];
        if($row['LOCATION']>''){$sql=$sql." and name like '%".$row['LOCATION']."%' ";}
        if($tenantAgent!=null){$sql=$sql." and tenant_agent=".$tenantAgent['id'];}

        $workstation = $this->vms->getFirstRow($sql);
        if($workstation==null){
            throw new CException("Workstation ".$row['LOCATION']."not found.");
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
                'is_deleted'=>'0',
                'module'=>'AVMS'
            ];
            $this->visitReason = $this->vms->insertRow('visit_reason',$newRow,true);
        }
    }

    function isTenantAgent($row){
        return $row['Issuing Agent']!='Perth Airport';
    }

    function ensureCompanyFromData($row){

        $tenantAgent = $this->isTenantAgent($row)?$this->getTenantAgent($row):null;

        $companyName = $row['Issuing Agent'].': Data Import';
        $company =  $this->vms->getFirstRow("
                                  select *
                                  from company
                                  where name = '$companyName'
                                  and tenant=".$this->tenant['id']." "
                                  .( $tenantAgent!=null ? "and tenant_agent =".$tenantAgent['id']:"")
                                  ." and company_type=2");

        if($company==null){

            $newRow  = [
                'name'=>$companyName,
                'trading_name'=>$companyName,
                'contact'=>'Unknown Contact',
                'created_by_user'=>$this->createdBy,
                'tenant'=>$this->tenant['id'],
                'is_deleted'=>'0'
            ];
            if($tenantAgent!=null){
                $newRow['tenant_agent']=$tenantAgent['id'];
            }
            $this->company = $this->vms->insertRow('company',$newRow ,true);
        } else {
            $this->company = $company;
        }
        return $this->company;
    }

    function ensureSponsorFromData($row,$company){

        $tenantAgent = $this->isTenantAgent($row)?$this->getTenantAgent($row):null;


        $nameParts = explode(' ',str_replace("  "," ",trim($row['ASIC Holder Name'])));
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
                                  and asic_no = '".$row['ASIC Holder No']."'
                                  and tenant=".$this->tenant['id'].""
                                  .( $tenantAgent!=null ? " and tenant_agent =".$tenantAgent['id']:"")
                                  );

        if($sponsor==null){
            $newRow = [
                'first_name'=>$firstName,
                'middle_name'=>$middleName,
                'last_name'=>$lastName,
                'email'=>$firstName.".".$lastName."@unknowncompany",
                'contact_number'=>'0000000000',
                'company'=>$company['id'],
                'role'=>10,
                'visitor_type'=>$this->visitorType['id'],
                'visitor_workstation'=>$this->getWorkstation($row)['id'],
                'profile_type'=>'ASIC',
                'tenant'=>$this->tenant['id'],
                'is_deleted'=>'0'
            ];
            if($tenantAgent!=null){
                $newRow['tenant_agent']=$tenantAgent['id'];
            }
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


    function ensureVisitorFromData($row,$company){

        $tenantAgent = $this->isTenantAgent($row)?$this->getTenantAgent($row):null;

        $addressParts = AddressHelper::parse($row['Residential Address']);

        $nameParts = $this->parseName($row['Given Names'].' '.$row['Surname']);

        $visitor =  $this->vms->getFirstRow("select *
                                  from visitor
                                  where first_name = ".$this->vms->db->quoteValue($row['Given Names'])."
                                  and last_name = ".$this->vms->db->quoteValue($row['Surname'])."
                                  and date_of_birth = '".$this->parseDateForSql($row['DOB'])."'
                                  and tenant=".$this->tenant['id'].""
                                  .( $tenantAgent!=null ? " and tenant_agent =".$tenantAgent['id']:"")
                                  );

        if($visitor==null){

            $identificationType= $row["ID Type"]=='Drivers License'?'DRIVERS_LICENSE':
                ($row["ID Type"]=="Passport"?'PASSPORT':null);

            $newRow = [
                'email'                         =>$nameParts['first_name'].".".$nameParts['last_name']."@unknowncompany",
                'contact_number'                =>$this->valueIfEmpty($this->valueIfEmpty($row['Visitor Contact Mobile'],$row['Visitor Contact Phone']),'0000000000'),
                'date_of_birth'                 =>$this->parseDateForSql($row['DOB']),
                'company'                       =>$company['id'],
                'role'                          =>'10',
                'visitor_type'                  =>$this->visitorType['id'],
                'visitor_workstation'           =>$this->getWorkstation($row)['id'],
                'profile_type'                  =>$row['ASIC Submitted']=='FALSE'?'VIC':'ASIC',
                'identification_type'           =>$identificationType,
                'identification_country_issued' =>'13',
                'identification_document_no'    =>$row['ID Number'],
                'contact_unit'                  =>$addressParts['Unit'],
                'contact_street_no'             =>$addressParts['StreetNumber'],
                'contact_street_name'           =>$addressParts['StreetName'],
                'contact_street_type'           =>$addressParts['StreetType'],
                'contact_suburb'                =>$addressParts['Suburb'],
                'contact_state'                 =>$addressParts['State'],
                'contact_country'               =>$this->vms->getFirstRow("select * from country where code = 'AU'")['id'],
                'contact_postcode'              =>$addressParts['PostCode'],
                'asic_no'                       =>null,
                'asic_expiry'                   =>null,
                'date_created'                  =>date('Y-m-d'),
                'tenant'=>$this->tenant['id']
            ];
            if($tenantAgent!=null){
                $newRow['tenant_agent']=$tenantAgent['id'];
            }
            $newRow = array_merge($newRow,$nameParts);
            return $this->vms->insertRow('visitor',$newRow,true);
        }
        return $visitor;
    }

    function ensureCardGeneratedFromData($row){

        $id = $this->vms->getFirstRow('select max(id)+1 as id from card_generated')['id'].'';
        $num = $this->ibcode.substr('0000000'.$id,-6);
        $startDate =$this->parseDateForSql($row['VIC Issue Date']);
        $endDate = $this->parseDateForSql($row['VIC Expiry Date']);
        $returnedDate = $this->parseDateForSql($row['VIC Return Date']);
        $newRow = [
            'card_number'=> $num,
            'date_printed'=>$startDate,
            'date_expiration'=>$endDate,
            'date_cancelled'=>null,
            'date_returned'=>$returnedDate
        ];
        return $this->vms->insertRow('card_generated',$newRow,true);
    }

    public function ensureVisitFromData($row,$cardGenerated,$visitor,$sponsor)
    {
        $tenantAgent = $this->isTenantAgent($row)?$this->getTenantAgent($row):null;


        $newRow = [
            'visitor'           => $visitor['id'],
            'card_type'         =>3,
            'card'              =>$cardGenerated['id'],
            'visitor_type'      =>$this->visitorType['id'],
            'visitor_status'    =>1,
            'host'              =>$sponsor['id'],
            'created_by'        =>$this->createdBy,
            'date_in'           =>$this->parseDateForSql($row['VIC Issue Date']),
            'date_out'          =>$this->parseDateForSql($row['VIC Expiry Date']),
            'time_in'           =>'00:00:00',
            'time_out'          =>'23:59:59',
            'date_check_in'     =>$this->parseDateForSql($row['VIC Issue Date']),
            'date_check_out'    =>$this->parseDateForSql($row['VIC Expiry Date']),
            'time_check_in'     =>'00:00:00',
            'time_check_out'    =>'23:59:59',
            'visit_status'      =>3,
            'workstation'       =>$this->getWorkstation($row)['id'],
            'is_deleted'        =>0,
            'finish_date'       =>$this->parseDateForSql($row['VIC Expiry Date']),
            'finish_time'       =>'23:59:59',
            'card_returned_date'=>$this->parseDateForSql($row['VIC Expiry Date']),
            'company'           =>$this->company['id'],
            'visit_reason'      =>$row['Reason for Issue'],
            'tenant'=>$this->tenant['id']

        ];

        if($tenantAgent!=null){
            $newRow['tenant_agent']=$tenantAgent['id'];
        }

        return $this->vms->insertRow('visit',$newRow,true);
    }

    public function parseDateForSql($strDate){
        if($strDate==null || trim($strDate) == ''){
            return null;
        }
        return DateTime::createFromFormat('d/m/Y',$strDate)->format('Y-m-d');
    }

    public function valueIfEmpty($val,$emptyVal){
        if($val==null || trim($val,' ')==''){
            return $emptyVal;
        }
        return $val;
    }

    public function parseName($name){
        $nameParts = explode(' ',$name);
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
        return [
            'first_name' => $firstName,
            'middle_name' => $middleName,
            'last_name' => $lastName
        ];
    }

}