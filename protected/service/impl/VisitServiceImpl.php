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
        $visit->created_by = $sessionId;
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
