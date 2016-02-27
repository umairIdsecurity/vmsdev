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
class PhotoImport extends CActiveRecord {

    public $db_image;
    public $filename;

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
            array('id, filename, unique_filename, relative_path', 'safe', 'on' => 'search'),
            array('db_image', 'file', 'types' => 'jpg,jpeg,png', 'allowEmpty'=>FALSE,'maxSize' => 1024 * 1024 * 2, 'tooLarge' => 'Size should be less then 2MB !!!', 'on' => 'upload'),
        );
    }

}