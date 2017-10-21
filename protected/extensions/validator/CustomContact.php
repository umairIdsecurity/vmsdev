<?php

class CustomContact extends CValidator
{
	public $home_phone;
	public $work_phone;

	protected function validateAttribute($object, $attribute)
    {
		//print_r($object);
		//Yii::app()->end();
        if ( $object->work_phone=='' && $object->home_phone=='' && $object->$attribute=='') {
           
                $this->addError($object, $attribute , 'Please enter atleast any one of the contacts ');
				//Yii::app()->end();
            
        }
    }
	
	public function clientValidateAttribute($object,$attribute)
    {
       return '
		if($("#RegistrationAsic_home_phone").val()=="" && $("#RegistrationAsic_work_phone").val()=="" && $("#RegistrationAsic_mobile_phone").val()=="") {
        messages.push(' . CJSON::encode("Please enter atleast any one of the contacts").');
}

';
    }
	
}

?>