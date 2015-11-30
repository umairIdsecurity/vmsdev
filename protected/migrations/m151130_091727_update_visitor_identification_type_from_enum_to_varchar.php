<?php

class m151130_091727_update_visitor_identification_type_from_enum_to_varchar extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->alterColumn("visitor", "identification_type", "enum('PASSPORT','DRIVERS_LICENSE','PROOF_OF_AGE','FIRE_ARMS_LICENCE','WORKING_WITH_CHILDREN_CARD','APPROVED_MANAGER','IMMICARD','HIGH_RISK_WORK_LICENCE','SENIORS_CARD') DEFAULT NULL");
	}

	public function safeDown()
	{
	}
}