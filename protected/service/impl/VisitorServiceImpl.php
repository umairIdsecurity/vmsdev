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

        if (Yii::app()->controller->action->id == 'create' || Yii::app()->controller->action->id == 'addvisitor') {
            if($visitor->password == '' || $visitor->password == "(NULL)"){
                $visitor->password = "(NULL)";
            } else {
                $visitor->password = User::model()->hashPassword($visitor->password);
            }
            
            $visitor->repeatpassword = $visitor->password;

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
            $visitor->password = User::model()->hashPassword($visitor->password);
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
        
        if (!($visitor->save())) {
            return false;
        }

        // Visitor::model()->saveReason($visitor->id, $visit_reason);
        return true;
    }

}
