<?php

class m150527_053447_create_notification_table extends CDbMigration
{
	 // Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->createTable("notification", array(
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