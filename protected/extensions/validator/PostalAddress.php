<?php

class PostalAddress extends CValidator
{
	public $is_postal;

	
	protected function validateAttribute($object, $attribute)
    {

        if ($object->is_postal==0) {
			switch ($object->$attribute){
			case 'postal_street_number':
            if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
            break;
			case 'postal_street_name':	
			 if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
			case 'postal_street_type':	
			 if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
			case 'postal_suburb':	
			 if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
			case 'postal_country':	
			if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
			case 'postal_state':	
			 if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
			case 'postal_postcode':	
			if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
        }
		}
    }
	
	public function clientValidateAttribute($object,$attribute)
    {
		switch ($attribute){
		case 'postal_street_number':	
			return '
		if($("#RegistrationAsic_is_postal_1").is(":checked")) {
			if($("#RegistrationAsic_postal_street_number").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'postal_street_name':	
			return '
		if($("#RegistrationAsic_is_postal_1").is(":checked")) {
			if($("#RegistrationAsic_postal_street_name").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'postal_street_type':	
			return '
		if($("#RegistrationAsic_is_postal_1").is(":checked")) {
			if($("#RegistrationAsic_postal_street_type").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'postal_suburb':	
			return '
		if($("#RegistrationAsic_is_postal_1").is(":checked")) {
			if($("#RegistrationAsic_postal_suburb").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'postal_country':	
			return '
		if($("#RegistrationAsic_is_postal_1").is(":checked")) {
			if($("#RegistrationAsic_postal_country").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'postal_state':	
			return '
		if($("#RegistrationAsic_is_postal_1").is(":checked")) {
			if($("#RegistrationAsic_postal_state").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'postal_postcode':	
			return '
		if($("#RegistrationAsic_is_postal_1").is(":checked")) {
			if($("#RegistrationAsic_postal_postcode").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		}
		
		
    }
	
}

?>