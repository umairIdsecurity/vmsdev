<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class TenantForm extends CFormModel
{
    public $tenant_name;
    public $tenant_code;
    public $first_name;
    public $last_name;
    public $email;
    public $contact_number;
    public $password_opt;
    public $password;
    public $cnf_password;
    public $role;
    public $user_status;
    public $user_type;
    public $notes;
    public $photo;
    public $timezone_id;
    public $allowed_module;
    public $workstation;
    public $tenant_agent_name;
    public $asic_no;
    public $asic_expiry;
    public $module_access;
    

    public static $USER_ROLE_LIST = array(

        Roles::ROLE_SUPERADMIN => 'Super Administrator',
        Roles::ROLE_ADMIN => 'Administrator',
        Roles::ROLE_AGENT_ADMIN => 'Agent Administrator',
        Roles::ROLE_AGENT_OPERATOR => 'Agent Operator',
        Roles::ROLE_OPERATOR => 'Operator',
        Roles::ROLE_STAFFMEMBER => 'Staff Member',
        Roles::ROLE_VISITOR => 'Visitor',
        Roles::ROLE_ISSUING_BODY_ADMIN => 'Issuing Body Administrator',
        Roles::ROLE_AIRPORT_OPERATOR => 'Airport Operator',
        Roles::ROLE_AGENT_AIRPORT_ADMIN =>'Agent Airport Administrator',
        Roles::ROLE_AGENT_AIRPORT_OPERATOR =>'Agent Airport Operator'

    );
    public static $USER_TYPE_LIST = array(
        //''=>'User Type',
        1 => 'Internal',
        2 => 'External',
    );
    public static $USER_STATUS_LIST = array(
        1 => 'Open',
        2 => 'Access Denied',
    );

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(

            // all cases
            array('tenant_name,tenant_code, first_name, last_name, email, contact_number,role',
                    'required',
                    'message'=>'Please complete {attribute}'),


            array('workstation, password_opt,timezone_id',
                    'required',
                    'on'=>['save','save.asic','save.passwordrequire','save.asic.passwordrequire'],
                    'message'=>'Please complete {attribute}'),

            array('asic_no, asic_expiry',
                    'required',
                    'on'=>['save.asic','save.asic.passwordrequire'],
                    'message'=>'Please complete {attribute}'),

            array('tenant_name,first_name, last_name, email', 'length', 'max' => 50),
            array('tenant_code', 'length', 'max' => 3),
            array('tenant_code', 'length', 'min' => 3),
            array('role, user_type, user_status,password_opt', 'numerical', 'integerOnly' => true),

            array('password', 'compare', 'compareAttribute'=>'cnf_password','on'=>'edit_form'),

            array('email', 'filter', 'filter' => 'trim'),
            array('email', 'email'),

            // email address will be the first for the tenant so no need for unique check.... no tenant check for uniqueness within anyway
//            array('email',
//                    'unique',
//                    'className'=> 'User',
//                    'criteria'=>array('condition'=>'is_deleted =:is_deleted AND id !=:id',
//                    'params'=>array(':is_deleted'=>0, ':id'=>Yii::app()->user->tenant)),
//                    'on'=>['edit_form','save','save.asic']),

            array('password,cnf_password',
                    'required',
                    'on'=>['save.passwordrequire','save.asic.passwordrequire'],
                    'message' => 'Please enter or autogenerate password'),

            array('password', 'compare', 'compareAttribute'=>'cnf_password','on'=>['save.passwordrequire','save.asic.passwordrequire']),
            array('tenant_code','match', 'pattern' => '[^[A-Za-z]+$]','message' => 'Tenant code should not contain a numeric value'),
            
        );
    }



    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email Address',
            'contact_number' => 'Contact Number',
            'company' => 'Company Name',
            'department' => 'Department',
            'position' => 'Position',
            'staff_id' => 'Staff ID',
            'notes' => 'Notes',
            'password' => 'Password',
            'role' => 'Role',
            'user_type' => 'User Type',
            'user_status' => 'User Status',
            'created_by' => 'Created By',
            'is_deleted' => 'Deleted',
            'tenant' => 'Tenant',
            'password' => 'Password',
            'cnf_password' => 'Repeat Password',
            'photo' => 'Photo',
            'timezone_id' => 'Timezone',
            'allowed_module' => 'Module Access',
            'password_opt' => 'Password Option',
            'tenant_agent_name' => 'Tenant Agent Name',
            'asic_no' => 'ASIC No',
            'asic_expiry' => 'ASIC expiry'
        );
    }
    public function is_avms_user()
    {
        return in_array($this->role,Roles::get_avms_roles());
    }
}
