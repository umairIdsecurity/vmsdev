<?php

class m150811_110859_alter_default_in_folder_table extends CDbMigration
{
 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->renameColumn("folders", "default", "is_default");
	}

	public function safeDown()
	{
	}
	 
}