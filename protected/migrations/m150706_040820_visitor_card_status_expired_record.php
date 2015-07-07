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
		$this->insert('visitor_card_status', array(
			'id'           => Visitor::ASIC_EXPIRED,
			'name'         => 'ASIC Expired',
			'profile_type' => 'ASIC'
		));
	}

	public function safeDown() {
		$this->delete('visitor_card_status', "id = " . Visitor::ASIC_EXPIRED);
	}

}