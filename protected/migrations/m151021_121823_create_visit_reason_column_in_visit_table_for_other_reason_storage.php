<?php

class m151021_121823_create_visit_reason_column_in_visit_table_for_other_reason_storage extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn('visit','visit_reason','VARCHAR(30) DEFAULT NULL');
	}

	public function safeDown()
	{
		$this->dropColumn('visit','visit_reason');
	}
	
}