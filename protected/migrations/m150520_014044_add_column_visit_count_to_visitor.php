<?php

class m150520_014044_add_column_visit_count_to_visitor extends CDbMigration
{
    public function up()
    {
        $this->addColumn('visitor', 'visit_count', 'int(10) NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('visitor', 'visit_count');
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}