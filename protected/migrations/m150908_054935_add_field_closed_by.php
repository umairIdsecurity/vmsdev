<?php

class m150908_054935_add_field_closed_by extends CDbMigration
{


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
            $this->addColumn("visit", "closed_by", "BIGINT");
	}

	public function safeDown()
	{
	}

}