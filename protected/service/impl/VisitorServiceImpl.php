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

        if (Yii::app()->controller->action->id == 'create') {
            $visitor->password = User::model()->hashPassword($visitor->password);
            $visitor->repeatpassword = $visitor->password;
        }
        
        if($visitor->vehicle !=''){
            $vehicle = new Vehicle;
            $vehicle->vehicle_registration_plate_number=$visitor->vehicle;
            $vehicle->save();
            
            $visitor->vehicle = Vehicle::model()->findByAttributes(array('vehicle_registration_plate_number' => $visitor->vehicle))->id;
        } else {
            $visitor->vehicle = NULL; 
        }
        
        if (!($visitor->save())) {
            return false;
        }

        // Visitor::model()->saveReason($visitor->id, $visit_reason);
        return true;
    }

}
