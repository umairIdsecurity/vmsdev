<?php

class m150424_181334_issue_171_addUserPhoto extends CDbMigration
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
            echo 'ERROR IN PATCH 171 PATCHER';
            return false;
        }	
			
	}

	public function down()
	{
		 $table = 'user';
		  $column = 'photo';
		$this->dropColumn($table, $column);
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