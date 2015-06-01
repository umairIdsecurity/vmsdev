<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vmsActiveRecord
 *
 * @author Jeremiah
 */
class VmsActiveRecord extends CActiveRecord {
    /**
    * Prepares created_by attributes before 
   saving.
    */
    protected function beforeSave()
    {

        if(null !== Yii::app()->user)
        { $id=Yii::app()->user->id; }
        else
        { $id='';}

        if($this->isNewRecord)
        $this->created_by=$id;

        return parent::beforeSave();
    }

    public function behaviors()
    {
        return array(
            // Classname => path to Class
            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }


}
