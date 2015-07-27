<?php

class m150726_121800_add_module_to_visit_reason extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn("visit_reason","module","varchar(4)");

	}

	public function safeDown()
	{
		$this->dropColumn("visit_reason","module");

	}

}