<?php

class CHelper {

    /**
    * returns true if creating or updating AVMS user
    */
    public static function is_managing_avms_user()
    {
        $avms_roles_array = array_merge(Roles::get_avms_roles(), array('avms') );

        return (in_array(Yii::app()->request->getParam('role'),$avms_roles_array));
    }

    public static function is_cvms_users_requested()
    {
        $vms = Yii::app()->request->getParam('vms');
        if (!empty($vms)){
            if ($vms == 'cvms'){
                return true;
            }
        }
        return false;
    }

    public static function is_avms_users_requested()
    {
        $vms = Yii::app()->request->getParam('vms');
        if (!empty($vms)){
            if ($vms == 'avms'){
                return true;
            }
        }
        return false;
    }

    public static function get_months()
    {
        return ['Jan' => 1, 'Feb'=>2, 'Mar'=>3,'Apr'=>4,'May'=>5,'Jun'=>6,'Jul'=>7, 'Aug'=>8,'Sept'=>9,'Oct'=>10,'Nov'=>11, 'Dec'=>12];
    }

    public static function is_accessing_avms_features(){
        return self::is_managing_avms_user() || self::is_avms_users_requested();
    }
    
    /**
     * Check if someone Adding AVMS user
     * 
     * @return boolean
     */
    public static function is_add_avms_user () {
        
        // Get current Adding Role from URL
        $role = Yii::app()->request->getParam('role', 0);
        // Match Current Role in AVMS Users
        if( in_array($role, Roles::get_avms_roles()) || $role == "avms") 
            return true;
        else
            return false;
    }
}