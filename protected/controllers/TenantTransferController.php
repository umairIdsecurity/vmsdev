<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 3/10/15
 * Time: 6:04 PM
 */
class TenantTransferController extends Controller
{

    private $unmappedRefs = [
        ['table_name'=>'tenant', 'column_name'=>'id','referenced_table_name'=>'company','referenced_column_name'=>'id'],
        ['table_name'=>'user_workstation', 'column_name'=>'user_id','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'tenant_contact', 'column_name'=>'user','referenced_table_name'=>'user','referenced_column_name'=>'id'],
        ['table_name'=>'company', 'column_name'=>'tenant','referenced_table_name'=>'company','referenced_column_name'=>'id'],
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
        if (isset($_POST['ImportTenantForm']))
        {
            $model->attributes = $_POST['ImportTenantForm']; 
            //****************************************************************
            $name  = $_FILES['ImportTenantForm']['name']['file'];
            if(!empty($name)) 
            {
                $model->file=CUploadedFile::getInstance($model,'file');
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
                        foreach ($contents as $tableName => $content) {

                            if (!empty($content)) // if table has data, then create insert statements otherwise neglect it
                            {
                                // initialise mappings for table
                                if (!isset($idMappings[$tableName])) {
                                    $idMappings[$tableName] = [];
                                }

                                $rows = (array)$content;
                                $cols = array();
                                $sql = '';

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

                                    // masage the data in out of the ordinary circumstances
                                    $this->beforeInsertRow($tableName,$row);

                                    // populate referencing columns
                                    $this->setReferencingIds($tableName, $row, $foreignKeys, $idMappings, $targetTables);

                                    if (!$cols) {
                                        $cols = array_keys($row);
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

                                    $sql = "INSERT INTO " . $quotedTableName . " (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ")";

                                    //TODO: RUN SQL
                                    echo $sql . "<br>";

                                    if ($isAutoIncrement) {

                                        $row['id'] = $this->getDummyIncrement($tableName, $idMappings); //TODO:  GET NEW ID FROM DB CONNECTION
                                        //$row['id'] = Yii::app()->db->getLastInsertID();

                                    }
                                    $this->afterInsertRow($tableName,$row);
                                    if (isset($row['id'])) {
                                        $idMappings[$tableName][$oldId] = $row['id'];
                                        echo $tableName . " " . $oldId . "=" . $row['id'] . "<br>";
                                    }
                                    echo "<br><br>";
                                }
                                echo "<br><br>";
                            }
                        }

                        $transaction->commit();

                    } catch (CDbException $e) {

                        $transaction->rollback();

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

        $this->render("view", array("model" => $model));
    }

    function beforeInsertRow($tableName, &$row){
        if($tableName=='company'){
            if($row['company_type']==1){
                $row['tenant'] = NULL;
            } else if($row['company_type']==2){
                $row['tenant_agent'] = NULL;
            }
        }
    }

    function afterInsertRow($tableName,&$row){

        $sql = [];

        if($tableName=='company'){
            if($row['company_type']==1) {
                $sql[] = "UPDATE company SET tenant = id where id=" . $row['id'];
            } else if($row['company_type']==2) {
                $sql[] = "UPDATE company SET tenant_agent = id where id=" . $row['id'];
            }
        }

        foreach($sql as $statement){
            //Yii::app()->db->createCommand($statement)->execute();
            echo $statement."<br>";
        }

    }


    function quoteValue($tableName,$columnName,$value){
        $column = Yii::app()->db->schema->tables[$tableName]->columns[$columnName];
        $type = explode(' ',explode('(',$column->dbType)[0])[0];

        if(in_array($type,['bigint','int','tinyint','float','boolean','bool','double'])){
            return $value;
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
            if($value != null && isset($foreignKeys[$tableName][$columnName])){

                // get the reference
                $ref = $foreignKeys[$tableName][$columnName];

                // check that wee need to update
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

        $default_condition = 'WHERE (tenant='.$tenant.' AND is_deleted=0) ';


        return [

            'photo'                             =>[ 'JOIN company ON company.logo = photo.id '.$default_condition,
                                                    'JOIN '.$userTable.' ON '.$userTable.'.photo = photo.id '.$default_condition],

            'company'                           =>[$default_condition." OR (id=".$tenant." AND is_deleted=0) "],

            'company_laf_preferences'           =>['JOIN company ON company_laf_preferences.id = company_laf_preferences.id '.
                                                    $default_condition],

            'tenant'                            =>['WHERE id='.$tenant.' AND is_deleted=0'],

            'tenant_agent'                      =>['WHERE tenant_id='.$tenant.' AND is_deleted=0'],

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


            'visit'                             =>[$default_condition],
            'visitor'                           =>[$default_condition],
            'visit'                             =>[$default_condition],
            'visitor_type'                      =>[$default_condition],
            'visitor_type_card_type'            =>[$default_condition],

            'visitor_password_change_request'   =>['JOIN visitor ON visitor.id = visitor_password_change_request.visitor_id '.
                $default_condition],

            'card_generated'                    =>["WHERE tenant=".$tenant],

            'reset_history'                     =>['JOIN visitor ON visitor.id = reset_history.visitor_id '.
                $default_condition],

            'cardstatus_convert'                =>['JOIN visitor ON visitor.id = cardstatus_convert.visitor_id '.
                $default_condition],

            'audit_trail'                       =>['JOIN '.$userTable.' ON user.id = audit_trail.user_id '.$default_condition],

        ];
    }

}