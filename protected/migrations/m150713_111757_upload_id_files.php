<?php

class m150713_111757_upload_id_files extends CDbMigration
{


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn('files', 'uploader', 'BIGINT');
		$this->addForeignKey('files_user_fk1', 'files', 'uploader', 'user', 'id');
	}

	public function safeDown()
	{
		$this->dropForeignKey('files_user_fk1', 'files');
		$this->dropColumn('files', 'uploader');
	}

}