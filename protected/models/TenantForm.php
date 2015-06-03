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


    public static $USER_ROLE_LIST = array(

        5 => 'Super Administrator',
        1 => 'Administrator',
        6 => 'Agent Administrator',
        7 => 'Agent Operator',
        8 => 'Operator',
        9 => 'Staff Member',
        10 => 'Visitor',

        Roles::ROLE_ISSUING_BODY_ADMIN => 'Issuing Body Administrator',
        Roles::ROLE_AIRPORT_OPERATOR => 'Airport Operator',
        Roles::ROLE_AGENT_AIRPORT_ADMIN =>'Agent Airport Administrator',
        Roles::ROLE_AGENT_AIRPORT_OPERATOR =>'Agent Airport Operator'

    );
    public static $USER_TYPE_LIST = array(
        ''=>'User Type',
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
            // name, email, subject and message are required
            array('tenant_name,tenant_code,first_name, last_name, email, contact_number,password_opt', 'required'),
            array('tenant_name,tenant_code,first_name, last_name, email', 'length', 'max' => 50),
            array('tenant_code', 'length', 'max' => 3),
            array('role, user_type, user_status,password_opt', 'numerical', 'integerOnly' => true),
            array('user_type', 'required', 'message' => 'Please select a {attribute}'),
            array('email', 'filter', 'filter' => 'trim'),
            array('email', 'email'),
            array('email', "unique",'className'=> 'User'),
            array('password,cnf_password', 'required','on'=>'passwordrequire'),
            array('password', 'compare', 'compareAttribute'=>'cnf_password','on'=>'passwordrequire'),
            array('tenant_code','match', 'pattern' => '[^[A-Za-z]+$]','message' => 'Tenant code not contains the numeric value'),
            //array('password_opt', 'checkTerm'),

            // verifyCode needs to be entered correctly
            //array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
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
        );
    }
    public function is_avms_user()
    {
        return in_array($this->role,Roles::get_avms_roles());
    }
}
