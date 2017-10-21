<?php
class AppType extends CFormModel{
    public $apptype;
	//public $asictype;
	//public $victype;
    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(

            array('apptype', 'required' , 'message'=>'Please choose one of the type'),
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
            'apptype'=>'Application Type',
			//'asictype'=>'Asic online',
			//'victype'=>'Preregister for VIC',
        );
    }
}