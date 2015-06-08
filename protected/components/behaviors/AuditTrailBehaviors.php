<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 5/30/15
 * Time: 9:36 PM
 */

class AuditTrailBehaviors extends CActiveRecordBehavior{

    private $_oldattributes = array();

    public function afterSave($event)
    {
        try {
            $userid = Yii::app()->user->id;
        } catch(Exception $e) {
            $userid = null;
        }

        if(empty($userid)) {
            $userid = null;
        }

        $newattributes = $this->Owner->getAttributes();
        $oldattributes = $this->getOldAttributes();

        if (!$this->Owner->isNewRecord) {

            foreach ($newattributes as $name => $value) {
                if (!empty($oldattributes)) {
                    $old = $oldattributes[$name];
                } else {
                    $old = '';
                }

                if ($value != $old) {
                    $log=new AuditTrail();
                    $log->description = 'User ' . Yii::app()->user->Name
                        . ' changed ' . $name . ' for '
                        . get_class($this->Owner)
                        . '[' . $this->Owner->getPrimaryKey() .'].';
                    $log->old_value = $old;
                    $log->new_value = $value;
                    $log->action = 'CHANGE';
                    $log->model = get_class($this->Owner);
                    $log->model_id = $this->Owner->getPrimaryKey();
                    $log->field = $name;
                    $log->creation_date = date('Y-m-d H:i:s');
                    $log->user_id = $userid;

                    $log->save();
                }
            }
        } else {
            $log=new AuditTrail();
            // $this->Owner->getPrimaryKey() is Array
            $modelId = isset($this->Owner->getPrimaryKey()["workstation"])? $this->Owner->getPrimaryKey()["workstation"]:null;
            $log->description = 'User ' . Yii::app()->user->Name
                . ' created ' . get_class($this->Owner)
                . '[' . $modelId .'].';
                //. '[' . $this->Owner->getPrimaryKey() .'].';
            $log->old_value = '';
            $log->new_value = '';
            $log->action=		'CREATE';
            $log->model=		get_class($this->Owner);
            $log->model_id=		 $modelId;
            // $log->model_id=		 $this->Owner->getPrimaryKey();
            $log->field=		'N/A';
            $log->creation_date= date('Y-m-d H:i:s');
            $log->user_id=		 $userid;

            $log->save();


            foreach ($newattributes as $name => $value) {
                $log=new AuditTrail();
                $log->description = 'User ' . Yii::app()->user->Name
                    . ' set field '.$name . ' at ' . get_class($this->Owner)
                    . '[' . $modelId .'].';
                    // . '[' . $this->Owner->getPrimaryKey() .'].';
                $log->old_value = '';
                $log->new_value = $value;
                $log->action=		'SET';
                $log->model=		get_class($this->Owner);
                $log->model_id=		 $modelId;
                //$log->model_id=		 $this->Owner->getPrimaryKey();
                $log->field=		$name;
                $log->creation_date= date('Y-m-d H:i:s');
                $log->user_id=		 $userid;
                $log->save();
            }

        }
        return parent::afterSave($event);
    }

    public function afterDelete($event)
    {

        try {
            $userid = Yii::app()->user->id;
        } catch(Exception $e) {
            $userid = null;
        }

        if(empty($userid)) {
            $userid = null;
        }

        $log=new AuditTrail();
        $log->description = 'User ' . Yii::app()->user->Name . ' deleted '
            . get_class($this->Owner)
            . '[' . $this->Owner->getPrimaryKey() .'].';
        $log->old_value = '';
        $log->new_value = '';
        $log->action=		'DELETE';
        $log->model=		get_class($this->Owner);
        $log->model_id=		 $this->Owner->getPrimaryKey();
        $log->field=		'N/A';
        $log->creation_date= date('Y-m-d H:i:s');
        $log->user_id=		 $userid;
        $log->save();
        return parent::afterDelete($event);
    }

    public function afterFind($event)
    {

        $this->setOldAttributes($this->Owner->getAttributes());

        return parent::afterFind($event);
    }

    public function getOldAttributes()
    {
        return $this->_oldattributes;
    }

    public function setOldAttributes($value)
    {
        $this->_oldattributes=$value;
    }

}