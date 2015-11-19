<?php

class m171115_204200_change_asic_no_on_user_table extends CDbMigration
{
	public function safeUp()
	{
		$driverName = Yii::app()->db->driverName;
		$sqlServer = ['sqlsrv','mssql'] ;
		if(in_array($driverName,$sqlServer)){
			$name = DatabaseIndexHelper::getDefaultConstrainName('user','asic_no');
			$this.$this->execute("ALTER TABLE [user] DROP CONSTRAINT $name")	;
		}

		$this->alterColumn('user', 'asic_no', 'VARCHAR(20)');

	}

	public function safeDown()
	{

	}

}