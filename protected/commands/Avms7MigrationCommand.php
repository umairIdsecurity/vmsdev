<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 29/10/2015
 * Time: 9:56 PM
 */
class Avms7MigrationCommand extends CConsoleCommand
{

    private $unmappedRefs = [
        ['table_name'=>'company', 'column_name'=>'tenant'               ,'referenced_table_name'=>'company'         ,'referenced_column_name'=>'id'],
        ['table_name'=>'company', 'column_name'=>'tenant_agent'         ,'referenced_table_name'=>'company'         ,'referenced_column_name'=>'id'],

        ['table_name'=>'user'   , 'column_name'=>'tenant'               ,'referenced_table_name'=>'company'         ,'referenced_column_name'=>'id'],
        ['table_name'=>'user'   , 'column_name'=>'tenant_agent'         ,'referenced_table_name'=>'company'         ,'referenced_column_name'=>'id'],

        ['table_name'=>'visitor', 'column_name'=>'tenant'               ,'referenced_table_name'=>'company'         ,'referenced_column_name'=>'id'],
        ['table_name'=>'visitor', 'column_name'=>'tenant_agent'         ,'referenced_table_name'=>'company'         ,'referenced_column_name'=>'id'],
        ['table_name'=>'visitor', 'column_name'=>'visitor_type'         ,'referenced_table_name'=>'visitor_type'    ,'referenced_column_name'=>'id'],

        ['table_name'=>'visit'  , 'column_name'=>'tenant'               ,'referenced_table_name'=>'company'         ,'referenced_column_name'=>'id'],
        ['table_name'=>'visit'  , 'column_name'=>'tenant_agent'         ,'referenced_table_name'=>'company'         ,'referenced_column_name'=>'id'],

        ['table_name'=>'visit'  , 'column_name'=>'workstation'          ,'referenced_table_name'=>'workstation'     ,'referenced_column_name'=>'id'],
        ['table_name'=>'visit'  , 'column_name'=>'card'                 ,'referenced_table_name'=>'card_generated'  ,'referenced_column_name'=>'id'],
        ['table_name'=>'visit'  , 'column_name'=>'host'                 ,'referenced_table_name'=>'visitor'            ,'referenced_column_name'=>'id'],
        ['table_name'=>'visit'  , 'column_name'=>'created_by'           ,'referenced_table_name'=>'user'            ,'referenced_column_name'=>'id'],
        ['table_name'=>'visit'  , 'column_name'=>'closed_by'            ,'referenced_table_name'=>'user'            ,'referenced_column_name'=>'id'],
        ['table_name'=>'visit'  , 'column_name'=>'visitor'              ,'referenced_table_name'=>'visitor'         ,'referenced_column_name'=>'id'],
        ['table_name'=>'visit'  , 'column_name'=>'visitor_type'         ,'referenced_table_name'=>'visitor_type'    ,'referenced_column_name'=>'id'],
        ['table_name'=>'visit'  , 'column_name'=>'reason'               ,'referenced_table_name'=>'visit_reason'    ,'referenced_column_name'=>'id'],



        ['table_name'=>'card_generated' , 'column_name'=>'visitor_id'   ,'referenced_table_name'=>'visitor','referenced_column_name'=>'id'],
        ['table_name'=>'card_generated' , 'column_name'=>'tenant'       ,'referenced_table_name'=>'company','referenced_column_name'=>'id'],
        ['table_name'=>'card_generated' , 'column_name'=>'tenant_agent' ,'referenced_table_name'=>'company','referenced_column_name'=>'id'],

        ['table_name'=>'visitor_type'   , 'column_name'=>'tenant'       ,'referenced_table_name'=>'company','referenced_column_name'=>'id'],
        ['table_name'=>'visitor_type'   , 'column_name'=>'tenant_agent' ,'referenced_table_name'=>'company','referenced_column_name'=>'id'],

        ['table_name'=>'visit_reason'  , 'column_name'=>'tenant'        ,'referenced_table_name'=>'company','referenced_column_name'=>'id'],
        ['table_name'=>'visit_reason'  , 'column_name'=>'tenant_agent'  ,'referenced_table_name'=>'company','referenced_column_name'=>'id'],


    ];



