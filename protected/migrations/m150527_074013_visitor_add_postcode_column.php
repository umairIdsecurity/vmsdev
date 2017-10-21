<?php

class m150527_074013_visitor_add_postcode_column extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('visitor', 'contact_postcode', "varchar(10) DEFAULT NULL");
    }

    public function safeDown()
    {
        $this->dropColumn('visitor', 'contact_postcode');
    }
}