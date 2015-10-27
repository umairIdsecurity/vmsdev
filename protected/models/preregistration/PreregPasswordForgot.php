<?php

/**
 * ForgotForm class.
 * ForgotForm is the data structure for keeping
 * user restore password. It is used by the 'forgot' action of 'PreregistrationController'.
 */
class PreregPasswordForgot extends CFormModel {

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
        if(!$model = Registration::model()->findByAttributes(array('email' => $this->$attribute))){
            $this->addError($attribute, 'Email address does not exist in system.');
        }
    }

    public function restore()
    {
        $error = Registration::model()->restorePassword($this->email);

        if (!is_null($error)) {
            Yii::app()->user->setFlash('error', $error);
            return false;
        }

        return true;
    }
}