    public function actionTransfer($airportCode){
        $avms7Db = new CDbConnection("mysql:host=localhost;dbname=avms7;",'user_vms','HFz7c9dHrmPqwNGr');
        $avms7 = new DataHelper($avms7Db);
        $vms = new DataHelper(Yii::app()->db);

        $tenant = $vms->getFirstRow("SELECT * FROM company WHERE code = '$airportCode' and company_type = 1 and is_deleted=0 ");
        if($tenant==null){
            throw new CException("Can't find tenant with code '$airportCode'.");
        }

        $data = $this->extractTenant($airportCode,$avms7);

        $referenceData = $this->getReferenceData($airportCode,$avms7);

        $transaction = Yii::app()->db->beginTransaction();
        try
        {
            $idMappings = [];
            $idMappings['user'][1] = 1;


            $this->setTenantAgents($data,$referenceData);
            $this->setUserCompanies($data);
            $this->setVisitorCompanies($data,$referenceData,$avms7);
            $this->setVisitorTypes($data,$airportCode,$idMappings);
            $this->setVisitReasons($data,$airportCode);
            $this->importImages($data);
            $this->mapExistingData($tenant,$data,$idMappings,$vms,$referenceData);
            $this->filterUserRecords($data,$idMappings,$vms,$tenant);
            $this->filterVisitorRecords($data);

            unset($data['tenant']);
            unset($data['tenant_agent']);

            $foreignKeys = $this->getForeignKeys();
            $tables = ['company','visitor_type','visit_reason','user', 'visitor','card_generated', 'visit','reset_history'];
            foreach ($tables as $table) {
                $rows = $data[$table];
                $this->importTable($table, $rows, $foreignKeys, ['company', 'visitor', 'visit','workstation','card_generated','user','visitor_type','visit_reason'], $idMappings,$vms);
            }

            $transaction->commit();
            //$transaction->rollback();

        } catch (CException $e){
            $transaction->rollback();
            echo "\r\n".$e->getMessage();
        }

    }

    /*
     * Remove any visitor records that have not had a visit in the last 12 months or havent been a
     * host in the last 12 months
     */
    public function filterVisitorRecords(&$data){

        $filteredVisitors = [];
        foreach($data['visitor'] as $visitor){
            if($this->findVisitWithVisitorOrHost($data,$visitor['id'])!=null){
                $filteredVisitors[]=$visitor;
            }
        }
        $data['visitor'] = $filteredVisitors;
    }

    /*
     *
     */
    public function filterUserRecords(&$data,&$idMappings,$vms,$tenant){

        $toKeep = [];
        for($i=0;$i<sizeof($data['user']);$i++){
            $user = &$data['user'][$i];

            // get local tenant agent
            $localTenantAgent = null;
            if(isset($user['tenant_agent']) && $user['tenant_agent']>'' && isset($idMappings['company'][$user['tenant_agent']])){
                $localTenantAgent = $idMappings['company'][$user['tenant_agent']];
            }


            // match the agent
            $vmsUser = $vms->getFirstRow("SELECT * FROM ".Yii::app()->db->quoteTableName('user')."
                                            where tenant = ".$tenant['id']."
                                            and is_deleted=0
                                            and (email like '".str_replace(".au","%",$user['email'])."'
                                                or (first_name=". Yii::app()->db->quoteValue($user['first_name'])." and last_name=".Yii::app()->db->quoteValue($user['last_name'])."))".
                ($localTenantAgent!=null?' and tenant_agent='.$localTenantAgent:'')
            );

            // if we don't have a first name or last name
            if($vmsUser == null && !($user['first_name']> ''  && $user['last_name']>'')) {

                // if we don't get a match then used someone at the company
                if ($user['company'] > '') {
                    $vmsUser = $vms->getFirstRow("SELECT u.* FROM " . Yii::app()->db->quoteTableName('user') . " u join company c on u.company = c.id
                                            where u.tenant = " . $tenant['id'] . "
                                            and u.is_deleted=0
                                            and c.name = " . Yii::app()->db->quoteValue($user['company']) . " " .
                        ($localTenantAgent!=null?'and u.tenant_agent='.$localTenantAgent:'')
                    );
                }

                // if we don't get a match then use someone at the same domain
                if ($vmsUser == null) {
                    $vmsUser = $vms->getFirstRow("SELECT * FROM " . Yii::app()->db->quoteTableName('user') . "
                                            where tenant = " . $tenant['id'] . "
                                            and is_deleted=0
                                            and email like '%" . str_replace(".au","%",substr($user['email'], strpos($user['email'], '@'))) . "' " .
                        ($localTenantAgent!=null?'and tenant_agent='.$localTenantAgent:'')
                    );
                }
            }

            if($vmsUser==null){
                if(!($user['first_name']>'')){$user['first_name'] = 'Unknown';}
                if(!($user['last_name']>'')){$user['last_name'] = 'Unknown';}

                $toKeep[] = $user;
            } else {
                $idMappings['user'][$user['id']] = $vmsUser['id'];
            }
        }
        $data['user']=$toKeep;
    }

    public function setCardStatuses(&$data){

    }

