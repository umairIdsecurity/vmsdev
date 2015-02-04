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
class VisitorTypeServiceImpl implements VisitorTypeService {

    public function save($visitorType, $user) {
        $visitorType->created_by = $user->id;
        $visitorType->tenant = $user->tenant;
        $visitorType->tenant_agent = $user->tenant_agent;
        
        if (!($visitorType->save())) {
            return false;
        }
        return true;
    }

}
