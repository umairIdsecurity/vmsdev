<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 30/08/15
 * Time: 7:49 AM
 */
class DatabaseIndexHelper
{
    public static function getForeignKeys(){

        $driverName = Yii::app()->db->driverName;
        $sql = null;

        switch($driverName) {

            case 'mysql';
                $sql =  "SELECT table_name, column_name, referenced_table_name, referenced_column_name "
                        ."FROM  information_schema.key_column_usage "
                        ."WHERE constraint_schema =  (SELECT DATABASE())";
                break;

            case 'mssql';
            case 'sqlsrv';
                $sql = "SELECT FK.TABLE_NAME as table_name, CU.COLUMN_NAME as column_name, "
                    .   "PK.TABLE_NAME as referenced_table_name, PT.COLUMN_NAME as  referenced_column_name "
                    ."FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS C "
                    ."	INNER JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS FK "
                    ."		ON C.CONSTRAINT_NAME = FK.CONSTRAINT_NAME "
                    ."	INNER JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS PK "
                    ."		ON C.UNIQUE_CONSTRAINT_NAME = PK.CONSTRAINT_NAME "
                    ."	INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE CU "
                    ."		ON C.CONSTRAINT_NAME = CU.CONSTRAINT_NAME "
                    ."	INNER JOIN ( "
                    ."            SELECT i1.TABLE_NAME, i2.COLUMN_NAME "
                    ."            FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS i1 "
                    ."              INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE i2 "
                    ."                ON i1.CONSTRAINT_NAME = i2.CONSTRAINT_NAME "
                    ."            WHERE i1.CONSTRAINT_TYPE = 'PRIMARY KEY' "
                    ."           ) PT "
                    ."      ON PT.TABLE_NAME = PK.TABLE_NAME ";
                break;

            default;
                throw new CDbException($driverName." is not supported");

        }

        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $reader =  $command->query();
        $result = [];
        foreach($reader as $row){
            $result[] =  $row;
        }
        return $result;

    }


    public static function getForeignKeyName($table,$column,$refTable,$refColumn){

        $driverName = Yii::app()->db->driverName;
        $sql = null;

        switch($driverName) {

            case 'mysql';
                //$databaseName = DatabaseIndexHelper::getValue("SELECT DATABASE()");
                $sql = "SELECT constraint_name as name "
                        ."FROM information_schema.key_column_usage "
                        ."WHERE referenced_table_name = '$refTable' "
                        ."AND   referenced_column_name = '$refColumn' "
                        ."AND   table_name = '$table' "
                        ."AND   column_name = '$column' "
                        ."AND   constraint_schema = (SELECT DATABASE())";
                break;

            case 'mssql';
            case 'sqlsrv';
                $sql = "SELECT C.CONSTRAINT_NAME as name "
                    ."FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS C "
                    ."	INNER JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS FK "
                    ."		ON C.CONSTRAINT_NAME = FK.CONSTRAINT_NAME "
                    ."	INNER JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS PK "
                    ."		ON C.UNIQUE_CONSTRAINT_NAME = PK.CONSTRAINT_NAME "
                    ."	INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE CU "
                    ."		ON C.CONSTRAINT_NAME = CU.CONSTRAINT_NAME "
                    ."	INNER JOIN ( "
                    ."            SELECT i1.TABLE_NAME, i2.COLUMN_NAME "
                    ."            FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS i1 "
                    ."              INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE i2 "
                    ."                ON i1.CONSTRAINT_NAME = i2.CONSTRAINT_NAME "
                    ."            WHERE i1.CONSTRAINT_TYPE = 'PRIMARY KEY' "
                    ."           ) PT "
                    ."      ON PT.TABLE_NAME = PK.TABLE_NAME "
                    ."WHERE FK.TABLE_NAME = '$table' "
                    ."AND CU.COLUMN_NAME = '$column' "
                    ."AND PK.TABLE_NAME = '$refTable' "
                    ."AND PT.COLUMN_NAME = '$refColumn' ";
                break;

            default;
                throw new CDbException($driverName." is not supported");

        }

        return DatabaseIndexHelper::getValue($sql);

    }

    public static function getPrimaryKeyName($tableName){

        $driverName = Yii::app()->db->driverName;
        $sql = null;


        switch($driverName) {

            case 'mssql';
            case 'sqlsrv';


                $sql = "SELECT CONSTRAINT_NAME as name
                        FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
                        WHERE CONSTRAINT_TYPE = 'PRIMARY KEY'
                        AND TABLE_NAME = '$tableName'";
                break;

            case 'mysql';

                $sql = "SELECT CONSTRAINT_NAME as name
                        FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
                        WHERE CONSTRAINT_TYPE = 'PRIMARY KEY'
                        AND CONSTRAINT_SCHEMA = (SELECT DATABASE())
                        AND TABLE_NAME = '$tableName'";

                break;

        }

        return DatabaseIndexHelper::getValue($sql);
    }

    public static function getDefaultConstrainName($tableName,$columnName){

        $sql = "select d.name
                from sys.tables t
                  join sys.default_constraints d
                   on d.parent_object_id = t.object_id
                  join    sys.columns c
                   on c.object_id = t.object_id
                    and c.column_id = d.parent_column_id
                 where t.name = '$tableName'
                  and c.name = '$columnName'";

        return getValue($sql);

    }

    private static function getValue($sql){

        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        foreach($reader as $row){
            return array_values($row)[0];
        }
        return null;
    }

    public static function getTableIndexes($excludePrimaryKeys = true)
    {
        $pkExclude = $excludePrimaryKeys?",'PRIMARY KEY'":"";
        $driverName = Yii::app()->db->driverName;
        $sql = null;


        switch($driverName) {

            case 'mssql';
            case 'sqlsrv';
                $pkExclude = $excludePrimaryKeys?",'PRIMARY KEY'":"";
                $sql = "SELECT TC.TABLE_NAME AS 'table_name',
                              TC.CONSTRAIN_NAME AS 'constraint_name',
                              KCU.ORDINAL_POSITION AS 'ordinal_position',
                              KCU.COLUMN_NAME AS 'column_name',
                              TC.CONSTRAINT_TYPE AS 'constraint_type'
                        FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS TC
                          JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE KCU
                          ON TC.CONSTRAINT_NAME = KCU.CONSTRAINT_NAME
                            AND CONSTRAINT_TYPE NOT IN ('FOREIGN KEY'$pkExclude)
                        WHERE TC.TABLE_CATALOG = (SELECT DATABASE())
                        ORDER BY 1,2,3,4";
                break;

            case 'mysql';
                $pkExclude = $excludePrimaryKeys?"AND CONSTRAINT_NAME != 'PRIMARY'":"";
                $sql="SELECT TABLE_NAME as 'table_name',
                             CONSTRAINT_NAME as 'constraint_name',
                             ORDINAL_POSITION as 'ordinal_position',
                             COLUMN_NAME as 'column_name'
                       FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                       WHERE REFERENCED_TABLE_NAME IS NULL
                       $pkExclude
                       AND TABLE_SCHEMA = (SELECT DATABASE())
                       ORDER BY 1,2,3,4";
                break;
        }

        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();

        $result = [];
        $data = null;
        foreach($reader as $row){

            if($data == null || $data['table_name'] != $row['table_name'] || $data['constraint_name'] != $row['constraint_name']){
                if($data!=null){
                    $result[] = $data;
                }
                $data = $row;
                $data['columns'] = [];
            }

            $data['columns'][] = $row['column_name'];
        }
        $data['column_name']=null;
        $result[] = $data;

        return $result;
    }


}