    function setVisitorTypes(&$data,$airportCode,$idMappings)
    {
        $lookup = [];
        $id = 1;
        $data['visitor_type']=[];
        for($i=0;$i<sizeof($data['visitor']);$i++){

            $visitor = $data['visitor'][$i];
            $key = $airportCode.".".$visitor['tenant_agent'];

            if(!isset($lookup[$key])) {

                $row = ['id'=>$id, 'name' => 'Other: Data Import', 'created_by' => 1, 'tenant' => $airportCode,'tenant_agent'=>$visitor['tenant_agent']];

                //$this->insertRow('visitor_type', $row, true);
                $lookup[$key] = $row['id'];
                $data['visitor'][$i]['visitor_type'] = $row['id'];
                $data['visitor_type'][] = $row;
                $row = ['id'=>$id, 'name' => 'Other: Data Import', 'created_by' => 1, 'tenant' => $airportCode,'tenant_agent'=>$visitor['tenant_agent']];

            } else {
                $data['visitor'][$i]['visitor_type'] = $lookup[$key];
            }
        }

        for($i=0;$i<sizeof($data['visit']);$i++){

            $visitor = $data['visit'][$i];
            if(!isset($visitor['tenant_agent'])){
                $key = $airportCode . ".";
            } else {
                $key = $airportCode . "." . $visitor['tenant_agent'];
            }

            if(!isset($lookup[$key])) {

                $row = ['id'=>$id, 'name' => 'Other: Data Import', 'created_by' => 1, 'tenant' => $airportCode,'tenant_agent'=>$visitor['tenant_agent']];
                //$this->insertRow('visitor_type', $row, true);

                $lookup[$key] = $row['id'];
                $data['visit'][$i]['visitor_type'] = $row['id'];
                $data['visitor_type'][] = $row;
                $id++;

            } else {
                $data['visit'][$i]['visitor_type'] = $lookup[$key];
            }
        }

    }
    function setVisitReasons(&$data,$airportCode){
        $lookup = [];
        $id = 1;
        $data['visit_reason']=[];
        for($i=0;$i<sizeof($data['visit']);$i++){

            $visitor = $data['visit'][$i];
            if(isset($visitor['tenant_agent'])) {
                $key = $airportCode . "." . $visitor['tenant_agent'];
            } else {
                $key = $airportCode . "." ;
            }

            if(!isset($lookup[$key])) {

                $row = ['id' => $id, 'reason' => 'Other: Data Import', 'created_by' => 1, 'tenant' => $airportCode,'tenant_agent'=>$visitor['tenant_agent'],'module'=>'AVMS'];
                //$this->insertRow('visit_reason', $row, true);
                $lookup[$key] = $row['id'];
                $data['visit'][$i]['reason'] = $row['id'];
                $data['visit_reason'][] = $row;
                $id++;

            } else {
                $data['visit'][$i]['reason'] = $lookup[$key];
            }
        }
    }
    function setUserCompanies(&$data)
    {
        //user companies should be a tenant or a tenant agent
        $visitorCompany = [];
        for ($i = 0; $i < sizeof($data['user']); $i++) {
            $company = null;
            if (isset($data['user'][$i]['tenant_agent'])) {
                $data['user'][$i]['company'] = $data['user'][$i]['tenant_agent'];
            } else if (isset($data['user'][$i]['tenant'])) {
                $data['user'][$i]['company'] = $data['user'][$i]['tenant'];
            } else {
                throw new CException("Cant assign company for user ".$data['user'][$i]['email']);
            }
        }
    }
    function setVisitorCompanies(&$data,$referenceData,$avms7){

        $visitorCompany = [];
        for($i=0;$i<sizeof($data['visitor']);$i++){
            $company = null;
            if(!isset($referenceData['visitor_company'][$data['visitor'][$i]['id']])){
                $company = $this->companyFromVisitor($data['visitor'][$i]);
            } else {
                $company = $referenceData['visitor_company'][$data['visitor'][$i]['id']];
            }

            $existingCompany = $this->findCompanyFromData($data,$company);
            if($existingCompany!=null){
                if(!isset($existingCompany['tenant_agent']) || $existingCompany['tenant_agent']==$data['visitor'][$i]['tenant_agent'])
                {
                    $data['visitor'][$i]['company'] = $existingCompany['id'];
                } else {
                    $id = $this->getLastCompanyIdFromData($data)+1;
                    $data['visitor'][$i]['company'] = $id;
                    $existingCompany['tenant_agent'] = $data['visitor'][$i]['tenant_agent'];
                    $data['company'][] = $existingCompany;
                }
            } else {
                $id = $this->getLastCompanyIdFromData($data)+1;
                $data['visitor'][$i]['company'] = $id;
                $data['company'][] = $this->companyFromReferenceData($company,$id,$data['visitor'][$i]);
            }
            $visitorCompany[$data['visitor'][$i]['id']] = $data['visitor'][$i]['company'];
        }

        for($i=0;$i<sizeof($data['visit']);$i++){
            $visitorId = $data['visit'][$i]['visitor'];
            if(isset($visitorCompany[$visitorId])) {
                $data['visit'][$i]['company'] = $visitorCompany[$visitorId];
            }

        }
    }
    function importImages(&$data){

        for($i=0;$i<sizeof($data['visitor']);$i++){
            //foreach($data['visitor'] as $row){
            $row = $data['visitor'][$i];
            if(isset($row['photo']) && $row['photo'] > ''){
                $url = "https://avms7.idsecurity.com.au/store/files_thumb/".$row['photo'];
                echo "\r\n Downloading photo $url";
                try {
                    $client = new EHttpClient($url, array(
                        'maxredirects' => 0,
                        'timeout' => 30));

                    $response = $client->request();
                    if ($response->isSuccessful()) {
                        $image = $response->getRawBody();

                        try {
                            $photo = new PhotoImport;
                            $photo->filename = $row['photo'];
                            $photo->db_image = $image;
                            $photo->save();
                            $data['visitor'][$i]['photo'] = $photo->id;

                        } catch (CException $e) {
                            echo "\r\n" . $e->getMessage();
                        }

                    } else {
                        $data['visitor'][$i]['photo'] = null;
                    }
                } catch (CException $e){
                    echo "\r\n".$e->getMessage();
                    $data['visitor'][$i]['photo'] = null;
                }


            } else {
                $data['visitor'][$i]['photo'] = null;
            }
        }

    }

