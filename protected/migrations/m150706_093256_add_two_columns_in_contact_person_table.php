<?php

class m150706_093256_add_two_columns_in_contact_person_table extends CDbMigration
{
	public function safeUp()
    {
        $this->addColumn('contact_person', 'created_by','bigint NULL');
        $this->addColumn('contact_person', 'tenant','bigint NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('contact_person', 'created_by','bigint NULL');
        $this->dropColumn('contact_person', 'tenant','bigint NULL');
    }
}