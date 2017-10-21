<?php

class ImmiInfo extends CValidator
{
	public $is_citizen;

	
	protected function validateAttribute($object, $attribute)
    {

        if ($object->is_postal==2) {
			switch ($object->$attribute){
			case 'travel_id':
            if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
            break;
			case 'grant_number':	
			 if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
			case 'arrival':	
			 if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
			case 'arrival_date':	
			 if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
			case 'flight_number':	
			if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
			case 'name_vessel':	
			 if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
			case 'parent_family_name':	
			if ($object->$attribute == '') {
                $this->addError($object, $attribute , 'Please fill {attribute} ');
				//Yii::app()->end();
			 }
			break;
			case 'parent_given_name':	
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
		case 'travel_id':	
			return '
		if($("#Immigration_is_citizen_1").is(":checked")) {
			if($("#Immigration_travel_id").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'grant_number':	
			return '
		if($("#Immigration_is_citizen_1").is(":checked")) {
			if($("#Immigration_grant_number").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'arrival':	
			return '
		if($("#Immigration_is_citizen_1").is(":checked")) {
			if($("#Immigration_arrival").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'arrival_date':	
			return '
		if($("#Immigration_is_citizen_1").is(":checked")) {
			if($("#Immigration_arrival_date").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'flight_number':	
			return '
		if($("#Immigration_is_citizen_1").is(":checked")) {
			if($("#Immigration_flight_number").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'name_vessel':	
			return '
		if($("#Immigration_is_citizen_1").is(":checked")) {
			if($("#Immigration_name_vessel").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;
		case 'parent_family_name':	
			return '
		if($("#Immigration_is_citizen_1").is(":checked")) {
			if($("#Immigration_parent_family_name").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;	
			case 'parent_given_name':	
			return '
		if($("#Immigration_is_citizen_1").is(":checked")) {
			if($("#Immigration_parent_given_name").val()=="")
			messages.push(' . CJSON::encode("Please fill ".$object->getAttributeLabel($attribute)).');}';
			break;	
		}
		
		
    }
	
}

?>