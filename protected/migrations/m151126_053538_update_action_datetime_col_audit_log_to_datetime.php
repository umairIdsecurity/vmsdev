<?php

class m151126_053538_update_action_datetime_col_audit_log_to_datetime extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->alterColumn("audit_log","action_datetime","DATETIME");
	}

	public function safeDown()
	{
		$this->alterColumn("audit_log","action_datetime","TIMESTAMP");
	}
}