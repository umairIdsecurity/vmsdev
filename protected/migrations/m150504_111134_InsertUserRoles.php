<?php

class m150504_111134_InsertUserRoles extends CDbMigration
{
	public function safeUp()
	{
        $this->insert('roles', array(
            'id' => Roles::ROLE_ISSUING_BODY_ADMIN,
            'name'=>'Issuing Body Administrator'
        ));

        $this->insert('roles', array(
            'id'=> Roles::ROLE_AIRPORT_OPERATOR,
            'name'=>'Airport Operator'
        ));

        $this->insert('roles', array(
            'id' => Roles::ROLE_AGENT_AIRPORT_ADMIN,
            'name'=>'Agent Airport Administrator'
        ));

        $this->insert('roles', array(
            'id' => Roles::ROLE_AGENT_AIRPORT_OPERATOR,
            'name'=>'Agent Airport Operator'
        ));

    }

	public function safeDown()
	{
        $this->delete('roles', "`id` = ".Roles::ROLE_ISSUING_BODY_ADMIN);
        $this->delete('roles', "`id` = ".Roles::ROLE_AIRPORT_OPERATOR);
        $this->delete('roles', "`id` = ".Roles::ROLE_AGENT_AIRPORT_ADMIN);
        $this->delete('roles', "`id` = ".Roles::ROLE_AGENT_AIRPORT_OPERATOR);
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