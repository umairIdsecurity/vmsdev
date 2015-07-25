<?php

class m150725_120100_add_module_to_visitor_type extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn('visitor_type', 'module','varchar(10)');
	}

	public function safeDown()
	{
		$this->dropColumn('visitor_type', 'module');
	}

}