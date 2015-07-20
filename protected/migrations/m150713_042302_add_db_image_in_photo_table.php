<?php

class m150713_042302_add_db_image_in_photo_table extends CDbMigration
{
	public function safeUp()
	{
		$this->addColumn('photo', 'db_image', 'MEDIUMBLOB NULL');
	}

	public function safeDown()
	{
		$this->dropColumn('photo', 'db_image');
	}
}