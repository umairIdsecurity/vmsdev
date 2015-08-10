<?php

class m150810_051205_alert_fields_in_user_table extends CDbMigration
{
	 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
              $this->alterColumn("user", "photo", "BIGINT NULL");
              $this->alterColumn("user", "timezone_id", "BIGINT NULL");
              $this->alterColumn("user", "user_type", "BIGINT NULL");
	}

	public function safeDown()
	{
            
	}
	 
}