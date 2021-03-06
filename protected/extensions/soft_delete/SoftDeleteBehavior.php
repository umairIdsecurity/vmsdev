<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SoftDeleteBehavior extends CActiveRecordBehavior {

    public $flagField = 'is_deleted';

    //finding record 
    public function beforeFind($event) {
        $session = new CHttpSession;
        $criteria = new CDbCriteria;
        $criteria->condition = "t.is_deleted = 0 ";
        /*if ($session['role'] != Roles::ROLE_SUPERADMIN && $session['tenant'] != ''  ) {
            $criteria->condition = "t.is_deleted = 0 and t.tenant = " . $session['tenant'];
        }*/

        $this->owner->dbCriteria->mergeWith($criteria);
    }

    public function beforeDelete($event) {
        $this->owner->is_deleted = 1;
        $this->owner->save();

        //prevent real deletion
        $event->isValid = false;
    }

}
