<?php

class m151012_093244_add_is_listed_in_visit_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		  $this->addColumn('visit','is_listed','TINYINT NOT NULL DEFAULT "1"');
	}

	public function safeDown()
	{
		$this->dropColumn('visit','is_listed');
	}
	
}