<?php

/**
 * Class PasswordRepeat
 *
 * @author Yuri Vodolazsky
 */
class PasswordRepeat extends CValidator
{

    protected function validateAttribute($object, $attribute)
    {
        $passwordRepeat = $object->$attribute;

        $passwordRequirementProperty = 'password_requirement';
        $passwordRequirement = property_exists($object, $passwordRequirementProperty) ? $object->$passwordRequirementProperty : null;

        if ($passwordRequirement != PasswordRequirement::PASSWORD_IS_NOT_REQUIRED) {

            $passwordOptionProperty = 'password_option';
            $passwordOption = property_exists($object, $passwordOptionProperty) ? $object->$passwordOptionProperty : null;

            if ($passwordOption == PasswordOption::CREATE_PASSWORD) {
                if (empty($passwordRepeat) || $passwordRepeat == '(NULL)') {
                    if(Yii::app()->controller->id == 'visitor' && Yii::app()->controller->action->id != 'delete'){
                        $this->addError($object, $attribute, 'Please confirm a password');
                    }
                } else if ($passwordRepeat != $object->password) {
                    $this->addError($object, $attribute, 'Passwords are not matched!');
                }
            }
        }
    }

    public function clientValidateAttribute($object,$attribute)
    {
        /*return "
if($('.password_requirement:checked').val() == " . PasswordRequirement::PASSWORD_IS_REQUIRED . ") {
    if($('.password_option:checked').val() == " . PasswordOption::CREATE_PASSWORD . ") {
        if (value == '') {
            messages.push(" . CJSON::encode('Please confirm a password') . ");
        } else if (value != $('.original-password').val()) {
            messages.push(" . CJSON::encode('Passwords are not matched') . ");
        }
    }
}
";*/
    }
}
