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
    public static $USERGROUP_ARRAY_ADMINISTRATION = array(Roles::ROLE_ADMIN, Roles::ROLE_SUPERADMIN, Roles::ROLE_AGENT_ADMIN, Roles::ROLE_AGENT_AIRPORT_ADMIN, Roles::ROLE_ISSUING_BODY_ADMIN);
    public static $USERGROUP_ARRAY_SUPERADMIN_DASHBOARD = array(Roles::ROLE_SUPERADMIN, Roles::ROLE_OPERATOR, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_AGENT_AIRPORT_ADMIN);
    public static $USERGROUP_ARRAY_ADMINISTRATION_DASHBOARD = array(Roles::ROLE_ADMIN, Roles::ROLE_AGENT_ADMIN, Roles::ROLE_OPERATOR, Roles::ROLE_AIRPORT_OPERATOR, Roles::ROLE_AGENT_OPERATOR, Roles::ROLE_AGENT_AIRPORT_ADMIN,Roles::ROLE_ISSUING_BODY_ADMIN,Roles::ROLE_AGENT_AIRPORT_OPERATOR);
    public static $USERGROUP_ARRAY_SUPERADMIN = array(Roles::ROLE_SUPERADMIN);
    public static $USERGROUP_ARRAY_STAFFMEMBER = array(Roles::ROLE_STAFFMEMBER);
    public static $USERGROUP_ARRAY_OPERATOR = array(Roles::ROLE_OPERATOR, Roles::ROLE_AGENT_OPERATOR,  Roles::ROLE_AIRPORT_OPERATOR, Roles::ROLE_AGENT_AIRPORT_OPERATOR);

    const USERGROUP_SUPERADMIN = "superadmin";
    const USERGROUP_SUPERADMIN_DASHBOARD = "operator";
    const USERGROUP_ADMINISTRATION_DASHBOARD = "operator1";
    const USERGROUP_ADMINISTRATION = "administration";
    const USERGROUP_STAFFMEMBER = "staffmember";

    public static function isUserAMemberOfThisGroup($user, $user_group) {

        // ask user to log in
        if (!isset($user->role)) {
            Yii::app()->controller->redirect(Yii::app()->createUrl("site/login"));
        }
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

            case UserGroup::USERGROUP_SUPERADMIN_DASHBOARD:
                if (in_array($user->role, UserGroup::$USERGROUP_ARRAY_SUPERADMIN_DASHBOARD)) {
                    return true;
                }
                break;

            case UserGroup::USERGROUP_ADMINISTRATION_DASHBOARD:
                if (in_array($user->role, UserGroup::$USERGROUP_ARRAY_ADMINISTRATION_DASHBOARD)) {
                    return true;
                }
                break;

            default:
                return false;
        }
    }

}
