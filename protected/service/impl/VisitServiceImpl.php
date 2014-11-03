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
class VisitServiceImpl implements VisitService {

    public function save($visit, $sessionId) {
        echo $visit->time_in_hours."hours";
        $visit->created_by = $sessionId;
        
        if ($visit->date_in !=''){
            $visit->date_in = date('Y-m-d', strtotime($visit->date_in));
        }
        
        if ($visit->date_out !=''){
            $visit->date_out = date('Y-m-d', strtotime($visit->date_out));
        }
        
     //   if ($visit->time_in_minutes !='' && $visit->time_in_hours !=''){
            $visit->time_in = $visit->time_in_hours.':'.$visit->time_in_minutes;
           // $visit->time_in = '12:24:00';
     //   }
        
        if (!($visit->save())) {
            return false;
        }

        $visitor = Visitor::model()->findByPK($visit->visitor);
        Visit::model()->updateByPk($visit->id, array(
            'tenant' => $visitor->tenant,
            'tenant_agent' => $visitor->tenant_agent,
        ));

        return true;
    }

}