    function allowBrokenReference($tableName,$columnName){
        return false;//$tableName=="visit" && $columnName="host";
    }

    function companyFromVisitor($visitor){
        return [
            'companyId'         => null,
            'contact_person'    => $visitor['first_name'].' '.$visitor['last_name'],
            'email_address'     => $visitor['email'],
            'code'              => $visitor['tenant'],
            'phone_number'      => $visitor['contact_number'],
            'company_name'      => $visitor['company']>''?$visitor['company']:'Unknown Company '.$visitor['id'],
            'tenant'            => $visitor['tenant'],
            'tenant_agent'      => $visitor['tenant_agent']
        ];
    }
    function companyFromReferenceData($company,$id,$visitor){

        return
            [
                'id'                => $id,
                'name'              => $company['company_name'],
                'trading_name'      => $company['company_name'],
                'code'              => $company['code'],
                'contact'           => $company['contact_person'],
                'email_address'     => $company['email_address'],
                'mobile_number'   => $company['phone_number'],
                'created_by_user'   => 1,
                'tenant'            => $visitor['tenant'],
                'tenant_agent'      => $visitor['tenant_agent'],
                'company_type'      => 3,
                'is_deleted'        => 0
            ];
    }


    function usersToVisitors($data){

        // find all hosts that are not visitors but are users and make them visitors
        foreach($data['visit'] as $visit){
            if($this->findVisitor($data,$visit['host'])==null){
                $user = $this->findUser($data,$visit['host']);
                if($user!=null){
                    $this->addUserAsVisitor($data,$user);
                }
            }
        }

    }
    function addUserAsVisitor($data,$user){
        $data['visitor']+=[
            'id' => $user['id'],
            'first'
        ];
    }
    function findVisitor($data,$id){
        foreach($data['visitor'] as $visitor){
            if($visitor['id']==$id){
                return $visitor;
            }
        }
        return null;
    }
    function findUser($data,$id){
        foreach($data['user'] as $user){
            if($user['id']==$id){
                return $user;
            }
        }
        return null;
    }

    function findVisitWithVisitorOrHost($data,$id){
        foreach($data['visit'] as $visit){
            if($visit['visitor']==$id || $visit['host']==$id  ){
                return $visit;
            }
        }
        return null;
    }

    function getLastCompanyIdFromData($data){
        $id = 0;
        foreach($data['company'] as $existingCompany){
            if(intval($existingCompany['id']) > $id){
                $id = intval($existingCompany['id']);
            }
        }
        return $id;
    }

    function findCompanyFromData($data,$company){
        foreach($data['company'] as $existingCompany){

            if($company['companyId']>0){
                if($existingCompany['id'] == $company['companyId']){
                    return $existingCompany;
                }
            } else {

                // match on company name or email address
                if(($existingCompany['name']==$company['company_name'] && $company['company_name'] > '')
                    or ($existingCompany['email_address']==$company['email_address'] && $company['email_address'] > ''))
                {
                    return $existingCompany;
                }
            }
        }
        return null;
    }

    function setTenantAgents(&$data, $refernceData){

        foreach(['visit','card_generated','user','company'] as $tableName) {
            for ($i = 0; $i < sizeof($data[$tableName]); $i++) {
                $operatorId = $data[$tableName][$i]['operator'];
                if($operatorId!=null &&  $operatorId > '')
                    if(!isset($refernceData['operator_owners'][$operatorId])){
                        echo "\r\n cant find operator ".$operatorId;
                    } else {
                        if ($refernceData['operator_owners'][$operatorId]['agentLevel'] == 6) {
                            $data[$tableName][$i]['tenant_agent'] = $refernceData['operator_owners'][$operatorId]['agentId'];
                        } else {
                            $data[$tableName][$i]['tenant_agent'] = null;
                        }
                    }
                unset($data[$tableName][$i]['operator']);
            }
        }
    }


