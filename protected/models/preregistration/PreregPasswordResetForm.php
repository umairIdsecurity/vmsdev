<?php

class PreregPasswordResetForm extends CFormModel {

    public $password;
    public $passwordConfirmation;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('password, passwordConfirmation', 'required'),
            array('passwordConfirmation', 'checkPasswordsAreMatched'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'password' => 'New password',
            'passwordConfirmation' => 'Confirm new password',
        );
    }

    public function checkPasswordsAreMatched($passwordConfirmation) {

        if ($this->passwordConfirmation != $this->password) {
            $this->addError($passwordConfirmation, 'Passwords are not matches each others');
        }
    }
}
