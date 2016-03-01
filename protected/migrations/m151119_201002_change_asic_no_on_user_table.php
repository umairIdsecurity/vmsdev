<?php

class m151119_201002_change_asic_no_on_user_table extends CDbMigration
{
	public function safeUp()
	{
		$driverName = Yii::app()->db->driverName;
		$sqlServer = ['sqlsrv','mssql'] ;
		if(in_array($driverName,$sqlServer)){
			$name = DatabaseIndexHelper::getDefaultConstrainName('user','asic_no');
			if($name!=null) {
				$this->execute("ALTER TABLE [user] DROP CONSTRAINT $name");
			}
			$this->execute("ALTER TABLE [user] ALTER COLUMN asic_no VARCHAR(20)");

		} else {
			$this->alterColumn('user', 'asic_no', 'VARCHAR(20)');
		}

	}

	public function safeDown()
	{

	}

}