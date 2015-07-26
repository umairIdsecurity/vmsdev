<?php

class CHelper
{

    /**
     * returns true if creating or updating AVMS user
     */
    public static function is_managing_avms_user()
    {
        $avms_roles_array = array_merge(Roles::get_avms_roles(), array('avms'));

        return (in_array(Yii::app()->request->getParam('role'), $avms_roles_array));
    }

    public static function is_cvms_users_requested()
    {
        $vms = Yii::app()->request->getParam('vms');
        if (!empty($vms)) {
            if ($vms == 'cvms') {
                return true;
            }
        }
        return false;
    }

    public static function is_avms_users_requested()
    {
        $vms = Yii::app()->request->getParam('vms');
        if (!empty($vms)) {
            if ($vms == 'avms') {
                return true;
            }
        }
        return false;
    }

    public static function get_months()
    {
        return ['Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4, 'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8, 'Sept' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12];
    }

    public static function is_accessing_avms_features()
    {
        return self::is_managing_avms_user() || self::is_avms_users_requested();
    }

    /**
     * Check if someone Adding AVMS user
     *
     * @return boolean
     */
    public static function is_add_avms_user()
    {

        // Get current Adding Role from URL
        $role = Yii::app()->request->getParam('role', 0);
        // Match Current Role in AVMS Users
        if (in_array($role, Roles::get_avms_roles()) || $role == "avms")
            return true;
        else
            return false;
    }

    /**
     * Get Users Unread Notification list
     *
     */
    public static function get_unread_notifications()
    {

        if(isset(Yii::app()->user->id) && !empty(Yii::app()->user->id)){
            $notifications = Notification::model()->with('user_notification')->findAll(
            array(
                "condition" => "user_notification.has_read != 1 AND user_notification.user_id = " . Yii::app()->user->id,
                "order" => "user_notification.notification_id DESC"
            ));
            return $notifications;
        }else{
            return false;
        }

        
    }

    /**
     * Highlight Add CVMS/AVMS Link in Left navigation
     *
     * @param integer Role ID of the seleted Item
     * @return string CSS for Hightlight.
     */
    public static function is_selected_item($role_id)
    {
        // Role of the newly User
        if ($role_id == Yii::app()->request->getParam('role')) {
            $session = new CHttpSession;
            $company = Company::model()->findByPk($session['company']);
            if (isset($company) && !empty($company)) {
                $companyLafPreferences = CompanyLafPreferences::model()->findByPk($company->company_laf_preferences);
            }
            if (isset($companyLafPreferences))
                echo 'style = "color: ' . $companyLafPreferences->sidemenu_font_color . ' !important;"';
            else
                echo "";
        }
    }

    public static function is_avms_visitor()
    {
        $vms = Yii::app()->request->getParam('vms');
        if (!empty($vms)){
            if ($vms == 'avms'){
                return true;
            }
        }
        return false;
    }
    
    /**
     * Send Access code for Tenant
     * 1= AVMS, 2= CVMS, 3= Both
     * @return int code of allowed module
     */
    public static function get_module_access($post) {
        $access = NULL;
        if( isset($post['module_access_avms']))
            $access = 1; // 1= AVMS
        if( isset($post['module_access_cvms']))
            $access = 2; // 2= CVMS
        if(isset($post['module_access_avms']) && isset($post['module_access_cvms']))
            $access = 3; // 3= For both AVMS and CVMS
        
        return $access;            
    }
    
    /**
     * Check and Return allowed module to view by a tenant. AVMS or CVMS or Both
     * 
     * @return string module
     */
    public static function get_allowed_module() {
        
         $session = new CHttpSession;
         if( isset($session['module_allowed_to_view']) && !is_null($session['module_allowed_to_view']))
             
             return $session['module_allowed_to_view'];
         
         else {
         
             return "Both"; // AVMS and CVMS
         }
          
    }

    /**
     * Check and Return allowed module to view by a tenant. AVMS or CVMS or Both
     *
     * @return string module
     */
    public static function get_default_module() {

        $session = new CHttpSession;
        if( isset($session['module_allowed_to_view']) && !is_null($session['module_allowed_to_view']))

            return $session['module_allowed_to_view'];

        else {

            return "AVMS"; // AVMS and CVMS
        }

    }
    
    /**
     * Get comma seprated link of the Role IDs of CVMS of AVMS users
     * 
     * @param string $module Name of the send module
     * @return string $str comma separated ids
     */
    public static function get_comma_separated_role_ids( $module = "CVMS") {
        
        $str = 0;
        if($module == "CVMS")
        {
            $str = implode(",", Roles::get_cvms_roles());
        }
        if($module == "AVMS")
        {
            $str = implode(",", Roles::get_avms_roles());
        }
        if($module == "Both")
        {
            $array = array_merge(Roles::get_avms_roles(), Roles::get_cvms_roles());
            $str = implode(",", $array );
        }
        
        return $str;
    }
    
    /**
     * Module not authorized to view
     * @param string $module name of the authorized module
     */
    
    public static function check_module_authorization( $module = "CVMS") {
        
         $session = new CHttpSession;
         
         if( isset($session['module_allowed_to_view']) && $session['module_allowed_to_view'] != $module  && $session['module_allowed_to_view'] != "Both" )
         {  
             throw new CHttpException(403,'You are not authorized to view this page');
         }
         else {
             return true;
         }
    }

    public static function setModuleFocus($module)
    {
        self::check_module_authorization($module);
        $session = new CHttpSession;
        $session['current_module_focus'] = $module;
    }

    public static function getModuleFocus()
    {
        $session = new CHttpSession;
        return $session['current_module_focus'];
    }


}
