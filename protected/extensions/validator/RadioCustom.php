<?php

class RadioCustom extends CValidator
{
	public $radiobutton;
	
	protected function validateAttribute($object, $attribute)
    {
		
        if ($object->radiobutton =='2' || $object->radiobutton=='3') {
            if ($object->$attribute == '') {
                $this->addError($object, $attribute, 'Please enter a ' . $object->getAttributeLabel($attribute));
				//Yii::app()->end();
            }
        }
    }
	
	public function clientValidateAttribute($object,$attribute)
    {
        return '
if(($("#AsicType_radiobutton_1").is(":checked") || $("#AsicType_radiobutton_2").is(":checked"))) {
 if((!$("#AsicType_renewal_0").is(":checked") && !$("#AsicType_renewal_1").is(":checked")))
        messages.push(' . CJSON::encode("Please choose Yes or No").');
  
}
';
    }
	
}

?>