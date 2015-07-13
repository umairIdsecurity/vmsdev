<?php

class m150713_091227_add_ext_files extends CDbMigration
{



	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn('files', 'ext', 'VARCHAR(10) AFTER `file`');
	}

	public function safeDown()
	{
		$this->addColumn('files', 'ext', 'VARCHAR(10) AFTER `file`');
	}

}