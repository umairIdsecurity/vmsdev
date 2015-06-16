<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/16/15
 * Time: 9:35 AM
 */

class Registration extends CFormModel{

    public $username;
    public $username_repeat;
    public $password;
    public $password_repeat;


    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(

            array('username', 'unique','className'=>'User','attributeName'=>'email','message'=>"Username already exists"),
            array('username,password', 'required'),
            array('username_repeat', 'compare', 'compareAttribute'=>'username', 'message'=>"Username don't match"),
            array('password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match"),

        );
    }

    /*public function validateUsername($attribute,$params)
    {

        if(User::model()->exists('email=:email',array('email'=>$this->email))){
            $this->addError('email','email already exists.');
        }

    }*/



}