<?php

class AsicInfoGrey extends CValidator
{
	//public $radiobutton;
	
	protected function validateAttribute($object, $attribute)
    {
	
    }
	
	public function clientValidateAttribute($object,$attribute)
    {
        return '
if($("#AsicInfo_access_1").is(":checked") ) {
	 if((!$("#AsicInfo_frequency_grey_0").is(":checked") && !$("#AsicInfo_frequency_grey_1").is(":checked") && !$("#AsicInfo_frequency_grey_2").is(":checked")))
        messages.push(' . CJSON::encode("Please select one of Frequency of Access").');
}
';
    }
	
}

?>