<?php

class m150707_104743_add_coloumn_visitor extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn('visitor', 'key_string', 'TEXT');
	}

	public function safeDown()
	{
		$this->dropColumn('visitor', 'key_string');
	}
}