<?php

class m151011_071700_clean_up_tenant_agent_on_tenant_workstation extends CDbMigration
{
	public function safeUp()
	{
		// bug in tenant controller sets workstations tenant agent to user id
		$sql  = "UPDATE workstation ".
				"SET workstation.tenant_agent = null ".
				"WHERE EXISTS ( ".
					"SELECT * ".
					"FROM user_workstation ".
					"WHERE user_workstation.workstation = workstation.id ".
					"AND user_id = workstation.tenant_agent ".
    			")";

		$this->execute($sql);
	}

	public function safeDown()
	{

	}

}