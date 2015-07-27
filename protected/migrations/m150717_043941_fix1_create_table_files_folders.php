<?php

class m150717_043941_fix1_create_table_files_folders extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		if (Yii::app()->db->schema->getTable('files',true)!==null) {
			/*$this->dropForeignKey('files_user_fk', 'files');
			$this->dropForeignKey('files_folders_fk', 'files');*/
			$this->dropTable('files');
		}
		if (Yii::app()->db->schema->getTable('folders',true)!==null) {
			/*$this->dropForeignKey('folders_user_fk', 'folders');*/
			$this->dropTable('folders');
		}
		$this->createTable('folders', array(
			'id' => 'pk',
			'parent_id' => 'INTEGER',
			'user_id' => 'BIGINT',
			'default' => 'TINYINT',
			'name' => 'VARCHAR(255) NOT NULL',
			'date_created' => 'DATETIME',
		));
		$this->addForeignKey('folders_user_fk', 'folders', 'user_id', 'user', 'id');

		if ($this->dbConnection->driverName == 'sqlsrv') {
			$this->createTable('files', array(
				'id' => 'pk',
				'folder_id' => 'INTEGER',
				'user_id' => 'BIGINT',
				'file' => 'VARCHAR(255) NOT NULL',
				'uploaded' => 'DATETIME',
				'size' => 'FLOAT',
				'ext' => 'VARCHAR(20)',
				'uploader' => 'BIGINT',
				'name' => 'VARCHAR(255)',
			));
		} else {
			$this->createTable('files', array(
				'id' => 'pk',
				'folder_id' => 'INTEGER',
				'user_id' => 'BIGINT',
				'file' => 'VARCHAR(255) NOT NULL',
				'uploaded' => 'DATETIME',
				'size' => 'DOUBLE',
				'ext' => 'VARCHAR(20)',
				'uploader' => 'BIGINT',
				'name' => 'VARCHAR(255)',
			));
		}

		

		$this->addForeignKey('files_user_fk', 'files', 'user_id', 'user', 'id');
		$this->addForeignKey('files_folders_fk', 'files', 'folder_id', 'folders','id');

		//Delete record in tbl_migrate
		$this->delete('tbl_migration','version in (\'m150715_183320_alter_table_files\',
												 \'m150715_014814_alter_table_folders\',
												 \'m150714_095001_alter_table_files\',
												 \'m150714_013738_alter_table_files\',
												 \'m150713_111757_upload_id_files\',
												 \'m150713_091436_add_default_folder\',
												 \'m150713_091227_add_ext_files\',
												 \'m150713_044638_create_table_files\',
												 \'m150713_044629_create_table_folders\',
												 \'m150713_033006_create_table_files\',
												 \'m150713_032156_create_table_folders\')');

	}

	public function safeDown()
	{
		return false;
	}

}