    function mapExistingData($tenant,$data,&$idMappings,$vms,$refernceData)
    {
        $idMappings['company'] = [];
        $idMappings['company'][$tenant['code']] = $tenant['id'];
        $workstation = $vms->getFirstRow("SELECT * FROM workstation WHERE  tenant=".$tenant['id']." ORDER BY id ASC");
        $idMappings['workstation'][$tenant['code']] = $workstation['id'];


        foreach($data['tenant_agent'] as $agent){

            // match the agent
            $vmsAgent = $vms->getFirstRow("SELECT * FROM company
                                            where tenant = ".$tenant['id']."
                                            and company_type=2
                                            and is_deleted=0
                                            and (email_address='".$agent['email_address']."'
                                                or name='".$agent['name']."'
                                                or instr(name,'".$agent['name']."') > 0
                                                or instr('".$agent['name']."',name) > 0
                                                or substr(email_address,instr('@',email_address))='".substr($agent['email_address'],strpos($agent['email_address'],'@'))."'
                                                )"
            );
            if($vmsAgent==null){
                echo "\r\nWARNING: Cant find agent ".$agent['email_address']." : ".$agent['name'];
                continue;
                //$this->createTenantAgent($agent,$tenant,$vms);
                //$this->createWorkstation($agent,$tenant,$vms);
            } else {
                $idMappings['company'][$agent['tenant_agent']] = $vmsAgent['id'];
            }

            // map the workstation

            $workstation = $vms->getFirstRow("SELECT * FROM workstation WHERE  tenant_agent=".$vmsAgent['id']." ORDER BY id ASC");
            if($workstation==null) {
                echo "\r\nWARNING: Cant find workstation for agent ".$agent['email_address']." : ".$agent['name'];
                continue;
            };


            $idMappings['workstation'][$agent['tenant_agent']] = $workstation['id'];

        }

    }


    function importTable($tableName,&$rows,$foreignKeys,$targetTables,&$idMappings,$vms){

        $cols = [];

        $isAutoIncrement = sizeof($rows) > 0 && Yii::app()->db->schema->tables[$tableName]->columns['id']->autoIncrement;

        foreach ($rows as $rowKey => $row) {
            $row = (array)$row;

            // remember the old id for mapping later
            $oldId = null;
            if (isset($row['id'])) {
                $oldId = $row['id'];
                if ($isAutoIncrement) {
                    unset($row['id']);
                }
            }

            // massage the data in out of the ordinary circumstances
            $this->beforeInsertRow($tableName,$row,$oldId,$vms);

            // populate referencing columns
            if($this->setReferencingIds($tableName, $row, $foreignKeys, $idMappings, $targetTables)) {

                $this->insertRow($tableName,$row,$isAutoIncrement);

                $this->afterInsertRow($tableName, $row, $idMappings, $oldId);

                if (isset($row['id'])) {
                    $idMappings[$tableName][$oldId] = $row['id'];
                    echo "\r\n" . $tableName . " " . $oldId . "=" . $row['id'];
                }
                echo "\r\n";

            } else{
               echo "\r\nWARNING: Skipped row $tableName :".implode(",",$row);
            }
        }
        echo "\r\n\r\n";
    }
    function beforeInsertRow($tableName, &$row,$oldId,$vms){


        foreach($row as $name=>$value){

            if($value=="0000-00-00" && $vms->db->driverName=="mssql"){
                $row[$name] = $vms->isNullable($tableName,$name)?null:"1753-01-01";
            } else if($value=="1753-01-01" && $vms->db->driverName=="mysql"){
                $row[$name] = $vms->isNullable($tableName,$name)?null:"0000-00-00";
            }

            if(($name=='first_name' || $name=='last_name') && ($value==null  || trim($value)=='')){
                $row[$name] = 'Unknown';
            }
        }


        if($tableName=='visit'){

            if(isset($row['tenant_agent']) && $row['tenant_agent'] > '')
            {
                $row['workstation']=$row['tenant_agent'];
            } else {
                $row['workstation']=$row['tenant'];
            }


        } else if($tableName=='visitor'){
            if(!isset($row['contact_number']) || $row['contact_number']==''){
                $row['contact_number'] = '0000000000';
            }
            if(isset($row['contact_country']) && $row['contact_country']>'') {
                $country = $vms->getFirstRow("SELECT * FROM country WHERE code='" . $row['contact_country'] . "'");
                if ($country) {
                    $row['contact_country'] = $country['id'];
                } else {
                    $row['contact_country'] = '13'; // australia
                }
            }
            if(isset($row['identification_country_issued']) && $row['identification_country_issued']>'') {
                $country = $vms->getFirstRow("SELECT * FROM country WHERE code='".$row['identification_country_issued']."'");
                if($country) {
                    $row['identification_country_issued'] = $country['id'];
                } else {
                    $row['identification_country_issued'] = '13'; // australia
                }
            }
        }
    }
    function afterInsertRow($tableName,&$row, &$idMappings,$oldId){

        if($tableName=='company'){
            $idMappings['company'][$row['name']] = $row['id'];
        }

        $sql=[];
        foreach($sql as $statement){
            echo "\r\n".$statement."\r\n";
            Yii::app()->db->createCommand($statement)->execute();
        }

    }
    function setReferencingIds($tableName, &$row, $foreignKeys, &$idMappings,$targetTables){

        // go through each column
        foreach($row as $columnName=>$value){

            // if there is a foriegn key reference
            if($value != null && $value!='0' && isset($foreignKeys[$tableName][$columnName])){

                // get the reference
                $ref = $foreignKeys[$tableName][$columnName];

                // check that we need to update
                if(in_array($ref['referenced_table_name'],$targetTables)) {


                    // check that we've already got a value for the reference
                    if (isset($idMappings[$ref['referenced_table_name']][$value])) {

                        // set the reference value on the row
                        $row[$columnName] = $idMappings[$ref['referenced_table_name']][$value];
                        echo $tableName . "." . $columnName . " " . $value . "=" . $row[$columnName] . "\r\n";

                    }else if($this->allowBrokenReference($tableName,$columnName)){
                        $row[$columnName] = null;
                        echo "\r\nWARNING: New id value for " . $tableName . "." . $columnName . "=" . $value . " does not exist. Value has been replaced with a null value.\r\n";
                    } else {

                        echo "\r\nWARNING: New id value for " . $tableName . "." . $columnName . "=" . $value . " does not exist. Perhaps tables are added in wrong order?\r\n";
                        return false;
                    }
                }
            }
        }
        return true;

    }







