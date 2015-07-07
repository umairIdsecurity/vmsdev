<?php

/**
 * AddCompanyContactForm class.
 */
class AddAsicEscort extends CFormModel {

    public $first_name;
    public $last_name;
    public $asic_no;
    public $asic_expiry;
    public $contact_number;
    public $email;
    public $company;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('first_name, last_name, email,contact_number, asic_no, asic_expiry, company', 'required'),
            array('email', 'email'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'first_name'     => 'First Name',
            'last_name'      => 'Last Name',
            'email'         => 'Email',
            'asic_no'    => 'Asic No',
            'asicexpiry'   => 'Expiry',
            'contact_number' => 'Contact No',
            'company'       => 'Company',
        );
    }

    public function getModelName()
    {
        return __CLASS__;
    }
}
