<?php

class m150715_014814_alter_table_folders extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('folders', 'id', 'BIGINT NOT NULL AUTO_INCREMENT');
	}

	public function down()
	{
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}