<?php

/**
 * ForgotForm class.
 * ForgotForm is the data structure for keeping
 * user restore password. It is used by the 'forgot' action of 'SiteController'.
 */
class ForgotForm extends CFormModel {

    public $email;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('email', 'required'),
            array('email', 'isEmailExist'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'email' => 'Email',
        );
    }

    public function isEmailExist($attribute) {
        if(!$model = User::model()->findByAttributes(array('email' => $this->$attribute))){
            $this->addError($attribute, 'Email address does not exist in system.');
        }
    }

    public function restore()
    {
        $errors = User::model()->restorePassword($this->email);
        if (!empty($errors)) {
            $this->addErrors($errors);
            return false;
        }
        return true;
    }
}