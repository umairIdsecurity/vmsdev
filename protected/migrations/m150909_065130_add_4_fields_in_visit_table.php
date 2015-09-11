<?php

class m150909_065130_add_4_fields_in_visit_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->addColumn("visit", "visit_prereg_status", "VARCHAR(20) DEFAULT 'Pending'");
        $this->addColumn("visit", "asic_declaration", "TINYINT DEFAULT 0");
        $this->addColumn("visit", "asic_verification", "TINYINT DEFAULT 0");
        $this->addColumn("visit", "identification_verification", "TINYINT DEFAULT 0");
	}

	public function safeDown()
	{
		$this->dropColumn("visit", "visit_prereg_status");
		$this->dropColumn("visit", "asic_declaration");
		$this->dropColumn("visit", "asic_verification");
		$this->dropColumn("visit", "identification_verification");
	}
}