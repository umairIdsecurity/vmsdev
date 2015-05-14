<?php

class m150514_093710_YiiSession extends CDbMigration
{
	public function safeUp()
	{
            $this->createTable('YiiSession', array(
            'id' => 'string',
            'expire' => 'integer', 
            'data' => 'BLOB',
            ));
            
	}

	public function down()
	{
		echo "m150514_093710_YiiSession does not support migration down.\n";
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