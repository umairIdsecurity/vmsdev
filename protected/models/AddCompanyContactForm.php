<?php
Yii::import('ext.validator.PasswordRequirement');
/**
 * AddCompanyContactForm class.
 */
class AddCompanyContactForm extends CFormModel {

    public $companyName;
    public $firstName;
    public $lastName;
    public $email;
    public $mobile;
    public $companyType;
    public $user_password;
    public $password_requirement;
    public $user_repeatpassword;
    public $password_option;
    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('companyName, firstName, lastName, email, mobile, companyType', 'required', 'message'=>'Please complete {attribute}'),
            array('email', 'email'),
            array('email', 'emailUnique', 'add_company_contact'),
            array('password_requirement,password_option,user_password','safe'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'companyName'   => 'Company Name',
            'firstName'     => 'First Name',
            'lastName'      => 'Last Name',
            'email'         => 'Email',
            'mobile'        => 'Mobile',
            'companyType'   => 'Company Type',
        );
    }

    public function emailUnique($attribute, $params) {
        $company = Company::model()->find("name=':name'", ['name' => $this->companyName]);
        $contact = User::model()->find("email=:email and company=:cid", [
                'email' => $this->email, 
                'cid' => $company->id
            ]);

        if ($contact) {
            $this->addError($attribute, 'Contact existed !');
        }
    }

}
