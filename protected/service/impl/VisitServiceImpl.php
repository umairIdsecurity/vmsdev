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
        //Integrity Constraint violation here if removed
        if(empty($visit->visitor_type)){
            $visit->visitor_type = NULL;
        }

        $visit->created_by = $sessionId;

        if ($visit->time_in_hours != '') {
            $visit->time_in = $visit->time_in_hours . ':' . $visit->time_in_minutes;
        }
       
        //if ($visit->visitor_type == VisitorType::PATIENT_VISITOR) {
        //    $visit->host = NULL;
        //} else {
        //    $visit->patient = NULL;
        //}
        
        if (!($visit->save())) {
            return false;
        }
        $visitor = Visitor::model()->findByPK($visit->visitor);
        

        $this->returnCardIfVisitIsClosedManually($visit);
        $this->clearAllDatesIfVisitStatusIsSave($visit);
        
        Visit::model()->updateByPk($visit->id, array(
            'tenant' => $visitor->tenant,
            'tenant_agent' => $visitor->tenant_agent,
        ));

        //logs the visit which has been ACTIVATED
        if($visit->visit_status == VisitStatus::ACTIVE){
            $this->audit_logging_visit_statuses("ACTIVATE VISIT",$visit);
        }

        //logs the visit which has been CANCELLED
        /*if($visit->visit_status == VisitStatus::SAVED){
            $this->audit_logging_visit_statuses("CANCEL VISIT",$visit);
        }*/

        return true;
    }

    public function audit_logging_visit_statuses($action,$visit){
        $log = new AuditLog();
        $log->action_datetime = date('Y-m-d H:i:s');
        $log->action = $action;
        $log->detail = 'Logged user ID: ' . Yii::app()->user->id." Visit ID: ".$visit->id." Visitor ID: ".$visit->visitor;
        $log->user_email_address = Yii::app()->user->email;
        $log->ip_address = (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != "") ? $_SERVER['REMOTE_ADDR'] : "UNKNOWN";
        $log->tenant = Yii::app()->user->tenant;
        $log->tenant_agent = Yii::app()->user->tenant_agent;
        $log->save();
    }

    function returnCardIfVisitIsClosedManually($visit) {
        //if visit is closed update card status to returned and date returned to current date
        if ($visit->card != '' && $visit->visit_status == VisitStatus::CLOSED) {
            CardGenerated::model()->updateByPk($visit->card, array(
                'card_status' => CardStatus::RETURNED,
                'date_returned' => date('Y-m-d'),
            ));
        }
    }
    
    function clearAllDatesIfVisitStatusIsSave($visit) {
        //if visit is closed update card status to returned and date returned to current date
        if ($visit->visit_status == VisitStatus::SAVED) {
            Visit::model()->updateByPk($visit->id, array(
                'time_out' => '',
                'time_check_out' => '',
            ));
        }
    }

    public function notreturnCardIfVisitIsExpiredAutomatically() {
        Visit::model()->updateVisitsToExpired();
    }

    public function notreturnCardIfVisitIsClosedAutomatically() {
        Visit::model()->updateVisitsToClose();
    }

}
