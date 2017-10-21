<?php

class UserRoleTenantAgentValidator extends CValidator
{

    private static $processed = false;

    protected function validateAttribute($object,$attribute)
    {
        if($object->tenant_agent == null && in_array($object->role,array(
                Roles::ROLE_AGENT_AIRPORT_ADMIN,
                Roles::ROLE_AGENT_OPERATOR,
                Roles::ROLE_AGENT_ADMIN,
                Roles::ROLE_AGENT_AIRPORT_OPERATOR
            ))){

            $object->addError( $attribute, 'Tenant agent is required for this user role.');

        }

    }


    public function clientValidateAttribute($object,$attribute)
    {
        $str = "if(['"
                    .Roles::ROLE_AGENT_AIRPORT_OPERATOR ."','"
                    .Roles::ROLE_AGENT_ADMIN ."','"
                    .Roles::ROLE_AGENT_OPERATOR ."','"
                    .Roles::ROLE_AGENT_AIRPORT_ADMIN ."']"
                    .".indexOf($('#User_role').val())!=-1 &&  $('#User_tenant_agent').val()==''){\n"
                        ."messages.push('Please complete tenant agent');\n"
                ."};\n";

        return $str;

    }

}