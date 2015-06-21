<?php

class m150519_020527_access_tokens extends CDbMigration
{
	public function safeUp()
	{
             $this->createTable('access_tokens', array(
            'ID' => 'pk',
            'USER_ID' => 'INTEGER (11) NOT NULL',     
            'ACCESS_TOKEN' => 'VARCHAR (255) NOT NULL',
            'EXPIRY' => 'DATETIME DEFAULT NULL',
            'CLIENT_ID' => 'INTEGER (11) NOT NULL',
            'CREATED'=>'DATETIME NOT NULL',
            'MODIFIED'=>'DATETIME NOT NULL',     
        ));
	}

	public function safeDown()
	{
	  $this->execute("
            DROP TABLE IF EXISTS access_tokens;
            ");
	}

	 
}