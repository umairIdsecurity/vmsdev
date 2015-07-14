<?php

class m150714_013738_alter_table_files extends CDbMigration
{

	public function up()
	{
		$this->alterColumn('files','id','BIGINT(19)');
		$this->alterColumn('files','folder_id','BIGINT(19)');
		$this->alterColumn('files','user_id','BIGINT(19)');
	}

	public function down()
	{
		return false;
	}

	/*// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{

	}

	public function safeDown()
	{

	}*/

}