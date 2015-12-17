<?php

class m151216_142100_clean_up_company_for_id_1 extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute("update company set tenant = null, tenant_agent = null, company_type = 1 where id = 1");
	}

	public function safeDown()
	{

	}
}