<?php
class TenantSelection extends CFormModel{

    public $tenant;
    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(

            array('tenant', 'required' , 'message'=>'Please choose an airport'),


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
            'tenant'=>'Airport',
        );
    }
}