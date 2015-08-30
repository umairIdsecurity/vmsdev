<?php

class m150825_085642_change_help_desk_group_table extends CDbMigration
{
	public function safeUp()
	{
		$col = $this->dbConnection->schema->getTable('helpdesk_group')->getColumn('is_default_value');
		if(!isset($col)) {
			$this->addColumn('helpdesk_group', 'is_default_value', 'BIT');
		}

		//$this->createTable('helpdesk_group_web_preregistration', array(
		//	'helpdesk_group' => 'BIGINT NOT NULL',
		//	'web_preregistration' => 'VARCHAR(20)',
		//));
		//$this->addForeignKey('helpdesk_group_web_preregistration_helpdesk_group_fk', 'helpdesk_group_web_preregistration', 'helpdesk_group', 'helpdesk_group', 'id');

		$table = $this->dbConnection->schema->getTable('helpdesk_group_user_role');
		if(!isset($table)) {
			$this->createTable('helpdesk_group_user_role', array(
				'helpdesk_group' => 'BIGINT NOT NULL',
				'role' => 'BIGINT NOT NULL',
			));
		}

		//$this->addForeignKey('helpdesk_group_user_role_helpdesk_group_fk', 'helpdesk_group_user_role', 'helpdesk_group', 'helpdesk_group', 'id');
		//$key = ForeignKeyHelper::getForeignKeyName('helpdesk_group_user_role','role','roles','id');
		//if(!isset($key)) {
		//	$this->addForeignKey('helpdesk_group_user_role_role_fk', 'helpdesk_group_user_role', 'role', 'roles', 'id');
		//}
	}

	public function safeDown()
	{
		//$this->dropForeignKey('helpdesk_group_user_role_helpdesk_group_fk', 'helpdesk_group_user_role');
		//$this->dropForeignKey('helpdesk_group_user_role_role_fk', 'helpdesk_group_user_role');
		$this->dropTable('helpdesk_group_user_role');
		//$this->dropForeignKey('helpdesk_group_web_preregistration_helpdesk_group_fk', 'helpdesk_group_web_preregistration');
		//$this->dropTable('helpdesk_group_web_preregistration');
		$this->dropColumn("helpdesk_group","is_default_value");
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}