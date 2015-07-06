<?php

class m150706_092432_add_two_columns_in_reasons_table extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('reasons', 'created_by','bigint NULL');
        $this->addColumn('reasons', 'tenant','bigint NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('reasons', 'created_by','bigint NULL');
        $this->dropColumn('reasons', 'tenant','bigint NULL');
    }
}