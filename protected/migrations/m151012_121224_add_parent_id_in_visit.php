<?php

class m151012_121224_add_parent_id_in_visit extends CDbMigration
{
	 
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->addColumn("visit", "parent_id", "BIGINT");
	}

	public function safeDown()
	{
	}
	 
}