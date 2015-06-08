<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/6/15
 * Time: 3:21 PM
 */

class Declaration extends CFormModel{

    public $declaration1;
    public $declaration2;
    public $declaration3;
    public $declaration4;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(

            array('declaration1,declaration2,declaration3,declaration4', 'compare', 'compareValue' => true,
              'message' => 'You must agree to the terms and conditions'),

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
            'condition_1'=>'',
        );
    }

}