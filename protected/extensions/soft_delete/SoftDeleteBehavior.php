<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class SoftDeleteBehavior extends CActiveRecordBehavior
{
    public $flagField = 'is_deleted';
    
    public function remove()
    {
        $this->getOwner()->{$this->flagField} = 1;
        return $this->getOwner();
    }
    
    public function restore()
    {
        $this->getOwner()->{$this->flagField} = 0;
        return $this->getOwner();
    }
   
    public function notRemoved()
    {
        $criteria = $this->getOwner()->getDbCriteria();
        $criteria->compare($this->flagField, 0);
        return $this->getOwner();
    }
    
    public function removed()
    {
    $criteria = $this->getOwner()->getDbCriteria();
    $criteria->compare($this->flagField, 1);
    return $this->getOwner();
    }
    
    public function isRemoved()
    {
    return (boolean)$this->getOwner()->{$this->flagField};
    }
    

   //finding record 
    public function beforeFind($event)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = "is_deleted = 0";
        $this->owner->dbCriteria->mergeWith($criteria);
    }

    public function beforeDelete($event)
    {
        $this->owner->is_deleted = 1;
        $this->owner->save();

        //prevent real deletion
        $event->isValid = false;
    }

}