<?php

/**
 * Class VisitorPrimaryIdentification
 *
 * @author Yuri Vodolazsky
 */
class VisitorPrimaryIdentification extends CValidator
{
    protected function validateAttribute($object, $attribute)
    {
        if ($object->profile_type == Visitor::PROFILE_TYPE_VIC && ! $object->alternative_identification) {
            if ($object->$attribute == '') {
                $this->addError($object, $attribute, 'Please enter a ' . $object->getAttributeLabel($attribute));
            }
        }
    }

    public function clientValidateAttribute($object,$attribute)
    {
        return "
if(value == '') {
    if ( ! $('#Visitor_alternative_identification').attr('checked')) {
        messages.push(" . CJSON::encode('Please enter a ' . $object->getAttributeLabel($attribute)) . ");
    }
}
";
    }
}

