<?php

class Utils
{
    public static function populateWorkstation()
    {
        $session = new CHttpSession;

        switch ($session['role']) {
            case Roles::ROLE_SUPERADMIN:
                $workstationList = Workstation::model()->findAll();
                break;

            case Roles::ROLE_OPERATOR:
            case Roles::ROLE_AGENT_OPERATOR:
                $Criteria = new CDbCriteria();
                $Criteria->condition = "id ='" . $session['workstation'] . "'";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_STAFFMEMBER:
                if ($session['tenant'] == null) {
                    $tenantsearchby = "IS NULL";
                } else {
                    $tenantsearchby = "='" . $session['tenant'] . "'";
                }

                if ($session['tenant_agent'] == null) {
                    //$tenantagentsearchby = "and tenant_agent IS NULL";
                    $tenantagentsearchby = "";
                } else {
                    $tenantagentsearchby = "and tenant_agent ='" . $session['tenant_agent'] . "'";
                }
                $Criteria = new CDbCriteria();
                $Criteria->condition = "tenant $tenantsearchby  $tenantagentsearchby";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_ADMIN:
                $Criteria = new CDbCriteria();
                $Criteria->condition = "tenant ='" . $session['tenant'] . "'";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_AGENT_ADMIN:
                $Criteria = new CDbCriteria();
                $Criteria->condition = "tenant ='" . $session['tenant'] . "' and tenant_agent ='" . $session['tenant_agent'] . "'";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;
        }

        return $workstationList;
    }


}