    public function createWorkstation($agent,$tenant,$vms){
        $workstation = [

        ];
    }
    public function createTenantAgent($agent,$tenant,$vms){

        $company = $agent;
        $company['tenant'] = $tenant['id'];
        $id = $company['id'];
        $this->insertRow('company',$company,true);
        $idMappings['company'][$id] = $company['id'];
        $tenantAgent = [
                            'id'=>$agent['id'],
                            'tenant_id'=>$tenant['id'],
                            'for_module'=>'AVMS',
                            'is_deleted'=>0,
                            'created_by'=>1
                        ];

        $this->insertRow('tenant_agent',$tenantAgent,false);

    }
    public function extractTenant($airportCode,$avms7)
    {
        $queries = $this->getQueries($airportCode);
        $data = [];
        foreach($queries as $name=>$sql){
            echo "\r\n".$sql;
            $data[$name] = $avms7->getRows($sql);
        }
        return $data;
    }


    public function getReferenceData($airportCode,$avms7){
        $queries = [
          'operator_owners' => "select o.id as operatorId, o.level as operatorLevel,o.company as operatorCompany, a.id as agentId, a.level as agentLevel, a.company as agentCompany, a.ibcode as code
                                from users o
                                    left join users a
                                        on a.IBcode = o.ibcode
                                        and a.level in (3,6) and o.level in (6,7,9,3,2,8)
                                        and (
                                                (substr(o.emailAddress, instr(o.emailAddress,'@')+1) = substr(a.emailAddress, instr(a.emailAddress,'@')+1))
                                                or (o.company = a.company and o.company > '')
                                                or o.id = a.id
                                            )
                                where o.ibcode = '$airportCode'
                              ",
            "visitor_company"=> "select oc.userid as visitor_id, min(c.id) as companyId, max(n.CompanyName) as company_name, max(n.ContactEmail) as email_address, max(n.ContactPerson) as contact_person, max(n.ContactPhone) phone_number,oc.airportcode as 'code'
                                from oc_set oc
                                    join operational_need n on oc.oid = n.id
                                    left join users c
                                            on c.level = 4
                                            and c.id = n.companyId
                                where oc.airportCode = '$airportCode'
                                group by oc.userid,n.CompanyName
                                ",


        ];
        $data = [];

        $data['operator_owners']=[];
        $operator_owners = $avms7->getRows($queries['operator_owners']);
        foreach($operator_owners as $operator){
            $data['operator_owners'][$operator['operatorId']] = $operator;
        }

        $data['visitor_company']=[];
        $visitors = $avms7->getRows($queries['visitor_company']);
        foreach($visitors as $visitor){
            $data['visitor_company'][$visitor['visitor_id']] = $visitor;
        }

        return $data;
    }

    public function getCleanUpQueries($airportCode){
        return [

        ];
    }

