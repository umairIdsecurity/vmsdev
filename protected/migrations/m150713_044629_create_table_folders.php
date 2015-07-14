<?php

class m150713_044629_create_table_folders extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('folders', array(
			'id' => 'BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'parent_id' => 'BIGINT NOT NULL DEFAULT 0',
			'user_id' => 'BIGINT NOT NULL DEFAULT 0',
			'name' => 'varchar(255) NOT NULL',
			'date_created' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
		));
		$this->addForeignKey('folders_user_fk', 'folders', 'user_id', 'user', 'id');
	}

	public function safeDown()
	{
		$this->dropForeignKey('folders_user_fk', 'folders');
		$this->dropTable('folders');
	}
}