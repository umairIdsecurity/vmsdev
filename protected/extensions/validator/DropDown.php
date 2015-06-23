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
        if ($object->profile_type == Visitor::PROFILE_TYPE_VIC) {
            if ($object->$attribute == '') {
                $this->addError($object, $attribute, 'Please Select a ' . $object->getAttributeLabel($attribute));
            }
        } else {
            if ($attribute == 'company' && $object->$attribute == '') {
                $this->addError($object, $attribute, 'Please Select a ' . $object->getAttributeLabel($attribute));
            }
        }

    }

    public function clientValidateAttribute($object, $attribute)
    {
        if ($object->profile_type == Visitor::PROFILE_TYPE_VIC) {
            return "
            if(value == '') {
                 messages.push(" . CJSON::encode('Please Select a ' . $object->getAttributeLabel($attribute)) . ");
            }";
        } else {
            if ($attribute == 'company') {
                return "
            if(value == '') {
                 messages.push(" . CJSON::encode('Please Select a ' . $object->getAttributeLabel($attribute)) . ");
            }";
            }
        }

    }
}
