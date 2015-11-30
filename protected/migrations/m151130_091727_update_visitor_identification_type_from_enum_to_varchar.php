<?php

class m151130_091727_update_visitor_identification_type_from_enum_to_varchar extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->alterColumn("visitor","identification_type","VARCHAR(150) DEFAULT NULL");
	}

	public function safeDown()
	{
	}
}