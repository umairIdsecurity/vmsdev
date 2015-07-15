<?php

class m150715_183320_alter_table_files extends CDbMigration
{



	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn('files', 'name', 'VARCHAR(255)');
	}

	public function safeDown()
	{
		$this->dropColumn('files', 'name');
	}

}