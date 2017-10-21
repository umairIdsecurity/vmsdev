<?php

class IdentificationCustom extends CValidator
{
	//public $radiobutton;
	
	protected function validateAttribute($object, $attribute)
    {
		
       
    }
	
	public function clientValidateAttribute($object,$attribute)
    {
		 switch($attribute)
	{
		case 'tertiary_id1':
		return '
		if($("#RegistrationAsic_check2").is(":checked") && $("#RegistrationAsic_tertiary_id1").val()=="" ) {
					messages.push(' . CJSON::encode("Select Tertiary Identification Type ").');
					}';
			break;
		case 'country_id4':
		return '
		if($("#RegistrationAsic_check2").is(":checked") && $("#RegistrationAsic_country_id4").val()=="" ) {
					messages.push(' . CJSON::encode("Select Tertiary Identification Country ").');
					}';
			break;
		
	}
        
    }
	
}

?>