<?php

class m150714_013748_alter_table_folders extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('folders','id','BIGINT(19)');
		$this->alterColumn('folders','parent_id','BIGINT(19)');
		$this->alterColumn('folders','user_id','BIGINT(19)');
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