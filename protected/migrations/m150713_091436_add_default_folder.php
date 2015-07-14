<?php

class m150713_091436_add_default_folder extends CDbMigration
{



	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn('folders', 'default', 'tinyint(2) DEFAULT 0');
	}

	public function safeDown()
	{
		$this->dropColumn('folders', 'default');
	}

}