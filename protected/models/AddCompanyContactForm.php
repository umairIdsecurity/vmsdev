<?php

/**
 * AddCompanyContactForm class.
 */
class AddCompanyContactForm extends CFormModel {

    public $companyName;
    public $firstName;
    public $lastName;
    public $email;
    public $mobile;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('companyName, firstName, lastName, email, mobile', 'required'),
            array('email', 'email'),
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
            'mobile'    => 'Mobile',
        );
    }



}
