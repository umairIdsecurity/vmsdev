<?php
 
/**
 * Behavior for Timzone change and time format change. 
 * This behaviour change all date / datetime /and timestamp from db (which in EST5EDT Time zone) 
 * to Asia/Calcutta time zone and convert format to d-m-Y H:i:s / d-m-Y
 * while saving it will convert Asia/Calcutta to EST5EDT time zone and format to Y-m-d H:i:s / Y-m-d.
 *  Component
 * 
 * FULL DESCRIPTION:
 * ================
 * This Behaviour helps to view time/date/timestamp/datetime from db to local Date / Time / Date Time format 
 * and in local Timezone. And save into db in with db timezone and db format. 
 * You only need to include this behaviour in models where need this facility.
 * 
 * INTEGRATION
 * ===========
 * 
 * Palce this file in protected/components
 * 
 * Call behaviour in model by including following code
 * ===================================================
 *   public function behaviors() {
        return array(
            'DateTimeZoneAndFormatBehavior' => 'application.components.DateTimeZoneAndFormatBehavior',
        );
    }
 */
    
class DateTimeZoneAndFormatBehavior extends CActiveRecordBehavior 
{
    
    public $user_timezone;
    public $edtTimeZone = "Australia/Perth"; // use 'Australia/Perth' replace 'EST5EDT' if get error
    public $php_user_short_date = 'd-m-Y';
    public $php_user_time = 'h:iA';
    public $php_user_datetime = 'd-m-Y H:i:s';
    public $php_db_date = 'Y-m-d';
    public $php_db_time = 'H:i:s';
    public $php_db_datetime = 'Y-m-d H:i:s';
    
    public function __construct() {
        $session = new CHttpSession;
        //$this->user_timezone = $session['timezone'];
        
        if($session['timezone'] != ""){
            $this->user_timezone = $session['timezone'];
        } else {
            $this->user_timezone = "Australia/Perth";
        }
    }
    
    public function beforeSave($event) {
        foreach ($event->sender->tableSchema->columns as $columnName => $column) {
            if ($event->sender->$columnName) {
                if ($column->dbType == 'date') {
                    if ($event->sender->$columnName != "0000-00-00") { //checking date field with no value
                        $col_data = date("d-m-Y", strtotime($event->sender->$columnName));
                        $datetime_object = DateTime::createFromFormat($this->php_user_short_date, $col_data, new DateTimeZone($this->user_timezone));
                        if ($datetime_object != false) {
                            $event->sender->$columnName = $datetime_object->format($this->php_db_date);
                        }
                    }
                } else if ($column->dbType == 'datetime' || $column->dbType == 'timestamp') {
                    if ($event->sender->$columnName != '0000-00-00 00:00:00') { //checking field with no value
                        if ($event->sender->$columnName == "NOW()") {
                            $event->sender->$columnName = date("Y-m-d H:i:s");
                        }
                        $col_data = date("d-m-Y H:i:s", strtotime($event->sender->$columnName));
                        $datetime_object = DateTime::createFromFormat($this->php_user_datetime, $col_data, new DateTimeZone($this->user_timezone));
                        $datetime_object->setTimezone(new
                                DateTimeZone($this->edtTimeZone));
                        $event->sender->$columnName =
                                $datetime_object->format($this->php_db_datetime);
                    }
                } else if ($column->dbType == 'time') {
                    $datetime_object = DateTime::createFromFormat($this->php_user_time, $event->sender->$columnName, new DateTimeZone($this->user_timezone));
                    if ($datetime_object != false) {
                        $datetime_object->setTimezone(new DateTimeZone($this->edtTimeZone));
                        $event->sender->$columnName = $datetime_object->format($this->php_db_time);
                    }
                }
            }
        }
        return parent::beforeSave($event);
    }
 
    public function afterFind($event) {
          foreach ($event->sender->tableSchema->columns as $columnName => $column) {
            if (($column->dbType == 'date') ||
                    ($column->dbType == 'time') ||
                    ($column->dbType == 'timestamp') ||
                    ($column->dbType == 'datetime')) {
                $datetime_object = new DateTime($event->sender->$columnName, new DateTimeZone($this->edtTimeZone));
                if ($column->dbType == 'date') {
                    if (date("Y-m-d", strtotime($event->sender->$columnName)) != "1970-01-01") {
                        if ($event->sender->$columnName != '0000-00-00') {
                            $event->sender->$columnName =
                                    $datetime_object->format(
                                    $this->php_user_short_date);
                        }
                    }
                } elseif ($column->dbType == 'datetime' || $column->dbType == 'timestamp') {
                    if (date("Y-m-d", strtotime($event->sender->$columnName)) != "1970-01-01") {
                        if ($event->sender->$columnName != '0000-00-00 00:00:00') {
                            $datetime_object->setTimezone(new
                                    DateTimeZone($this->user_timezone));
                            $event->sender->$columnName =
                                    $datetime_object->format(
                                    $this->php_user_datetime);
                        }
                    }
                } else if ($column->dbType == 'time') {
                    $datetime_object->setTimezone(new
                            DateTimeZone($this->user_timezone));
                    /* Output the required format */
                    $event->sender->$columnName =
                            $datetime_object->format($this->php_user_time);
                }
            }
        }
        return parent::afterFind($event);
    }
}
 
?>