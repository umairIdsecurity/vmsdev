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
                        ."AND   constraint_catalog = DATABASE()";
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


}