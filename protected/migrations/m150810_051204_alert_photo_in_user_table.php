<?php

class m150810_051204_alert_photo_in_user_table extends CDbMigration
{
	 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
//            $table = Yii::app()->db->schema->getTable('user');
//            if(!isset($table)){
//                 $this->execute('ALTER TABLE user ALETER COLUMN photo BIGINT NULL');
//            }
              $this->alterColumn("user", "photo", "BIGINT NULL");
	}

	public function safeDown()
	{
            
	}
	 
}