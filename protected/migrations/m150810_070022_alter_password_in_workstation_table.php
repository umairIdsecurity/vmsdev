<?php

class m150810_070022_alter_password_in_workstation_table extends CDbMigration
{
	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
              $this->alterColumn("workstation", "password", "VARCHAR(250) NULL");
	}

	public function safeDown()
	{
            
	}
}