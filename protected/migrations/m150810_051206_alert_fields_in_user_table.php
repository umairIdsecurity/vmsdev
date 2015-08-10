<?php

class m150810_051206_alert_fields_in_user_table extends CDbMigration
{
	 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
              $this->alterColumn("user", "photo", "BIGINT NULL");
              $this->alterColumn("user", "timezone_id", "BIGINT NULL");
              $this->alterColumn("user", "user_type", "BIGINT NULL");
              
              //Alter Photo field 
              if ($this->dbConnection->driverName == 'sqlsrv') {
			$this->alterColumn('photo', 'db_image', 'NVARCHAR(MAX) NULL');
		}
	}

	public function safeDown()
	{
            
	}
	 
}