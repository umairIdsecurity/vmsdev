<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/6/15
 * Time: 3:21 PM
 */

class Declaration extends CFormModel{

    public $condition_1;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(

            array('condition_1', 'required' ),

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
            'condition_1'=>'Entry Point',
        );
    }

}