    public function getQueries($airportCode)
    {
        return [
            'tenant' => "
                select *
                from users
                where level = 3
                and ibcode = '$airportCode'
                order by id asc
                limit 1
            ",
            'tenant_agent' => "
                select distinct c.ID as id,
                      c.company as name,
                      c.company as trading_name,
                      (CONCAT_WS(' ',c.FirstName, c.LastName))  as contact,
                      (CONCAT_WS(' ',c.Unit,c.StreetNo,c.Street,c.StreetType,c.Suburb,c.State,c.PostCode)) as billing_address,
                      (c.EmailAddress) as email_address,
                      (c.Telephone) as office_number,
                      (c.Mobile) as mobile_number,
                      1 as created_by_user,
                      null as created_by_visitor,
                      oc.AirportCode as tenant,
                      IFNULL(agent.AgentId,agent_set.AgentId) as tenant_agent,
                      0 as is_deleted,
                      2 as company_type
                from oc_set oc
                    join agent_set on agent_set.ocid = oc.id and oc.AirportCode = '$airportCode'
                    left join agent on agent.UserId = agent_set.agentid
                    left join users c on c.id = ifnull(agent.agentid,agent_set.agentid)
            ",
            "company" =>"
                select c.Id as id,
                     (c.company) as name,
                     (c.company) as trading_name,
                     (CONCAT_WS(' ',c.FirstName, c.LastName))  as contact,
                     (CONCAT_WS(' ',c.Unit,c.StreetNo,c.Street,c.StreetType,c.Suburb,c.State,c.PostCode)) as billing_address,
                     (c.EmailAddress) as email_address,
                     (c.Telephone) as office_number,
                     (c.Mobile) as mobile_number,
                     1 as created_by_user,
                     null as created_by_visitor,
                     o.ibcode as tenant,
                     o.id as operator,
                     0 as is_deleted,
                     3 as company_type,
                     o.ibcode as code
                from users c
                    join users o
                        on o.id = c.ownerid
                        and o.IBCode = '$airportCode'
                where c.level = 4
                and c.company > ''
            ",
            "user" => "
                select u.ID as id,
                    u.FirstName as first_name,
                    u.LastName as last_name,
                    u.EmailAddress as email,
                    IFNULL(NULLIF(IFNULL(IFNULL(u.Mobile,u.Telephone),u.Fax),''),'000000000') as contact_number,
                    u.DateOfBirth as date_of_birth,
                    u.Company as company,
                    u.Password as password,
                    case
                      when level = 3 then 1
                      when level = 2 then 8
                      when level = 8 then 6
                      when level = 6 then 13
                      when level = 7 then 14
                      when level = 9 then 13
                    end as role,
                    1 as user_type,
                    1 as user_status,
                    1 as created_by,
                    u.ibcode as tenant,
                    case
                      when level in (3,6,2,8) then null
                      else u.ID
                    end as operator,
                    null as photo,
                    null as timezone_id,
                    1 as allowed_module,
                    a.asic_number as asic_no,
                    a.asic_expiry as asic_expiry
                from users u
                  left join asic_data a on u.ID = a.UserId
                where u.ibcode = '$airportCode'
                and u.level not in (1,4,5,10)
            ",
            'visitor' =>"
                select distinct v.ID as id,
                    IFNULL(v.FirstName,'Unknown') as first_name,
                    v.MiddleName as middle_name,
                    IFNULL(v.LastName,'Unknown') as last_name,
                    v.EmailAddress as email,
                    IFNULL(v.Mobile,v.Telephone) as contact_number,
                    v.DateOfBirth as date_of_birth,
                    v.Company as company,
                    v.Password as password,
                    null as photo,
                    v.Unit as contact_unit,
                    v.StreetNo as contact_street_no,
                    v.Street as contact_street_name,
                    v.StreetType as contact_street_type,
                    v.Suburb as contact_suburb,
                    v.State as contact_state,
                    v.PostCode as contact_postcode,
                    v.Country as contact_country,
                    case
                      when NULLIF(ad.asic_number,'') IS NOT NULL  then 'ASIC'
                      else 'VIC'
                    end as profile_type,
                    ad.asic_number as asic_no,
                    ad.asic_expiry as asic_expiry,
                    idA.DocumentType as identification_type,
                    idA.CountryIssue as identification_country_issued,
                    idA.Number as identification_document_no,
                    idA.Expiry as identification_document_expiry,
                    idB.DocumentType as identification_alternate_document_name1,
                    idB.Number as identification_alternate_document_no1,
                    idB.Expiry as identification_alternate_document_expiry1,
                    idC.DocumentType as identification_alternate_document_name2,
                    idC.Number as identification_alternate_document_no2,
                    idC.Expiry as identification_alternate_document_expiry2,
                    oc.AirportCode as tenant,
                    IFNULL(agent.agentid,agent_set.agentid) as tenant_agent

                from oc_set oc
                    join log_visit lv on lv.setId = oc.id
                        and AirportCode = '$airportCode'
                    join users v on v.id = lv.visitorid or v.id = lv.userid
                    left join agent_set on agent_set.ocid = oc.id
                    left join agent on agent.UserId = agent_set.agentid
                    left join asic_data ad on ad.UserID = v.id
                    left join identifications idA
                                               on v.id = idA.UserId
                               and idA.documenttype > ''
                               and idA.id = (select idAA.id
                                             from identifications idAA
                                             where idAA.UserID = v.id
                                             order by id desc
                                             limit 1)
                  left join identifications idB
                               on v.id = idB.UserId
                               and idB.documenttype > ''
                               and idB.id = (select idBB.id
                                             from identifications idBB
                                             where idBB.UserID = v.id
                                             order by id desc
                                             limit 1,1)
                   left join identifications idC
                               on v.id = idC.UserId
                               and idC.documenttype > ''
                               and idC.id = (select idCC.id
                                             from identifications idCC
                                             where idCC.UserID = v.id
                                             order by id desc
                                             limit 2,1)

                  order by 1

                ",
            "card_generated"=>"
                select t.id as id,
                    oc.usercode as card_number,
                    t.date_visit as date_printed,
                    t.proposed_date_out as date_expiration,
                    null as date_cancelled,
                    c.DateCardReturned as date_returned,
                    null as card_image_generated_filename,
                    l.VisitorId as visitor_id,
                    case
                      when c.DateCardReturned is not null then 2
                      when c.id is null then 3
                      when c.id is not null and c.DateCardReturned is null then 4
                    end as card_status,
                    1 as created_by,
                    oc.AirportCode as tenant,
                    l.userId as operator,
                    1 as print_count
                from oc_set oc
                    join log_visit l
                        on l.setid = oc.Id
                        and  oc.AirportCode = '$airportCode'
                        and l.date > DATE_ADD(CURRENT_DATE(),INTERVAL -1 YEAR)
                    join card_type t on t.ID = oc.CID
                    left join close_visit c on l.ID = c.LoggedId and c.visitorid = l.VisitorID
                    left join log_negate n on l.Id = n.closedid
            ",

            'visit' =>"
                  select distinct t.id as id,
                       l.visitorid as visitor,
                       9 as card_type,
                       t.ID as card,
                       t.visitor_type as visitor_type,
                       l.ReasonNo as reason,
                       1 as visitor_status,
                       l.UserId as host,
                       l.UserID as created_by,
                       l.Date as date_in,
                       l.Time as time_in,
                       c.Date as date_out,
                       c.Time as time_out,
                       l.Date as date_check_in,
                       l.Time as time_check_in,
                       c.Date as date_check_out,
                       c.Time as time_check_out,
                       case
                        when l.IsClosed = 0 then 1
                        else 3
                       end as visit_status,
                       null as workstation,
                       oc.AirportCode as tenant,
                       l.UserId as operator,
                       0 as is_deleted,
                       c.Date as finish_date,
                       c.Time as finish_time,
                       c.DateCardReturned as card_returned_date,
                       n.Reason as negate_reason,
                       c.Date as visit_closed_date,
                       l.UserID as closed_by,
                       1 as asic_declaration,
                       1 as asic_verification,
                       null as company,
                       1 as is_listed
                from oc_set oc
                    join log_visit l on l.setid = oc.Id
                        and  oc.AirportCode = '$airportCode'
                        and l.date > DATE_ADD(CURRENT_DATE(),INTERVAL -1 YEAR)
                    join card_type t on t.ID = oc.CID
                    left join close_visit c on l.ID = c.LoggedId and c.visitorid = l.VisitorID
                    left join log_negate n on l.Id = n.closedid
                order by t.id
            ",
            "reset_history"=>"SELECT  DISTINCT
                                      reset.id as id,
                                      reset.UserId as visitor_id,
                                      IFNULL(NULLIF(reset.reason,''),'Unkown') as reason,
                                      log_visit.date as reset_time
                              FROM reset
                                join oc_set on oc_set.id = reset.setid
                                    and oc_set.airportcode = '$airportCode'
                                join log_visit on log_visit.setid = oc_set.id
                                    and log_visit.date > DATE_ADD(CURRENT_DATE(),INTERVAL -1 YEAR)
            "
        ];

    }

