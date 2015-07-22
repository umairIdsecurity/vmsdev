<?php

class m150720_095822_create_table_system extends CDbMigration
{
	/*public function up()
	{
	}

	public function down()
	{
		echo "m150720_095822_create_table_system does not support migration down.\n";
		return false;
	}*/


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('system', array(
			'id' => 'pk',
			'key_name' => 'varchar(25)',
			'key_value' => 'text',

		));
	}

	public function safeDown()
	{
		$this->dropTable('system');
	}

}