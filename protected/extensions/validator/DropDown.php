<?php

/**
 * Class VisitorAlternateIdentification
 *
 * @author Yuri Vodolazsky
 */
class DropDown extends CValidator
{
    protected function validateAttribute($object, $attribute)
    {
        if ($object->$attribute == '') {
            $this->addError($object, $attribute, 'Please Select a ' . $object->getAttributeLabel($attribute));
        }
    }

    public function clientValidateAttribute($object, $attribute)
    {
        return "
            if(value == '') {
                 messages.push(" . CJSON::encode('Please Select a ' . $object->getAttributeLabel($attribute)) . ");
            }";
    }
}
