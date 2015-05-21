<?php

class m150521_103247_create_notifications extends CDbMigration
{
// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->createTable("notifications", array(
                'id'=>'pk',
                'subject'=>'VARCHAR(250) NOT NULL',
                'message'=>'TEXT NOT NULL',
                'created_by'=>'INTEGER',
                'date_created' =>'DATE',
                'role_id'=>'INTEGER',
                'notification_type'=>'VARCHAR(100)',
              ));
	}

	public function safeDown()
	{
            $this->dropTable("notifications");
	}
}