<?php

class m150701_085132_add_column_asic_escort_visit extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->addColumn('visit','asic_escort','bigint NULL');
	}

	public function safeDown()
	{
        $this->dropColumn('visit', 'asic_escort');
	}

}