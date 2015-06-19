<?php

class m150619_073834_add_inductions_three_columns_in_user_table extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('user', 'is_required_induction','BOOLEAN NULL');
        $this->addColumn('user', 'is_completed_induction','BOOLEAN NULL');
        $this->addColumn('user', 'induction_expiry','DATE NULL');
    }

    public function safeDown()
    {
        $this->addColumn('user', 'is_required_induction','BOOLEAN NULL');
        $this->addColumn('user', 'is_completed_induction','BOOLEAN NULL');
        $this->addColumn('user', 'induction_expiry','DATE NULL');
    }
}