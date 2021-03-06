<?php

/**
 * This is the model class for table "files".
 *
 * The followings are the available columns in table 'country':
 * @property string $id
 * @property string $folder_id
 * @property string $user_id
 * @property string $name
 * @property string $uploaded
 * @property string $size
 * @property string $uploader
 * @property string $ext
 */
class File  extends CActiveRecord
{

    public static $EXT_ALLOWED = array(
        'jpg','png','pdf','xls','xlsx','doc','docx','txt','ppt','pptx','xml','jpeg'
    );

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'files';
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userUpload' => array(self::BELONGS_TO  , 'User', 'id'),
            'folder' => array(self::BELONGS_TO, 'Folder', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'file' => 'File',
            'uploaded' => 'Uploaded',
            'size' => 'Size',
            'uploader' => 'Uploaded by',
            'userUpload' => 'User',
        );
    }

    /**
     * @param int $folder : folder id
     * @param bool|false $count : True return number files else return list files
     * @return File[]|int|array
     */
    public function getAllFilesFromFolder($folder = null, $count = false)
    {
        if ($folder) {
            $criteria = new CDbCriteria;

            $criteria->compare('id', $this->id, true);
            $criteria->compare('user_id', $this->user_id, true);
            $criteria->compare('name', $this->file, true);
            if ($folder->name != 'Help Documents')
                $criteria->addCondition("folder_id =" . $folder->id . "");
            else {
                $criteria->addCondition("folder_id =" . $folder->id . "", 'OR');
                $criteria->addCondition("folder_id =0", 'OR');
            }

            $criteria->order = 'uploaded DESC';
            if ($count) {
                $files = $this->count($criteria);
            } else {
                $files = $this->findAll($criteria);
            }
            if ($files) return $files;
        }
        return 0;
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('folder_id', $this->folder_id, true);
        $criteria->compare('file', $this->file, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @param $user_id
     * @return string
     * get name user
     */
    public function getNameUser($user_id){
        $user = User::model()->findByPk($user_id);
        if($user) return $user->first_name .' '.$user->last_name;
        return '';
    }

    /**
     * @param $id
     * @param $name
     * Check Name File Exist
     */
    public function checkFileExist($id,$name){
        $file = File::model()->findAll("file = '$name' AND id <> $id");
        if($file) return true;
        return false;
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

    public function displaySize($size = 0){
        return $this->file_size($size);
    }

    /**
     * @param $size
     * @return string
     */
    public function file_size($size)
    {
        if ($size >= 1073741824) {
            $fileSize = round($size / 1024 / 1024 / 1024, 1) . ' GB';
        } elseif ($size >= 1048576) {
            $fileSize = round($size / 1024 / 1024, 1) . ' MB';
        } elseif ($size >= 1024) {
            $fileSize = round($size / 1024, 1) . ' KB';
        } else {
            $fileSize = $size . ' bytes';
        }
        return $fileSize;
    }

    private function _dateDiff($time1, $time2, $precision = 6) {
        // If not numeric then convert texts to unix timestamps
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }
     
        // If time1 is bigger than time2
        // Then swap time1 and time2
        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }
     
        // Set up intervals and diffs arrays
        $intervals = array('year','month','day','hour','minute','second');
        $diffs = array();
     
        // Loop thru all intervals
        foreach ($intervals as $interval) {
            // Create temp time from time1 and interval
            $ttime = strtotime('+1 ' . $interval, $time1);
            // Set initial values
            $add = 1;
            $looped = 0;
            // Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
                    // Create new temp time from time1 and interval
                    $add++;
                    $ttime = strtotime("+" . $add . " " . $interval, $time1);
                    $looped++;
                }
     
            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            $diffs[$interval] = $looped;
        }
        
        $count = 0;
        $times = array();
        // Loop thru all diffs
        foreach ($diffs as $interval => $value) {
            // Break if we have needed precission
            if ($count >= $precision) {
                break;
            }
            // Add value and interval 
            // if value is bigger than 0
            if ($value > 0) {
                // Add s if value is not 1
                if ($value != 1) {
                    $interval .= "s";
                }
                // Add value and interval to times array
                $times[] = $value . " " . $interval;
                $count++;
            }
        }

        // if 0 second
        if (!$times) {
            $times[] = "0 second";
        }
 
        // Return string with times
        return implode(", ", $times) . ' ago';
    }

    /**
     * @param $date
     * @return string
     */
    public function calculate_time_span($date){

        return self::_dateDiff(strtotime(date('Y-m-d H:i:s')), strtotime($date), 1);
    }

    /**
     * @param int $id
     * @return string
     */
    public function getPathFile($id = 0)
    {
        if ($id > 0) {
            $files = File::model()->findAll("id = $id and user_id =" . Yii::app()->user->id);
            if ($files) {
                $file = $files[0];
                $root = dirname(Yii::app()->request->scriptFile) . '/uploads/files';
                $folderUser = $root . '/' . $file->user_id;
                $folderFile = $folderUser . '/' . $file->folder_id;
                return $folderFile . '/' . $file->file;
            }
        }
        return null;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function linkDownloadFile($id = 0){
        if ($id > 0) {
            $files = File::model()->findAll("id = $id and user_id =" . Yii::app()->user->id);
            if ($files) {
                $file = $files[0];
                return Yii::app()->createUrl("uploadFile/download", array("id" => $file->id));
            }
        }
        return null;
    }


}