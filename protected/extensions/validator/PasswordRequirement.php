<?php

/**
 * Class PasswordRequirement
 *
 * @author Yuri Vodolazsky
 */
class PasswordRequirement extends CValidator
{
    const PASSWORD_IS_NOT_REQUIRED = 1;
    const PASSWORD_IS_REQUIRED = 2;

    protected function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;
        if ($object->profile_type == Visitor::PROFILE_TYPE_VIC &&
            $value != self::PASSWORD_IS_NOT_REQUIRED &&
            $value != self::PASSWORD_IS_REQUIRED
        ) {
            $this->addError($object, $attribute, 'Please specify a value');
        }
    }

    public function clientValidateAttribute($object,$attribute)
    {
        return "
if(value != " . self::PASSWORD_IS_NOT_REQUIRED . " && value != " . self::PASSWORD_IS_REQUIRED . ") {
    messages.push(" . CJSON::encode('Please enter specify a value') . ");
}
";
    }
}
