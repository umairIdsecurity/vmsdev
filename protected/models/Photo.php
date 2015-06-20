<?php

/**
 * This is the model class for table "photo".
 *
 * The followings are the available columns in table 'photo':
 * @property string $id
 * @property string $filename
 * @property string $unique_filename
 * @property string $relative_path
 *
 * The followings are the available model relations:
 * @property Company[] $companies
 */
class Photo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'photo';
    }
    

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('filename, unique_filename, relative_path', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, filename, unique_filename, relative_path', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'companies' => array(self::HAS_MANY, 'Company', 'logo'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'filename' => 'Filename',
            'unique_filename' => 'Unique Filename',
            'relative_path' => 'Relative Path',
        );
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('filename', $this->filename, true);
        $criteria->compare('unique_filename', $this->unique_filename, true);
        $criteria->compare('relative_path', $this->relative_path, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Photo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getRelativePathOfPhoto($photoId) {
        $relativePath = Photo::model()->findByPK($photoId);
        
        $aArray = array();
            $aArray[] = array(
                'relative_path' => $relativePath->relative_path,
            );
        
        return $aArray;
    }

    public function returnVisitorPhotoRelativePath($visitorId) {
        $visitor = Visitor::model()->findByPK($visitorId);
        if ($visitor->photo != '') {
            $photo = Photo::model()->findByPK($visitor->photo);
            if(file_exists($photo->relative_path)){
                return Yii::app()->getBaseUrl(true)."/".$photo->relative_path;
            }else{
                return $this->defaultImage();
            }
            
        }
    }

    public function returnCompanyPhotoRelativePath($companyId) {
        $company = Company::model()->findByPK($companyId);
        if ($company) {
            if ($company->logo != '') {
                $photo = Photo::model()->findByPK($company->logo);
                if (file_exists($photo->relative_path)) {
                    return Yii::app()->getBaseUrl(true)."/".$photo->relative_path;
                } else {
                  return $this->defaultImage();
                }
            } else {
                return $this->defaultImage();
            }
        } else {
            return $this->defaultImage();
        }
    }
    
    public function returnLogoPhotoRelative($logoId) {
        
        $photo = Photo::model()->findByPK($logoId);
        if ($photo) {
            return $photo->relative_path;
        }
    }
    
    public function defaultImage(){
        return Yii::app()->controller->assetsBase . '/images/companylogohere1.png';
    }

    public function behaviors()
    {
        return array(

            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }
    
   

}
