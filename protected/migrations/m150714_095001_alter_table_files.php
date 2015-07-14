<?php

class m150714_095001_alter_table_files extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('files', 'id', 'BIGINT NOT NULL AUTO_INCREMENT');
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