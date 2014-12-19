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
class VisitReasonServiceImpl implements VisitReasonService {

    public function save($visitReason, $sessionId) {
        $visitReason->created_by = $sessionId;
        $visitReason->reason = ucwords($visitReason->reason);  
        if (!($visitReason->save())) {
            return false;
        }
        
       // Visitor::model()->saveReason($visitor->id, $visit_reason);
        return true;
    }

}
