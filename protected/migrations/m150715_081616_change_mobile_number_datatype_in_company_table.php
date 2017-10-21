<?php

class m150715_081616_change_mobile_number_datatype_in_company_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		if ($this->dbConnection->driverName == 'sqlsrv') {
			$sql = "ALTER TABLE company DROP CONSTRAINT [DF__company__mobile___36B12243];";
			$sql .= "ALTER TABLE company ALTER COLUMN mobile_number VARCHAR(50) NULL";
			$this->execute($sql);
		} else {
			$this->alterColumn('company', 'mobile_number', 'varchar(50) NULL');
		}
	}

	public function safeDown()
	{
		$this->alterColumn('company', 'mobile_number', 'INT(20) NULL');
	}
}