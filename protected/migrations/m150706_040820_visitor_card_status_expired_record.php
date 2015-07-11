<?php

class m150706_040820_visitor_card_status_expired_record extends CDbMigration {
	/*public function up()
	{
	}

	public function down()
	{
	echo "m150706_040820_visitor_card_status_expired_record does not support migration down.\n";
	return false;
	}*/

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp() {
		$sql = "";
		if ($this->dbConnection->driverName == 'sqlsrv') {
			$sql .= "Set IDENTITY_INSERT visitor_card_status ON ";
		}
		$sql .= "INSERT INTO visitor_card_status (id, name, profile_type) VALUES(" . Visitor::ASIC_EXPIRED . ", 'ASIC Expired', 'ASIC') ";

		if ($this->dbConnection->driverName == 'sqlsrv') {
			$sql .= "Set IDENTITY_INSERT visitor_card_status OFF";
		}
		$this->execute($sql);
	}

	public function safeDown() {
		$this->delete('visitor_card_status', "id = " . Visitor::ASIC_EXPIRED);
	}

}