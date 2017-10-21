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
            case Roles::ROLE_AIRPORT_OPERATOR:    
                $Criteria = new CDbCriteria();
                $Criteria->condition = "id =" . $session['workstation'] . " AND is_deleted = 0";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_STAFFMEMBER:
                if ($session['tenant'] == null) {
                    $tenantsearchby = "IS NULL";
                } else {
                    $tenantsearchby = "=" . $session['tenant'] . "";
                }

                if ($session['tenant_agent'] == null) {
                    //$tenantagentsearchby = "and tenant_agent IS NULL";
                    $tenantagentsearchby = "";
                } else {
                    $tenantagentsearchby = "and tenant_agent =" . $session['tenant_agent'] . "";
                }
                $Criteria = new CDbCriteria();
                $Criteria->condition = "tenant $tenantsearchby  $tenantagentsearchby AND is_deleted = 0";
                $workstationList = Workstation::model()->findAll($Criteria);
                break;

            case Roles::ROLE_ADMIN:
            case Roles::ROLE_ISSUING_BODY_ADMIN:
                /*$Criteria = new CDbCriteria();
                $Criteria->condition = "tenant = ".$session['tenant']." AND is_deleted = 0";
                $workstationList = Workstation::model()->findAll($Criteria);*/
                
                $workstationList = Yii::app()->db->createCommand()
                        ->select('w.id,w.name')
                        ->from('workstation w')
                        ->leftJoin('company c', 'c.id = w.tenant')
                        ->leftJoin('user u', 'u.company = c.id')
                        ->where("w.is_deleted = 0 and c.is_deleted = 0 and u.is_deleted = 0 and u.id ='".$session['id']."'")
                        ->order('w.id desc')
                        ->queryAll();

                break;

            case Roles::ROLE_AGENT_ADMIN:
                $Criteria = new CDbCriteria();
                $Criteria->condition = "tenant =" . $session['tenant'] . " and tenant_agent =" . $session['tenant_agent'] . " AND is_deleted = 0";
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