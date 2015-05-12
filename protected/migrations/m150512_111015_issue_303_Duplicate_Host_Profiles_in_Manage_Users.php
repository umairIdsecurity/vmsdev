<?php

class m150512_111015_issue_303_Duplicate_Host_Profiles_in_Manage_Users extends CDbMigration
{
    public function up()
    {

        try {
            $COLUMNS = Yii::app()->db->createCommand()->select('COLUMN_NAME')->from('INFORMATION_SCHEMA.COLUMNS')->WHERE('table_name = \'user\' and TABLE_SCHEMA=\'vmsdev\' and COLUMN_NAME!=\'password\' and COLUMN_NAME!=\'id\'')->queryColumn();

            $this->execute(
                'ALTER TABLE  `user_workstation`
                 DROP FOREIGN KEY  `user_workstation_ibfk_3` ;

                 ALTER TABLE  `user_workstation`
                 ADD CONSTRAINT  `user_workstation_ibfk_3`
                 FOREIGN KEY (`user`)
                 REFERENCES  `vmsdev`.`user` (`id`)
                  ON DELETE CASCADE
                  ON UPDATE CASCADE ;'
            );

            $ids = Yii::app()->db->createCommand()->select('MAX(id) as id ,COUNT(*) cnt, ' . implode(',', $COLUMNS))->from('user as u')->GROUP(implode(',', $COLUMNS))->HAVING('cnt > 1')->queryColumn();
            if (!empty($ids)) {
                Yii::app()->db->createCommand()->delete('user', "`id` in(" . implode(',', $ids) . ")");
            }
            return true;
        } catch (Exception $ex) {
            echo 'ERROR IN PATCH 303 PATCHER ' . $ex;
            return false;
        }
    }

    public function down()
    {
        try {
            $this->execute(
               'ALTER TABLE  `user_workstation`
                 DROP FOREIGN KEY  `user_workstation_ibfk_3` ;

               ALTER TABLE  `user_workstation`
               ADD CONSTRAINT  `user_workstation_ibfk_3`
               FOREIGN KEY (  `user` )
               REFERENCES  `vmsdev`.`user` (`id`)
                ON DELETE RESTRICT
                 ON UPDATE RESTRICT ;'
            );
            echo "m150512_111015_issue_303_Duplicate_Host_Profiles_in_Manage_Users does not support migration down.\n";
            return true;
        } catch (Exception $ex) {
            echo 'ERROR IN PATCH 303 PATCHER ' . $ex;
            return false;
        }
        return false;
    }

}