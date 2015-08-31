<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 30/08/15
 * Time: 7:39 AM
 */
class ResetDatabaseCommand extends CConsoleCommand
{
    static $ReferenceTables = [
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
    static $StartupDataQueries = [
        ['table'=>'tenant','condition'=>'id=1'],
        ['table'=>'company_laf_preferences','condition'=>'id=1'],
        ['table'=>'company','condition'=>'id=1'],
        ['table'=>'user','condition'=>'id=1'],
        ['table'=>'license_details','condition'=>'id=1'],
    ];

    public function actionIndex()
    {
        $this->actionExportSchema();
        $this->actionImportSchema();
    }

    public function actionClearDatabase(){
        $this->actionDropAllForeignKeys();
        $this->actionDropAllTables();
    }

    public function actionRestoreToMinimalDatabase()
    {
        //$this->actionExportMinimalDatabase();
        $this->actionDropAllForeignKeys();
        $this->actionDropAllTables();
    }

    public function actionCreateMinimalDatabase()
    {

    }

    public function actionExportMinimalDatabase()
    {
        $this->actionExportSchema();
        $this->actionExportReferenceData();
        $this->actionExportStartupData();


    }

    public function actionDropAllForeignKeys()
    {
        foreach(Yii::app()->db->schema->table as $table){
            foreach($table->foreignKeys as $fk){
                $keyName = ForeignKeyHelper::getForeignKeyName($fk->table,$fk->column,$fk->refTable,$fk->refColumn);
                Yii::app()->db->dropForiegnKey($keyName,$table);
            }
        }
    }

    public function actionDropAllTables()
    {
        foreach(Yii::app()->db->schema->table as $table) {
            Yii::app()->db->dropTable($table->name);
        }
    }

    public function actionImportSchema(){

        $fileName = realpath($yii=dirname(__FILE__)."/../../database")."/json/schema.json";
        $schema = CJSON::decode(file_get_contents($fileName),true);

        // create tables and keys
        foreach($schema['tables'] as $table){

            // get column definitions
            $columnDefs = [];
            foreach($table['columns'] as $column){
                $columnDefs[strtolower($column['name'])] = $this->getColumnDef($column);
            }

            // create the table
            $this->runSql(Yii::app()->db->schema->createTable('name',$columnDefs));

            // create primary key if we haven't already
            if((!isset($columnDefs['id']) || strpos($columnDefs['id'],'pk' )==-1) && isset($table['primaryKey'])){
                $this->runSql(Yii::app()->db->schema->addPrimaryKey($table['name']."_pk",$table['name'],$table['primaryKey']));
            }


        }

        foreach($schema['indexes'] as $index){
            $this->runSql(Yii::app()->db-$schema->createIndex($index['table_name']."_".implode('_',$index['columns']),$index['table_name'],$index['columns'],true));
        }


    }

    public function runSql($sql){

        echo $sql."\n\n";
    }

    public function getColumnDef($column){

        // get an initial db type
        $dbType = Yii::app()->db->schema->getColumnType($column['type']);

        // use the pk auto increment
        if($column['isPrimaryKey'] && $column['autoIncrement']){
            if($column['type']=='bigint'){
                $dbType='bigpk';
            } else{
                $dbType='pk';
            }
        }

        // fix column lengths
        if($column['type']=='string'){
            $dbType = str_replace('255',(string) $column['size'],$dbType);
        }

        // build the output
        $result = $dbType." "
                . ($column['allowNull']?" NULL":" NOT NULL");
                //. (isset($column['defaultValue'])?"DEFAULT ".Yii::app()->db-quoteValue($column['defaultValue']):"");

        return $result;

    }

    public function sanitiseDataType($type){

        if(strpos($type['dbType'],'int')==0) {

            if($type['isPrimaryKey']) {
                if ($type['autoIncrement']) {
                    return 'pk';
                }
                return 'int';
            }

            return 'int';


        }

        if(strpos($type['dbType'],'bigint')==0)
            return 'bigint';

        return $type;
    }







    public function actionExportSchema()
    {
        $driverName = Yii::app()->db->driverName;
        $fileName = realpath($yii=dirname(__FILE__)."/../../database")."/json/schema.json";
        echo "writing schema to $fileName";
        $schema['tables'] = CJSON::decode(CJSON::encode(Yii::app()->db->schema->tables));
        $schema['indexes'] = DatabaseIndexHelper::getTableIndexes();
        file_put_contents($fileName, CJSON::encode($schema));
    }

    public function actionExportReferenceData(){
        $data = [];
        foreach(ResetDatabaseCommand::$ReferenceTables as $table){
            $data[] = $this->buildExportData($table,null);
        }
        $fileName = realpath($yii=dirname(__FILE__)."/../../database")."/json/referencedata.json";
        file_put_contents($fileName, CJSON::encode($data));
    }

    public function actionExportStartupData(){
        $data = [];
        foreach(ResetDatabaseCommand::$StartupDataQueries as $query){
            $data[] = $this->buildExportData($query['table'],$query['condition']);
        }
        $fileName = realpath($yii=dirname(__FILE__)."/../../database")."/json/startupdata.json";
        file_put_contents($fileName, CJSON::encode($data));
    }

    public function buildExportData($table, $condition = null){

        $columnsQuoted = [];
        $columns = [];
        foreach(Yii::app()->db->schema->getTable($table)->columns as $column){
            $columnsQuoted[] = Yii::app()->db->quoteColumnName($column->name);
            $columns[] = $column->name;
        }

        $tableName = Yii::app()->db->quoteTableName($table);
        $sql="SELECT ".implode(',',$columnsQuoted)." "
            ."FROM $tableName ";

        if($condition) {
            $sql = $sql."WHERE $condition";
        }

        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        $rows = [];
        foreach($reader as $row){
            $rows[] = $row;
        }

        return  ['table'=>$table,'columns'=>$columns,'rows'=>$rows];
    }



    public function actionImportReferenceData(){

    }

}