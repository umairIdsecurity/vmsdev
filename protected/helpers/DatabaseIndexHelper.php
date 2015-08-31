<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 30/08/15
 * Time: 7:49 AM
 */
class DatabaseIndexHelper
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
        $pkExclude = $excludePrimaryKey?",'PRIMARY KEY'":"";
        $driverName = Yii::app()->db->driverName;
        $sql = null;

        switch($driverName) {

            case 'mssql';
            case 'sqlsrv';
                $sql = "SELECT TC.TABLE_NAME AS 'table_name',
                              TC.CONSTRAIN_NAME AS 'constraint_name',
                              KCU.ORDINAL_POSITION AS 'ordinal_position',
                              KCU.COLUMN_NAME AS 'column_name',
                              TC.CONSTRAINT_TYPE AS 'constraint_type'
                        FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS TC
                          JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE KCU
                          ON TC.CONSTRAINT_NAME = KCU.CONSTRAINT_NAME
                            AND CONSTRAINT_TYPE NOT IN ('FOREIGN KEY'$pkExclude)
                        WHERE TC.TABLE_NAME = '$tableName'
                        AND TC.TABLE_CATALOG = (SELECT DATABASE())
                        ORDER BY 1,2,3,4";
                break;

            case 'mysql';
                $sql="TABLE_NAME as 'table_name',
                             CONSTRAINT_NAME as 'constraint_name',
                             ORDINAL_POSITION as 'ordinal_position',
                             COLUMN_NAME as 'column_name'
                       FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                       WHERE REFERENCED_TABLE_NAME IS NULL
                       AND CONSTRAINT_NAME != 'PRIMARY'
                       AND TABLE_SCHEMA = (SELECT DATABASE())
                       ORDER BY 1,2,3,4";
                break;
        }

        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
        $reader = $command->query();

        $result = [];
        $data = [];
        foreach($reader as $row){

            if($data['table_name'] != $row['table_name'] || $data['constraint_name'] != $row['constraint_name']){
                $data = $row;
                $result[] = $row;
                $data['columns'] = [];
            }

            $data['columns'][] = $row['column_name'];
        }

        return $result;
    }


}