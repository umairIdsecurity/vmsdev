<?php

class m150901_105805_add_field_in_visit_table extends CDbMigration
{
	 
 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->addColumn("visit", "visit_closed_date", "DATETIME");
	}

	public function safeDown()
	{
	}
	 
}