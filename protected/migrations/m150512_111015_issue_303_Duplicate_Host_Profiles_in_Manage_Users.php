<?php

class m150512_111015_issue_303_Duplicate_Host_Profiles_in_Manage_Users extends CDbMigration
{
    public function up()
    {

/*        $DBName = $this->getDBName();

        try {
            $COLUMNS = Yii::app()->db->createCommand()->select('COLUMN_NAME')->from('INFORMATION_SCHEMA.COLUMNS')->WHERE('table_name = \'user\' and TABLE_SCHEMA=\'' . $DBName . '\' and COLUMN_NAME!=\'password\' and COLUMN_NAME!=\'id\' and COLUMN_NAME!=\'is_deleted\'')->queryColumn();

            $this->dropForeignKey('user_workstation_ibfk_3', 'user_workstation');
            $this->addForeignKey('user_workstation_ibfk_3', 'user_workstation', 'user', 'user', 'id', 'CASCADE', 'CASCADE');
            $this->dropForeignKey('visit_ibfk_6', 'visit');
            $this->addForeignKey('visit_ibfk_6', 'visit', 'host', 'user', 'id', 'CASCADE', 'CASCADE');

            $ids = Yii::app()->db->createCommand()->select('MAX(id) as id ,COUNT(*) cnt, ' . implode(',', $COLUMNS))->from('user as u')->GROUP(implode(',', $COLUMNS))->HAVING('cnt > 1')->queryColumn();
            if (!empty($ids)) {
                Yii::app()->db->createCommand()->delete('user', "id in(" . implode(',', $ids) . ")");
            }
            return true;
        } catch (Exception $ex) {
            echo 'ERROR IN PATCH 303 PATCHER ' . $ex;
            return false;
        }*/
    }

    public function down()
    {
/*        try {

            $this->dropForeignKey('user_workstation_ibfk_3', 'user_workstation');
            $this->addForeignKey('user_workstation_ibfk_3', 'user_workstation', 'user', 'user', 'id', 'RESTRICT', 'RESTRICT');
            $this->dropForeignKey('visit_ibfk_6', 'visit');
            $this->addForeignKey('visit_ibfk_6', 'visit', 'host', 'user', 'id', 'RESTRICT', 'RESTRICT');
            return true;
        } catch (Exception $ex) {
            echo 'ERROR IN PATCH 303 PATCHER ' . $ex;
            return false;
        }*/
    }



    public function getDBName()
    {
        $name   = preg_match("/dbname=([^;]*)/", Yii::app()->db->connectionString, $matches);
        $DBName = '';
        if ($name) {
            $DBName = $matches[1];
        }
        return $DBName;
    }

}