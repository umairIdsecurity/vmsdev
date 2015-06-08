<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/6/15
 * Time: 12:16 PM
 */

class EntryPoint extends CFormModel{

    public $entrypoint;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(

            array('entrypoint', 'required' , 'message'=>'Please select a Workstation'),

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
            'entrypoint'=>'Entry Point',
        );
    }

}