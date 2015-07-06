<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VisitorServiceImpl
 *
 * @author Jeremiah
 */
class VisitorServiceImpl implements VisitorService {

    public function save($visitor, $visitReason, $sessionId) {
        $visitor->created_by = $sessionId;
        $visitor->date_of_birth = date('Y-m-d', strtotime($visitor->birthdayYear . '-' . $visitor->birthdayMonth . '-' . $visitor->birthdayDay));
        
        // Change date formate from d-m-Y to Y-m-d
        if( !empty($visitor->identification_document_expiry))
            $visitor->identification_document_expiry = date("Y-m-d", strtotime($visitor->identification_document_expiry));
        if( !empty($visitor->identification_alternate_document_expiry1))
            $visitor->identification_alternate_document_expiry1 = date("Y-m-d", strtotime($visitor->identification_alternate_document_expiry1) );
        if( !empty($visitor->identification_alternate_document_expiry2))
            $visitor->identification_alternate_document_expiry2 = date("Y-m-d", strtotime($visitor->identification_alternate_document_expiry2) );


        if (Yii::app()->controller->action->id == 'create' || Yii::app()->controller->action->id == 'addvisitor') {


//            $visitor->repeatpassword = $visitor->password; // Why we need this assignment? Comparing validator is not make sense after it.

            if ($visitor->vehicle != '') {
                $vehicle = new Vehicle;
                $vehicle->vehicle_registration_plate_number = $visitor->vehicle;
                $vehicle->save();

                $visitor->vehicle = Vehicle::model()->findByAttributes(array('vehicle_registration_plate_number' => $visitor->vehicle))->id;
            } else {
                $visitor->vehicle = NULL;
            }
        } else {
            /* if update and vehicle not blank, update plate number 
             */
            if ($visitor->vehicle != '') {

                if (Visitor::model()->findByPk($visitor->id)->vehicle != NULL) {
                    Vehicle::model()->updateByPk(Visitor::model()->findByPk($visitor->id)->vehicle, array('vehicle_registration_plate_number' => $visitor->vehicle));
                } else {
                    $vehicle = new Vehicle;
                    $vehicle->vehicle_registration_plate_number = $visitor->vehicle;
                    $vehicle->save();
                }

                $visitor->vehicle = Vehicle::model()->findByAttributes(array('vehicle_registration_plate_number' => $visitor->vehicle))->id;
            } else {
                $visitor->vehicle = NULL;
            }
        }

        #Send mail
        if (isset($_POST['Visitor']['password_option']) && $_POST['Visitor']['password_option'] == 2) {
            $length = 10;
            $chars = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
            shuffle($chars);
            $password = implode(array_slice($chars, 0, $length));
            $headers = "From: admin@identitysecurity.com.au\r\nReply-To: admin@identitysecurity.com.au";
            $subject = "Account Information from Visitor Management System";
            $body = sprintf("Hi %s,
                             We send for your account at VMS website
                             Your account: %s
                             Password: %s
                             Regards", $visitor->first_name, $visitor->email, $password);
            if (mail($visitor->email, $subject, $body, $headers)){
                $visitor->password = $password;
            }
        }
        $visitor->asic_expiry = date("Y-m-d",strtotime($visitor->asic_expiry));

        if ($visitor->profile_type == Visitor::PROFILE_TYPE_VIC && date('Y') - date('Y', strtotime($visitor->date_of_birth)) < 18) {
            $visitor->setScenario('u18Rule');
        }

        if ($visitor->profile_type == Visitor::PROFILE_TYPE_ASIC) {
            switch ($visitor->visitor_card_status) {
                case Visitor::ASIC_ISSUED:
                    $visitor->setScenario('asicIssued');
                    break;
                case Visitor::ASIC_APPLICANT:
                    $visitor->setScenario('asicApplicant');
                    break;
            }

            #Todo: If ASIC no and ASIC expiry is empty then change visitor card status to expired
            if (empty($visitor->asic_no) && empty($visitor->asic_expiry)) {
                $visitor->visitor_card_status == Visitor::ASIC_EXPIRED;
            }
        }

        if (!($result = $visitor->save())) {
            return false;
        }


        // Visitor::model()->saveReason($visitor->id, $visit_reason);
        return true;
    }

}
