<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 30/08/15
 * Time: 7:49 AM
 */
class ForeignKeyHelper
{
    public static function getForeignKeyName($table,$column,$refTable,$refColumn){

        $driverName = Yii::app()->db->driverName;
        $sql = null;

        switch($driverName) {

            case 'mysql';
                $sql = "SELECT constraint_name as name "
                        ."FROM information_schema.key_column_usage "
                        ."WHERE referenced_table_name = '$refTable' "
                        ."AND   referenced_column_name = '$refColumn' "
                        ."AND   table_name = '$table' "
                        ."AND   column_name = '$column' "
                        ."AND   constraint_catalog = (SELECT DATABASE())";
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

        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        foreach($reader as $row){
            return $row['name'];
        }
        return null;

    }

    public function getTableIndexes($tableName, $excludePrimaryKey = true)
    {
        $keyValue = $excludePrimaryKey?0:1;

        $sql = "SELECT  t.[name] AS [table_name],
                        ind.[name] AS [index_name],
                        ic.column_id AS [column_id],
                        col.[name] AS [column_name],
                        ind.[type_desc] AS [type_desc],
                        col.is_identity AS [is_identity],
                        ind.[is_unique] AS [is_unique],
                        ind.[is_primary_key] AS [is_primary_key]
                    FROM sys.indexes ind
                        INNER JOIN sys.index_columns ic
                            ON ind.object_id = ic.object_id AND ind.index_id = ic.index_id
                        INNER JOIN sys.columns col
                            ON ic.object_id = col.object_id and ic.column_id = col.column_id
                        INNER JOIN sys.tables t
                            ON ind.object_id = t.object_id
                    WHERE t.[name] = '$tableName'
                        AND t.is_ms_shipped = 0
                        AND ind.is_primary_key = $keyValue
                        AND OBJECT_SCHEMA_NAME(t.[object_id],DB_ID()) = (SELECT DATABASE())
                    ORDER BY 1,2,3,4";

        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();
        $result = [];
        $data = [];
        foreach($reader as $row){
           // if($data[])
            $data['table_name']=$row['TableName'];
        }
        return null;

    }


}