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

    public function save($visitor) {
        $visitor->date_of_birth = date('Y-m-d', strtotime($visitor->birthdayYear . '-' .    $visitor->birthdayMonth . '-' . $visitor->birthdayDay));
        
        if (!($visitor->save())) {
            return false;
        }
        return true;
    }

    
}
