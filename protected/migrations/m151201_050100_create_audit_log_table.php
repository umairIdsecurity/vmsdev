<?php

class m151201_050100_create_audit_log_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$table = Yii::app()->db->schema->getTable('audit_log');
		if(!isset($table)) {
			$this->createTable('audit_log', array(
					'id' => 'pk',
					'action_datetime' => 'TIMESTAMP',
					'action' => 'varchar(100)',
					'detail' => 'text',
					'user_email_address' => 'varchar(50)',
					'ip_address' => 'varchar(25)',
					'tenant' => 'bigint',
					'tenant_agent' => 'bigint'
			));
		}
	}

	public function safeDown()
	{
		$this->dropTable('audit_log');
	}
}