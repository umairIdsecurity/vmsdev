<?php

class m150725_122222_add_visitor_type_cards_table extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('visitor_type_card_type', array(
			'visitor_type' => 'BIGINT NOT NULL',
			'card_type' => 'BIGINT NOT NULL',
			'tenant' => 'BIGINT NOT NULL',
			'tenant_agent' => 'BIGINT NULL',
		));

		$this->addForeignKey('visitor_type_card_type_visitor_type_fk', 'visitor_type_card_type', 'visitor_type', 'visitor_type', 'id');
		$this->addForeignKey('visitor_type_card_type_card_type_fk',  'visitor_type_card_type', 'card_type', 'card_type', 'id');
		$this->addForeignKey('visitor_type_card_type_tenant_fk',  'visitor_type_card_type', 'tenant', 'tenant', 'id');

	}

	public function safeDown()
	{
		$this->dropForeignKey('visitor_type_card_type_visitor_type_fk', 'visitor_type_card_type');
		$this->addForeignKey('visitor_type_card_type_card_type_fk', 'visitor_type_card_type');
		$this->addForeignKey('visitor_type_card_type_tenant_fk', 'visitor_type_card_type');
		$this->dropTable('visitor_type_card_type');

	}

}