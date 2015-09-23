<?php

class EmailCustom extends CEmailValidator
{
    public $pattern = '/^[ ]*[a-zA-Z0-9!#$%&\'*+\\/=?^_`’{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`’{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?[ ]*$/';

    protected function validateAttribute($object, $attribute)
    {
        $pattern = '/^[ ]*[a-zA-Z0-9!#$%&\'*+\\/=?^_`’{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`’{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?[ ]*$/';
        if ($object->visitor_card_status == 2) {
            if (!preg_match($pattern, $object->$attribute)) {
                if ($object->$attribute !== $object->first_name . '.' . $object->last_name) {
                    $this->addError($object, $attribute, 'Email is incorrect format');
                }
            }
        } else {
            if (!preg_match($pattern, $object->$attribute)) {
                $this->addError($object, $attribute, 'Email is incorrect format');
            }
        }
    }

    public function clientValidateAttribute($object, $attribute)
    {
        if($this->validateIDN)
        {
            Yii::app()->getClientScript()->registerCoreScript('punycode');
            // punycode.js works only with the domains - so we have to extract it before punycoding
            $validateIDN='
var info = value.match(/^(.[^@]+)@(.+)$/);
if (info)
	value = info[1] + "@" + punycode.toASCII(info[2]);
';
        }
        else
            $validateIDN='';

        $message=$this->message!==null ? $this->message : Yii::t('yii','{attribute} is not in a recognised format. <span style="text-transform:capitalize;">Please </span>revise.');
        $message=strtr($message, array(
            '{attribute}'=>$object->getAttributeLabel($attribute),
        ));

        $condition="!value.match({$this->pattern})";
        if($this->allowName)
            $condition.=" && !value.match({$this->fullPattern})";

        return "
        var cardStatus = $('#Visitor_visitor_card_status').val();
        var firstName = $('#Visitor_first_name').val();
        var lastName = $('#Visitor_last_name').val();
        if(cardStatus == 2) {
            $validateIDN
            if(".($this->allowEmpty ? "jQuery.trim(value)!='' && " : '').$condition.") {
                var str = firstName + '.' + lastName;
                if(value.toLowerCase() !== str.toLowerCase()){
                    messages.push(".CJSON::encode($message).");
                }

            }
        } else {
            $validateIDN
            if(".($this->allowEmpty ? "jQuery.trim(value)!='' && " : '').$condition.") {
	            messages.push(".CJSON::encode($message).");
            }
        }";
    }

}