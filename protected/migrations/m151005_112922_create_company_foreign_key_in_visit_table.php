<?php

class m151005_112922_create_company_foreign_key_in_visit_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->addColumn("visit", "company", "BIGINT NULL");
		$this->addForeignKey('visit_company_foreign_key_constratint', 'visit', 'company', 'company', 'id');
	}

	public function safeDown()
	{
		$this->dropColumn("visit", "company");
	}
	
}