<?php

class CompanyNumber extends CValidator
{


	protected function validateAttribute($object, $attribute)
    {
		//print_r($object);
		
    }
	
	public function clientValidateAttribute($object,$attribute)
    {
       return '
		if($("#officeno").is(":visible") && $("#AsicOnCompany_office_number").val()==""){
        messages.push(' . CJSON::encode("Please Enter Company Number").');
}

';
    }
	
}

?>