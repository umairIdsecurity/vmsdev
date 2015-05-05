<?php

/**
 * Class PasswordCustom
 *
 * @author Yuri Vodolazsky
 */
class PasswordCustom extends CValidator
{

    protected function validateAttribute($object, $attribute)
    {
        $password = $object->$attribute;

        $passwordRequirementProperty = 'password_requirement';
        $passwordRequirement = property_exists($object, $passwordRequirementProperty) ? $object->$passwordRequirementProperty : null;

        if ($passwordRequirement != PasswordRequirement::PASSWORD_IS_NOT_REQUIRED) {

            $passwordOptionProperty = 'password_option';
            $passwordOption = property_exists($object, $passwordOptionProperty) ? $object->$passwordOptionProperty : null;

            if ($passwordOption == PasswordOption::CREATE_PASSWORD) {
                if (empty($password) || $password == '(NULL)') {
                    $this->addError($object, $attribute, 'Please enter a password');
                }
            }
        }
    }

    public function clientValidateAttribute($object,$attribute)
    {
        return "
if (value == '') {
    if($('.password_requirement:checked').val() == " . PasswordRequirement::PASSWORD_IS_REQUIRED . ") {
        if($('.password_option:checked').val() == " . PasswordOption::CREATE_PASSWORD . ") {
            messages.push(" . CJSON::encode('Password should be specified') . ");
        }
    }
}
";
    }
}