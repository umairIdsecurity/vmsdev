<?php

class m150812_044857_alter_user_field_in_user_workstation extends CDbMigration
{
	 
// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->renameColumn("user_workstation", "user", "user_id");
	}

	public function safeDown()
	{
	}
	 
}