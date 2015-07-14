<?php

class m150713_044638_create_table_files extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('files', array(
			'id' => 'BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'folder_id' => 'BIGINT NOT NULL DEFAULT 0',
			'user_id' => 'BIGINT NOT NULL DEFAULT 0',
			'file' => 'varchar(255) NOT NULL',
			'uploaded' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			'size' => 'DOUBLE',
		));
		$this->addForeignKey('files_user_fk', 'files', 'user_id', 'user', 'id');
		$this->addForeignKey('files_folders_fk', 'files', 'folder_id', 'folders', 'id');
	}

	public function safeDown()
	{
		$this->dropForeignKey('files_user_fk', 'files');
		$this->dropForeignKey('files_folders_fk', 'files');
		$this->dropTable('files');
	}
}