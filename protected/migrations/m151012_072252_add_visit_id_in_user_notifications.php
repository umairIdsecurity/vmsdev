<?php

class m151012_072252_add_visit_id_in_user_notifications extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->addColumn("user_notification", "verify_visit_id", "INT(11) NULL");
	}

	public function safeDown()
	{
		$this->dropColumn("user_notification", "verify_visit_id");
	}
	
}