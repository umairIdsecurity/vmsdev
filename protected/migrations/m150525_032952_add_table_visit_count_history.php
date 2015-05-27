<?php

class m150525_032952_add_table_visit_count_history extends CDbMigration
{
	public function up()
	{
        $this->createTable("reset_history", array(
            'id'         =>'pk',
            'visitor_id' =>'BIGINT(20) NOT NULL',
            'reset_time' =>'DATETIME  NOT NULL',
            'reason'     =>'VARCHAR(250) NOT NULL',
        ));
        $this->addColumn('visit','reset_id','int(11)');
        $this->addColumn('visit','negate_reason','varchar(250)');
        $this->dropColumn('visitor','visit_count');
        $this->insert('visit_status',[
            'name' => 'Negate'
        ]);
	}

	public function down()
	{
		$this->dropTable("visit_count_reset_history");
        $this->dropColumn('visit','reset_id');
        $this->dropColumn('visit','negate_reason');
        $this->addColumn('visitor','visit_count','int(10)');

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