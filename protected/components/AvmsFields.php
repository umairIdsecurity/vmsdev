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
                        $object->addError($attribute, 'Please enter your ASIC number');
                    }
                    break;

                case 'asic_expiry_day':
                case 'asic_expiry_month':
                case 'asic_expiry_year':
                    if(empty($object->$attribute) ){
                        $object->addError($attribute, 'Please enter your ASIC number');
                    }else{
                        $this->check_expiry_date($object);
                    }
                    break;

            }
        }
    }


    public function clientValidateAttribute($object,$attribute)
    {
        if( CHelper::is_accessing_avms_features() || $object->is_avms_user() ) {

            $emptyCondition1 = "value==''";
            $str =  "
if({$emptyCondition1}) {
	messages.push('Please enter your ASIC number');}
";
            $emptyCondition2 = "value=='' || !isValidExpiryDate()";
            $str .= "
if({$emptyCondition2}) {
	messages.push('Please enter valid ASIC expiration date');}
";
            return $str;


        }
    }

    protected function check_expiry_date($object)
    {
        $nmonth = date("m", strtotime($object->asic_expiry_month));
        if(!checkdate($nmonth, $object->asic_expiry_day, $object->asic_expiry_year)){
            $flag = $object->getError('asic_expiry');
            if(!$flag) {
                $object->addError('asic_expiry', 'Please enter valid ASIC expiry date');
            }
        }
    }
}