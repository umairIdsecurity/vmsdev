<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/16/15
 * Time: 9:35 AM
 */

class CreateLogin extends CFormModel{

    public $username;
    public $username_repeat;
    public $password;
    public $password_repeat;
    public $account_type;


    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(

            array('username', 'unique','className'=>'Registration','attributeName'=>'email','message'=>"Username already exists"),
            array('username,password,account_type', 'required','message'=>"Please enter {attribute}"),
            array('password', 'length', 'min' => 5, 'max'=>20, 'message'=>Yii::t("translation", "{attribute} is too short.")),
            array('username_repeat', 'compare', 'compareAttribute'=>'username', 'message'=>"Confirm Username do not match"),
            array('password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Confirm Password do not match"),

        );
    }

    /*public function validateUsername($attribute,$params)
    {

        if(User::model()->exists('email=:email',array('email'=>$this->email))){
            $this->addError('email','email already exists.');
        }

    }*/



}