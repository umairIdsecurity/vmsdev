<?php

class m151126_053538_update_action_datetime_col_audit_log_to_datetime extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->dropColumn("audit_log","action_datetime");
		$this->addColumn("audit_log","action_datetime_new","varchar(150) NULL");
	}

	public function safeDown()
	{
		$this->dropColumn("audit_log","action_datetime_new");
	}
}