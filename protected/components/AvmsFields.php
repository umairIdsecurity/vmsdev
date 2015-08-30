<?php
/**
 * Created by PhpStorm.
 * User: dx-sadaf
 * Date: 5/5/15
 * Time: 11:31 PM
 */

class AvmsFields extends CValidator
{

    private static $processed = false;

    protected function validateAttribute($object,$attribute)
    {
        if( CHelper::is_accessing_avms_features() || $object->is_avms_user() ) {
            switch ($attribute) {
                case 'asic_no':
                    if(empty($object->$attribute) ){
                        $object->addError($attribute, 'Please enter an ASIC number');
                    }
                    break;

                case 'asic_expiry':
                    if(empty($object->$attribute) ){
                        $object->addError($attribute, 'Please enter an ASIC expiry date');
                    }
                    break;

            }
        }
    }


    public function clientValidateAttribute($object,$attribute)
    {
        if( CHelper::is_accessing_avms_features() || $object->is_avms_user() ) {

            $str =  "if(value=='') {\n"
                    ."  if(attribute='asic_no') {\n"
                    ."      messages.push('Please enter an ASIC number');\n"
                    ."  }\n"
                    ."  if(atribute='asic_expiry'){\n"
                    ."      messages.push('Please enter an ASIC expiry date');\n"
                    ."  }\n"
                    ."}\n";

            return $str;

        }
    }

}