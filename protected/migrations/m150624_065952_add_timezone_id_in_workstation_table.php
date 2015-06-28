<?php

class m150624_065952_add_timezone_id_in_workstation_table extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('workstation', 'timezone_id','bigint NOT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('workstation', 'timezone_id');
    }
}