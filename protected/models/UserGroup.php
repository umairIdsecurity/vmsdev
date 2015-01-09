<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserGroup
 *
 * @author Jeremiah
 */
class UserGroup {

    //put your code here
    public static $USERGROUP_ARRAY_ADMINISTRATION = array(Roles::ROLE_ADMIN, Roles::ROLE_SUPERADMIN, Roles::ROLE_AGENT_ADMIN);
    public static $USERGROUP_ARRAY_SUPERADMIN = array(Roles::ROLE_SUPERADMIN);
    public static $USERGROUP_ARRAY_STAFFMEMBER = array(Roles::ROLE_STAFFMEMBER);

    const USERGROUP_SUPERADMIN = "superadmin";
    const USERGROUP_ADMINISTRATION = "administration";
    const USERGROUP_STAFFMEMBER = "staffmember";

    public static function isUserAMemberOfThisGroup($user, $user_group) {

        switch ($user_group) {
            case UserGroup::USERGROUP_ADMINISTRATION:

                if (in_array($user->role, UserGroup::$USERGROUP_ARRAY_ADMINISTRATION)) {
                    return true;
                }
                break;

            case UserGroup::USERGROUP_SUPERADMIN:
                if (in_array($user->role, UserGroup::$USERGROUP_ARRAY_SUPERADMIN)) {
                    return true;
                }
                break;

            case UserGroup::USERGROUP_STAFFMEMBER:
                if (in_array($user->role, UserGroup::$USERGROUP_ARRAY_STAFFMEMBER)) {
                    return true;
                }
                break;

            default:
                return false;
        }
    }

}
