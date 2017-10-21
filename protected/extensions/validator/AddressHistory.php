<?php

class AddressHistory extends CValidator
{
	public $is_postal;

	
	protected function validateAttribute($object, $attribute)
    {

       
    }
	
	public function clientValidateAttribute($object,$attribute)
    {
		switch ($attribute){
		case 'street_number':	
			return '
		if(!$("#addhistory :input").prop("disabled")) {
			if($("#AsicAddressHistory_street_number").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'street_name':	
			return '
		if(!$("#addhistory :input").prop("disabled")) {
			if($("#AsicAddressHistory_street_name").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'street_type':	
			return '
		if(!$("#addhistory :input").prop("disabled")) {
			
			if($("#AsicAddressHistory_street_type").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'suburb':	
			return '
		if(!$("#addhistory :input").prop("disabled")) {
			if($("#AsicAddressHistory_suburb").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'country':	
			return '
		if(!$("#addhistory :input").prop("disabled")) {
			if($("#AsicAddressHistory_country").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'state':	
			return '
		if(!$("#addhistory :input").prop("disabled")) {
			if($("#AsicAddressHistory_state").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'postcode':	
			return '
		if(!$("#addhistory :input").prop("disabled")) {
			if($("#AsicAddressHistory_postcode").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'from_date':	
			return '
		if(!$("#addhistory :input").prop("disabled")) {
			
			if($("#AsicAddressHistory_from_date").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');
			
		
		}';
			break;
		case 'to_date':	
			return '
		if(!$("#addhistory :input").prop("disabled")) {
			if($("#AsicAddressHistory_to_date").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		}
		
		
    }
	
}

?>