<?php

/**
 * This is the model class for table "files".
 *
 * The followings are the available columns in table 'country':
 * @property string $id
 * @property string $key_name
 * @property string $$key_value
 */
class System extends CActiveRecord
{

     const ON = 'ON';
     const OFF = 'OFF';

     public static $EMERGENCY_SHUTDOWN = 'EMERGENCY_SHUTDOWN';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'system';
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'key_name' => 'Key',
            'key_value' => 'Value',
        );
    }

    /**
     * @return bool | System is shutdown
     */
    public function isSystemShutdown()
    {
        $model = $this->model()->find("key_name = '" . System::$EMERGENCY_SHUTDOWN . "'");
        if ($model) {
            if ($model->key_value == System::ON) return true;
        }
        return false;
    }

    public function createNewKey($key_name = '', $key_value = '')
    {
        if($key_name && $key_value){
            $model = new System();
            $model->key_name = $key_name;
            $model->key_value = $key_value;
            $model->save();
            return $model;
        }
        return 0;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CardType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(

            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }

}