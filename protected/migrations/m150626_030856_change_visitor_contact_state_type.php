<?php

class m150626_030856_change_visitor_contact_state_type extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->alterColumn('visitor','contact_state', 'VARCHAR(50) NULL');

	}

	public function safeDown()
	{
        $this->alterColumn("visitor","contact_state", "enum('ACT','NSW','NT','Qld','SA','Tas','Vic','WA') NULL");
	}

}