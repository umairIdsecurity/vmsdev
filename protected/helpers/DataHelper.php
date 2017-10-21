<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 26/09/15
 * Time: 6:37 PM
 */
class DataHelper
{
    public $db = null;
    public function __construct($db)
    {
        $this->db = $db; 
        //parent::__construct();
        
    }


    public function actionClearDatabase(){
        $this->actionDropAllForeignKeys();
        $this->actionDropAllTables();
    }



    public function actionDropAllForeignKeys()
    {
        foreach($this->db->schema->table as $table){
            foreach($table->foreignKeys as $fk){
                $keyName = ForeignKeyHelper::getForeignKeyName($fk->table,$fk->column,$fk->refTable,$fk->refColumn);
                $this->db->dropForiegnKey($keyName,$table);
            }
        }
    }

    public function actionDropAllTables()
    {
        foreach($this->db->schema->table as $table) {
            $this->db->dropTable($table->name);
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
            $this->runSql($this->db->schema->createTable('name',$columnDefs));

            // create primary key if we haven't already
            if((!isset($columnDefs['id']) || strpos($columnDefs['id'],'pk' )==-1) && isset($table['primaryKey'])){
                $this->runSql($this->db->schema->addPrimaryKey($table['name']."_pk",$table['name'],$table['primaryKey']));
            }


        }

        foreach($schema['indexes'] as $index){
            $this->runSql($this->db-$schema->createIndex($index['table_name']."_".implode('_',$index['columns']),$index['table_name'],$index['columns'],true));
        }

    }

    public function runSql($sql){

        echo $sql."\n\n";
    }

    public function getColumnDef($column){

        // get an initial db type
        $dbType = $this->db->schema->getColumnType($column['type']);

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
        //. (isset($column['defaultValue'])?"DEFAULT ".$this->db-quoteValue($column['defaultValue']):"");

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
        $fileName = realpath($yii=dirname(__FILE__)."/../../database")."/json/schema.json";
        echo "writing schema to $fileName";
        $schema['tables'] = CJSON::decode(CJSON::encode($this->db->schema->tables));
        $schema['indexes'] = DatabaseIndexHelper::getTableIndexes();
        file_put_contents($fileName, CJSON::encode($schema));
    }



    public function buildExportData($table, $condition = null){

        $columnsQuoted = [];
        $columns = [];
        foreach($this->db->schema->getTable($table)->columns as $column){
            $columnsQuoted[] = $this->db->quoteColumnName($column->name);
            $columns[] = $column->name;
        }

        $tableName = $this->db->quoteTableName($table);
        $sql="SELECT ".implode(','.$tableName.'.',$columnsQuoted)." "
            ."FROM $tableName ";

        if($condition) {
            $sql = $sql."WHERE $condition";
        }

        $command = $this->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        $rows = [];
        foreach($reader as $row){
            $rows[] = $row;
        }

        return  ['table'=>$table,'columns'=>$columns,'rows'=>$rows];
    }

    public function buildExportDataFromQuery($table, $sql){

        $columnsQuoted = [];
        $columns = [];
        foreach($this->db->schema->getTable($table)->columns as $column){
            $columnsQuoted[] = $this->db->quoteColumnName($column->name);
            $columns[] = $column->name;
        }

        $command = $this->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        $rows = [];
        foreach($reader as $row){
            $rows[] = $row;
        }

        return  ['table'=>$table,'columns'=>$columns,'rows'=>$rows];
    }

    public function getFirstRow($sql){
        $command = $this->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        foreach($reader as $row){
            return $row;
        }
        return [];
    }

    public function getRows($sql){
        $command = $this->db->createCommand($sql);
        $command->execute();
        $reader =  $command->query();
        $result = [];
        foreach($reader as $row){
            $result[] =  $row;
        }
        return $result;
    }

    public function insertRows($sql){
        $command = $this->db->createCommand($sql);
        $command->execute();
    }

    public function isNullable($tableName,$columnName){
        return $this->db->schema->tables[$tableName]->columns[$columnName]->allowNull;
    }

    public function isDateColumn($tableName,$columnName){
        $this->db->schema->tables[$tableName]->columns[$columnName]->type=='date';
    }

    public function quoteValue($tableName,$columnName,$value){
        $column = $this->db->schema->tables[$tableName]->columns[$columnName];
        $type = explode(' ',explode('(',$column->dbType)[0])[0];

        if(in_array($type,['bigint','int','tinyint','float','boolean','bool','double'])){
            return $value;
        } else if($type=='bit'){
            return ord($value)==1?'1':'0';
        }
        return $this->db->quoteValue($value);
    }

    public function insertRow($tableName,&$row,$isAutoIncrement){
        $vals =[];
        $colsQuoted = [];
        foreach ($row as $columnName => $value) {
            $colsQuoted[] = $this->db->quoteColumnName($columnName);
            if ($value == '') {
                $vals[] = 'NULL';
            } else {
                $vals[] = $this->quoteValue($tableName, $columnName, $value);
            }

        }

        $quotedTableName = $this->db->quoteTableName($tableName);

        $sql = "INSERT INTO " . $quotedTableName . " (" . implode(', ', $colsQuoted) . ") \r\nVALUES (" . implode(', ', $vals) . ")";

        //RUN SQL
        echo "\r\n" . $sql;
        $this->db->createCommand($sql)->execute();

        if ($isAutoIncrement) {
            $row['id'] = $this->db->getLastInsertID();
        }

        return $row;

    }


}