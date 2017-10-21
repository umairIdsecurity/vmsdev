<?php

class m150625_105353_create_table_company_type extends CDbMigration
{
	public function safeUp()
	{
        $this->dropForeignKey('card_generated_ibfk_4', 'card_generated');
        $this->dropForeignKey('company_ibfk_3', 'company');
        $this->dropForeignKey('user_ibfk_6', 'user');
        $this->dropForeignKey('visit_ibfk_9', 'visit');
        $this->dropForeignKey('visit_reason_ibfk_2', 'visit_reason');
        $this->dropForeignKey('visitor_ibfk_4', 'visitor');

        $this->createTable("company_type", array(
            'id' => 'pk',
            'name' => 'VARCHAR(50) NOT NULL',
            'created_by' => 'BIGINT NULL',
        ));

        $this->insert('company_type', array(
            'name' => 'Tenant'
        ));
        $this->insert('company_type', array(
            'name' => 'Tenant Agent'
        ));
        $this->insert('company_type', array(
            'name' => 'Visitor'
        ));

        $this->addColumn('company', 'company_type', 'BIGINT NULL AFTER card_count');

	}

	public function safeDown()
	{
        $this->dropTable("company_type");
	}

}