<?php

class AsicInfoRed extends CValidator
{
	//public $radiobutton;
	
	protected function validateAttribute($object, $attribute)
    {
	
    }
	
	public function clientValidateAttribute($object,$attribute)
    {
        return '
if($("#AsicInfo_access_0").is(":checked") ) {
	 if((!$("#AsicInfo_frequency_red_0").is(":checked") && !$("#AsicInfo_frequency_red_1").is(":checked") && !$("#AsicInfo_frequency_red_2").is(":checked")))
        messages.push(' . CJSON::encode("Please select one of Frequency of Access").');
}
';
    }
	
}

?>