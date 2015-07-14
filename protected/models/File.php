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
 */
class File  extends CActiveRecord
{
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
            'userUpload' => array(self::BELONGS_TO, 'User', 'id'),
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
            'upload' => 'Uploaded',
            'size' => 'Size',
            'upload_by' => 'Uploaded by'
        );
    }

    /**
     * @param int $folder : folder id
     * @param bool|false $count : True return number files else return list files
     * @return File[]|int|array
     */
    public function getAllFilesFromFolder($folder = 0, $count = false)
    {
        if ($folder) {
            $criteria = new CDbCriteria;

            $criteria->compare('id', $this->id, true);
            $criteria->compare('user_id', $this->user_id, true);
            $criteria->compare('name', $this->file, true);

            if ($folder->name != 'Help Documents')
                $criteria->addCondition("folder_id ='" . $folder->id . "'");
            else {
                $criteria->addCondition("folder_id ='" . $folder->id . "'", 'OR');
                $criteria->addCondition("folder_id ='0'");
            }

            $criteria->order = 'uploaded DESC';

            $files = $this->findAll($criteria);
            if ($files) return $count ? count($files) : $files;
        }
        return null;
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