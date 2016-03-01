<?php

class m150707_094839_add_is_under_18_to_visitor extends CDbMigration {

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp() {
		$this->addColumn('visitor', 'is_under_18', 'TINYINT DEFAULT 0');
		$this->addColumn('visitor', 'under_18_detail', 'varchar(255)');
	}

	public function safeDown() {
		$this->dropColumn('visitor', 'is_under_18');
		$this->dropColumn('visitor', 'under_18_detail');
	}

}