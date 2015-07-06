<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
//    public $name;
//    public $email;
//    public $role_id;
    public $reason;
    public $message;
    public $verifyCode;

    public $contact_person_name;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and message are required
            array('reason, message', 'required'),
            array('contact_person_name', 'required'),
            // email has to be a valid email address
            //array('email', 'email'),
            array('contact_person_name', 'safe'),
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
            'verifyCode'=>'Verification Code',
	    'contact_person_name'=>'Who',
            'reason'=>'Reason',
            'message'=>'Message',
            
        );
    }
}
