<?php

class m150425_081700_issue_170_addPhoTotoUser extends CDbMigration
{
	public function up()
	{
		 try {

            $db = Yii::app()->db;
            /* update */
            $checkIfColumnExists = $db->createCommand("SHOW COLUMNS FROM `user` LIKE 'photo' ");
            $result = $checkIfColumnExists->query();
			
			  if ($result->rowCount == 0) {
                $sql = 'ALTER TABLE  `user` ADD  `photo` BIGINT( 20 ) NOT NULL';
                $db->createCommand($sql)->execute();
			  }
			
		 return true;
        } catch (Exception $ex) {
            echo 'ERROR IN PATCH 170 PATCHER';
            return false;
        }	
	}

	public function down()
	{
		try {

            $db = Yii::app()->db;
            /* update */
            $checkIfColumnExists = $db->createCommand("SHOW COLUMNS FROM `user` LIKE 'photo' ");
            $result = $checkIfColumnExists->query();
			
			  if ($result->rowCount > 0) {
                $sql = 'ALTER TABLE `user` DROP `photo`';
                $db->createCommand($sql)->execute();
			  }
			
		 return true;
        } catch (Exception $ex) {
            echo 'ERROR IN PATCH 170 PATCHER';
            return false;
        }	
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}