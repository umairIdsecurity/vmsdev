<?php

/**
 * Class PasswordOption
 *
 * @author Yuri Vodolazsky
 */
class PasswordOption extends CValidator
{
    const CREATE_PASSWORD = 1;
    const SEND_INVITATION = 2;

    protected function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;
        if ($value != self::CREATE_PASSWORD && $value != self::SEND_INVITATION) {
            $this->addError($object, $attribute, 'Please specify a value');
        }
    }

    public function clientValidateAttribute($object,$attribute)
    {
        return "
if(value != " . self::CREATE_PASSWORD . " && value != " . self::SEND_INVITATION . ") {
    messages.push(" . CJSON::encode('Please enter specify a value') . ");
}
";
    }
}
