<?php


/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 3/10/15
 * Time: 6:04 PM
 */
class TenantTransferController extends Controller
{


    public $layout = '//layouts/column2';

    private $visit_resets = [];
    private $unmappedRefs = [
        ['table_name'=>'tenant', 'column_name'=>'id','referenced_table_name'=>'company','referenced_column_name'=>'id'],
        ['table_name'=>'user_workstation', 'column_name'=>'user_id','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'tenant_contact', 'column_name'=>'user','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'company', 'column_name'=>'tenant','referenced_table_name'=>'company','referenced_column_name'=>'id'],
        ['table_name'=>'tenant_agent', 'column_name'=>'id','referenced_table_name'=>'company','referenced_column_name'=>'id'],
        ['table_name'=>'visit_reason','column_name'=>'tenant_agent','referenced_table_name'=>'tenant_agent','referenced_column_name'=>'id'],
        ['table_name'=>'visit_reason','column_name'=>'tenant','referenced_table_name'=>'tenant','referenced_column_name'=>'id'],
        ['table_name'=>'company','column_name'=>'created_by_visitor','referenced_table_name'=>'visitor','referenced_column_name'=>'id'],
        ['table_name'=>'cardstatus_convert','column_name'=>'visitor_id','referenced_table_name'=>'visitor','referenced_column_name'=>'id'],
        ['table_name'=>'card_generated','column_name'=>'tenant_agent','referenced_table_name'=>'tenant_agent','referenced_column_name'=>'id'],
        ['table_name'=>'contact_person','column_name'=>'created_by','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'contact_person','column_name'=>'tenant','referenced_table_name'=>'tenant','referenced_column_name'=>'id'],
        ['table_name'=>'contact_person','column_name'=>'user_role','referenced_table_name'=>'roles','referenced_column_name'=>'id'],
        ['table_name'=>'contact_person','column_name'=>'reason_id','referenced_table_name'=>'reason','referenced_column_name'=>'id'],
        ['table_name'=>'contact_support','column_name'=>'contact_person_id','referenced_table_name'=>'contact_person','referenced_column_name'=>'id'],
        ['table_name'=>'contact_support','column_name'=>'contact_reason_id','referenced_table_name'=>'reason','referenced_column_name'=>'id'],
        ['table_name'=>'contact_support','column_name'=>'user_id','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'reasons','column_name'=>'tenant','referenced_table_name'=>'tenant','referenced_column_name'=>'id'],
        ['table_name'=>'reset_history','column_name'=>'visitor_id','referenced_table_name'=>'visitor','referenced_column_name'=>'id'],
        ['table_name'=>'tenant','column_name'=>'created_by','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'tenant_agent','column_name'=>'created_by','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'tenant_contact','column_name'=>'user','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'user','column_name'=>'photo','referenced_table_name'=>'photo','referenced_column_name'=>'id'],
        ['table_name'=>'user_notification','column_name'=>'user_id','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'user_notification','column_name'=>'notification_id','referenced_table_name'=>'notification','referenced_column_name'=>'id'],
        ['table_name'=>'visit','column_name'=>'tenant_agent','referenced_table_name'=>'tenant_agent','referenced_column_name'=>'id'],
        ['table_name'=>'visit','column_name'=>'asic_escort','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'visit','column_name'=>'closed_by','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'visitor','column_name'=>'tenant_agent','referenced_table_name'=>'tenant_agent','referenced_column_name'=>'id'],
        ['table_name'=>'tenant_agent_contact','column_name'=>'tenant_id','referenced_table_name'=>'tenant','referenced_column_name'=>'id'],
        ['table_name'=>'tenant_agent_contact','column_name'=>'user_id','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'tenant_agent_contact','column_name'=>'tenant_agent_id','referenced_table_name'=>'tenant_agent','referenced_column_name'=>'id'],
        ['table_name'=>'user','column_name'=>'tenant_agent','referenced_table_name'=>'tenant_agent','referenced_column_name'=>'id'],
        ['table_name'=>'workstation','column_name'=>'tenant','referenced_table_name'=>'company','referenced_column_name'=>'id'],
        ['table_name'=>'workstation','column_name'=>'tenant_agent','referenced_table_name'=>'company','referenced_column_name'=>'id'],
        ['table_name'=>'visitor_type','column_name'=>'tenant','referenced_table_name'=>'company','referenced_column_name'=>'id'],
        ['table_name'=>'visitor_type','column_name'=>'tenant_agent','referenced_table_name'=>'company','referenced_column_name'=>'id'],


    ];


    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow user if same company
                'actions' => array('export','import','deleteSql'),
                'expression' => 'Yii::app()->user->role  == Roles::ROLE_SUPERADMIN',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }



    public function actionExport(){

        $tenant = $_REQUEST['tenant'];
        $queries = $this->getQueries($tenant);

        $data=[];
        $dataHelper = new DataHelper(Yii::app()->db);
        foreach($queries as $table=>$conditions){

            $tableName = Yii::app()->db->quoteTableName($table);
            $data[$table] = [];
            foreach($conditions as $condition) {
                $data[$table] = array_merge($data[$table],$dataHelper->getRows("SELECT " . $tableName . ".* FROM " . $tableName . " " . $condition));
            }
        }
        
        Yii::app()->getRequest()->sendFile($this->getTenantName($data).'.tenant',json_encode($data,JSON_PRETTY_PRINT));

    }

    function actionDeleteSql()
    {
        $tenant = $_REQUEST['tenant'];
        $queries = array_reverse($this->getQueries($tenant));

        $data=[];
        $sql = "";
        foreach($queries as $table=>$conditions){
            $tableName = Yii::app()->db->quoteTableName($table);
            $data[$table] = [];
            foreach($conditions as $condition) {
                $sql = $sql."DELETE FROM " . $tableName . " WHERE EXISTS (SELECT ".$tableName.".* WHERE " . $condition." )\r\n";
            }
        }

        Yii::app()->getRequest()->sendFile("Delete Tenant ".$tenant.'.sql',$sql);
    }


    public function actionImport()
    {
        $model = new ImportTenantForm();
        $session = new CHttpSession;
        if (isset($_POST['ImportTenantForm'])) {
            $model->attributes = $_POST['ImportTenantForm'];
            $this->importTenant($model);
            //$this->importAvms7Data($model);

        }
        return $this->render("importTenant", array("model" => $model));

    }

    private function importAvms7Data()
    {
        $name  = $_FILES['ImportTenantForm']['name']['avms7File'];
        if(!empty($name)) {

        }
    }

    private function importTenant($model)
    {

        $name  = $_FILES['ImportTenantForm']['name']['tenantFile'];
        if(!empty($name))
        {
            $model->file=CUploadedFile::getInstance($model,'$tenantFile');
            $fullImgSource = Yii::getPathOfAlias('webroot').'/uploads/visitor/'.$name;

            // get database foriegn keys
            $foreignKeys = $this->getForeignKeys();


            if($model->file->saveAs($fullImgSource))
            {

                $data=file_get_contents($fullImgSource);
                $obj = json_decode($data);
                /*** cast the object to array ***/
                $contents = (array) $obj;

                // create a mappings array
                $idMappings = [];

                // add super admin to mappings
                $idMappings['user'][1]=1;
                $idMappings['company'][1]=1;

                $targetTables = $this->getTargetTableNames();

                $transaction = Yii::app()->db->beginTransaction();
                try {

                    foreach($targetTables as $tableName){
                    //foreach ($contents as $tableName => $content) {

                        if(!isset($contents[$tableName]))
                            continue;

                        $content = $contents[$tableName];

                        if (!empty($content)) // if table has data, then create insert statements otherwise neglect it
                        {
                            // initialise mappings for table
                            if (!isset($idMappings[$tableName])) {
                                $idMappings[$tableName] = [];
                            }

                            $rows = (array)$content;

                            $this->importTable($tableName,$rows,$foreignKeys,$targetTables,$idMappings);
                        }
                    }

                    $transaction->commit();

                } catch (CException $e) {

                    $transaction->rollback();
                    echo "<br><br>";
                    echo $e->getMessage();
                    die();
                }

                if (file_exists($fullImgSource))
                {
                    unlink($fullImgSource);
                }
                die();
            }
        }
        //****************************************************************

        
    }

    function importTable($tableName,$rows,$foreignKeys,$targetTables,$idMappings){

        $cols = [];

        $isAutoIncrement = sizeof($rows) > 0 && isset($rows[0]->id) && Yii::app()->db->schema->tables[$tableName]->columns['id']->autoIncrement;

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
            $this->beforeInsertRow($tableName,$row,$oldId);

            // populate referencing columns
            $this->setReferencingIds($tableName, $row, $foreignKeys, $idMappings, $targetTables);

            if (!$cols) {
                $cols = array_keys($row);
                $colsQuoted = [];
                foreach($cols as $col){
                    $colsQuoted[] = Yii::app()->db->quoteColumnName($col);
                }
            }
            $vals = array();
            foreach ($row as $columnName => $value) {
                if ($value == '') {
                    $vals[] = 'NULL';
                } else {
                    $vals[] = $this->quoteValue($tableName, $columnName, $value);
                }

            }

            $quotedTableName = Yii::app()->db->quoteTableName($tableName);

            $sql = "INSERT INTO " . $quotedTableName . " (" . implode(', ', $colsQuoted) . ") VALUES (" . implode(', ', $vals) . ")";

            //RUN SQL
            echo $sql . "<br>";
            Yii::app()->db->createCommand($sql)->execute();

            if ($isAutoIncrement) {

                //$row['id'] = $this->getDummyIncrement($tableName, $idMappings); //TODO:  GET NEW ID FROM DB CONNECTION
                $row['id'] = Yii::app()->db->getLastInsertID();

            }

            $this->afterInsertRow($tableName,$row,$idMappings,$oldId);

            if (isset($row['id'])) {
                $idMappings[$tableName][$oldId] = $row['id'];
                echo $tableName . " " . $oldId . "=" . $row['id'] . "<br>";
            }
            echo "<br><br>";
        }
        echo "<br><br>";
    }

    function beforeInsertRow($tableName, &$row,$oldId){
        if($tableName=='user' and $row['first_name']=='Kris'){
            echo 'found kris';
        }
        if($tableName=='company'){
            if($row['company_type']==1){
                $row['tenant'] = NULL;
            } else if($row['company_type']==2){
                $row['tenant_agent'] = NULL;
            }
        }

        if($tableName=='visit' && isset($row['reset_id'])){
            $this->visit_resets[$row['reset_id']] = $oldId;
            $row['reset_id'] = null;
        }
    }

    function afterInsertRow($tableName,&$row, &$idMappings,$oldId){

        $sql = [];

        if($tableName=='company'){
            if($row['company_type']==1) {
                //$sql[] = "UPDATE company SET tenant = id where id=" . $row['id'];
                $idMappings['tenant'][$oldId] = $row['id'];
            } else if($row['company_type']==2) {
                //$sql[] = "UPDATE company SET tenant_agent = id where id=" . $row['id'];
                $idMappings['tenant_agent'][$oldId] = $row['id'];
            }
        }

        if($tableName=="reset_history" && isset($this->visit_resets[$oldId]))
        {
            $visit_id = $idMappings['visit'][$this->visit_resets[$oldId]];
            $sql[] = "UPDATE visit SET reset_id = ".$row['id']." WHERE id = ".$visit_id;
            echo $sql;
        }


        foreach($sql as $statement){
            echo $statement."<br>";
            Yii::app()->db->createCommand($statement)->execute();
        }

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

    function getDummyIncrement($tableName, $idMappings){

        if(!isset($idMappings[$tableName]) || sizeof($idMappings[$tableName])==0) {
            return 1;
        }
        $idValues = array_values($idMappings[$tableName]);
        $lastVal = end($idValues);
        return $lastVal + 1;
    }


    function setReferencingIds($tableName, &$row, $foreignKeys, &$idMappings,$targetTables){

        // go through each column
        foreach($row as $columnName=>$value){

            // if there is a foriegn key reference
            if($value != null && $value!=0 && isset($foreignKeys[$tableName][$columnName])){

                // get the reference
                $ref = $foreignKeys[$tableName][$columnName];

                // check that we need to update
                if(in_array($ref['referenced_table_name'],$targetTables)) {


                    // check that we've already got a value for the reference
                    if (isset($idMappings[$ref['referenced_table_name']][$value])) {

                        // set the reference value on the row
                        $row[$columnName] = $idMappings[$ref['referenced_table_name']][$value];
                        echo $tableName.".".$columnName." ".$value."=".$row[$columnName]."<br>";

                    } else {

                        throw new CException("New id value for " . $tableName . "." . $columnName . "=" . $value . " does not exist. perhaps tables are added in wrong order?");

                    }
                }
            }
        }

    }


    function getTenantName($data){
        return $data['company'][0]['name'];
    }

    function getForeignKeys()
    {
        $rows = array_merge(DatabaseIndexHelper::getForeignKeys(),$this->unmappedRefs);
        $referencedTables = [];
        foreach($rows as $row){
            if(!isset($referencedTables[$row['table_name']])){
                $referencedTables[$row['table_name']]=[];
            }
            $referencedTables[$row['table_name']][$row['column_name']]=['referenced_table_name'=>$row['referenced_table_name'],'referenced_column_name'=>$row['referenced_column_name']];
        }
        return $referencedTables;
    }


    private function getTargetTableNames()
    {
        return array_keys($this->getQueries('tenant'));
    }

    private function getQueries($tenant)
    {
        $userTable = Yii::app()->db->quoteTableName('user');

        $default_condition = 'WHERE (tenant='.$tenant.') ';


        return [

            'photo'                             =>[ "JOIN company ON company.logo = photo.id WHERE (tenant = $tenant or company.id = ".$tenant.")",
                                                    'JOIN '.$userTable.' ON '.$userTable.'.photo = photo.id '.$default_condition],

            'company_laf_preferences'           =>['JOIN company ON company_laf_preferences.id = company.company_laf_preferences '.
                                                    "WHERE (tenant = $tenant or company.id = ".$tenant.")"],

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

            'reset_history'                     =>['JOIN visitor ON visitor.id = reset_history.visitor_id '.
                                                    $default_condition],


            'card_generated'                    =>["WHERE tenant=".$tenant],

            'visit'                             =>[$default_condition],

            'visitor_type_card_type'            =>[$default_condition],

            'visitor_password_change_request'   =>['JOIN visitor ON visitor.id = visitor_password_change_request.visitor_id '.
                                                    $default_condition],

            'cardstatus_convert'                =>['JOIN visitor ON visitor.id = cardstatus_convert.visitor_id '.
                                                    $default_condition],

            'contact_person'                    =>['WHERE tenant = '.$tenant],

            //'contact_support'                   =>['JOIN '.$userTable.' ON user.id = contact_support.user_id '.$default_condition],

            //'audit_trail'                       =>['JOIN '.$userTable.' ON user.id = audit_trail.user_id '.$default_condition],

        ];
    }

}