<?php

class m151125_053608_create_audit_log_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('audit_log', array(
			'id' => 'pk',
			'action_datetime' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
			'action' => 'varchar(100)',
			'detail' => 'text',
			'user_email_address' => 'varchar(50)',
			'ip_address' => 'varchar(25)',
			'tenant' => 'bigint',
			'tenant_agent' => 'bigint'
		));
	}

	public function safeDown()
	{
		$this->dropTable('audit_log');
	}
}