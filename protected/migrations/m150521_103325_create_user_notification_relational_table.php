<?php

class m150521_103325_create_user_notification_relational_table extends CDbMigration
{
	
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
             $this->createTable("user_notification", array(
                'id'=>'pk',
                'user_id'=>'INTEGER',
                'notification_id'=>'INTEGER',
                'has_read'=>'INTEGER',
                'date_read' =>'DATE',
               
              ));
	}

	public function safeDown()
	{
	}
	
}