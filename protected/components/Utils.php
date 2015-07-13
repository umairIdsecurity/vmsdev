<?php

class Utils
{
    public static function populateWorkstation()
    {
        $session = new CHttpSession;

        switch ($session['role']) {
            case Roles::ROLE_SUPERADMIN:
                $Criteria = new CDbCriteria();
                $Criteria->condition = "is_deleted = 0";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_OPERATOR:
            case Roles::ROLE_AGENT_OPERATOR:
                $Criteria = new CDbCriteria();
                $Criteria->condition = "id ='" . $session['workstation'] . "' AND is_deleted = 0";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_STAFFMEMBER:
                if ($session['company'] == null) {
                    $tenantsearchby = "IS NULL";
                } else {
                    $tenantsearchby = "='" . $session['company'] . "'";
                }

                if ($session['tenant_agent'] == null) {
                    //$tenantagentsearchby = "and tenant_agent IS NULL";
                    $tenantagentsearchby = "";
                } else {
                    $tenantagentsearchby = "and tenant_agent ='" . $session['tenant_agent'] . "'";
                }
                $Criteria = new CDbCriteria();
                $Criteria->condition = "tenant $tenantsearchby  $tenantagentsearchby AND is_deleted = 0";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_ADMIN:
                $Criteria = new CDbCriteria();
                $Criteria->condition = "tenant = ".$session['company']." AND is_deleted = 0";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_AGENT_ADMIN:
                $Criteria = new CDbCriteria();
                $Criteria->condition = "tenant ='" . $session['company'] . "' and tenant_agent ='" . $session['tenant_agent'] . "' AND is_deleted = 0";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;
            default :
                $Criteria = new CDbCriteria();
                $Criteria->condition = "is_deleted = 0";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;
        }

        return $workstationList;
    }

    public static function RemoveDir($path)
    {
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));
            foreach ($files as $file) {
                self::RemoveDir(realpath($path) . '/' . $file);
            }

            return rmdir($path);
        } else {
            if (is_file($path) === true) {
                return unlink($path);
            }
        }

        return false;
    }

}