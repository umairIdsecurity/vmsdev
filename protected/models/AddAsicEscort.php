<?php

/**
 * AddCompanyContactForm class.
 */
class AddAsicEscort extends CFormModel {

    public $firstName;
    public $lastName;
    public $asic_no;
    public $expiry;
    public $contact_no;
    public $email;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('firstName, lastName, email,contact_no, asic_no, expiry', 'required'),
            array('email', 'email'),
            //array('email', 'emailUnique', 'add_asic_escort'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'firstName'     => 'First Name',
            'lastName'      => 'Last Name',
            'email'         => 'Email',
            'asic_no'    => 'Asic No',
            'expiry'   => 'Expiry',
            'contact_no' => 'Contact No',
        );
    }
//
//    public function emailUnique($attribute, $params) {
//        $company = Company::model()->find("name=':name'", ['name' => $this->companyName]);
//        $contact = User::model()->find("email=:email and company=:cid", [
//            'email' => $this->email,
//            'cid' => $company->id
//        ]);
//
//        if ($contact) {
//            $this->addError($attribute, 'Contact existed !');
//        }
//    }

}