    function getForeignKeys()
    {
        $rows = array_merge(DatabaseIndexHelper::getForeignKeys(),$this->unmappedRefs);
        $referencedTables = [];
        foreach($rows as $row){
            if(!isset($referencedTables[$row['table_name']])){
                $referencedTables[$row['table_name']]=[];
            }
            if($row['referenced_table_name']>'') {
                $referencedTables[$row['table_name']][$row['column_name']] = ['referenced_table_name' => $row['referenced_table_name'], 'referenced_column_name' => $row['referenced_column_name']];
            }
        }
        return $referencedTables;
    }


    public function cleanse(&$data)
    {
        for($i=0;$i<sizeof($data);$i++)
        {
            if($this->startsWith($data[$i],'="'))
            {
                $data[$i] = substr(2,strlen($data[$i])-3);
            }
            if(strpos($data[$i],"\\"))
            {
                $data[$i] = str_replace("\\","",$data[$i]);
            }
        }
        return $data;
    }

    function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

    function quoteValue($tableName,$columnName,$value){
        $column = Yii::app()->db->schema->tables[$tableName]->columns[$columnName];
        $type = explode(' ',explode('(',$column->dbType)[0])[0];

        if(in_array($type,['bigint','int','tinyint','float','boolean','bool','double'])){
            return $value;
        } else if($type=='bit'){
            return ord($value)==1?'1':'0';
        }
        return Yii::app()->db->quoteValue($value);
    }

    function insertRow($tableName,&$row,$isAutoIncrement){
        $vals =[];
        $colsQuoted = [];
        foreach ($row as $columnName => $value) {
            $colsQuoted[] = Yii::app()->db->quoteColumnName($columnName);
            if ($value == '') {
                $vals[] = 'NULL';
            } else {
                $vals[] = $this->quoteValue($tableName, $columnName, $value);
            }

        }

        $quotedTableName = Yii::app()->db->quoteTableName($tableName);

        $sql = "INSERT INTO " . $quotedTableName . " (" . implode(', ', $colsQuoted) . ")\r\n VALUES (" . implode(', ', $vals) . ")";

        //RUN SQL
        echo "\r\n" . $sql."\r\n";
        Yii::app()->db->createCommand($sql)->execute();

        if ($isAutoIncrement) {
            $row['id'] = Yii::app()->db->getLastInsertID();
        }

    }





}