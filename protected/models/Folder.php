<?php

/**
 * This is the model class for table "folders".
 *
 * The followings are the available columns in table 'country':
 * @property string $id
 * @property string $parent_id
 * @property string $user_id
 * @property string $name
 * @property string $date_created
 */
class Folder extends CActiveRecord
{
    public static $DEFAULT_LIST_FOLDERS = array(
            'Help Documents',
            'Contracts',
            'Inbox',
    );

    public function rules()
    {
        return array(
            array('name, user_id', 'required'),
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'folders';
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userCreate' => array(self::BELONGS_TO, 'User', 'id'),
            'files' => array(self::HAS_MANY, 'File', 'folder_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name'
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('name', $this->name, true);

        #if( Yii::app()->user->role == Roles::ROLE_ADMIN )
            $criteria->addCondition("user_id ='" . Yii::app()->user->id . "'");

        $data =  new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));

        $data->setTotalItemCount(count($data->getData()));
        $data->pagination->setItemCount(count($data->getData()));

        return $data;
    }

    /**
     * @param int $id current user login system
     * @return array|null (id,name,number file)
     * @inheritdoc  array include many level
     */
    public function getAllFoldersOfCurrentUser($user_id = 0)
    {
        if ($user_id > 0) {

            $criteria = new CDbCriteria;

            $criteria->compare('id', $this->id, true);
            $criteria->compare('user_id', $this->user_id, true);
            $criteria->compare('name', $this->name, true);
            $criteria->addCondition("user_id ='" . $user_id . "'");

            $criteria->order = 'date_created ASC';

            $folders = $this->findAll($criteria);
            if ($folders) {
                $list = array();
                foreach ($folders as $folder) {
                    $list[$folder->parent_id][] = array('default' => $folder->default, 'name' => $folder->name, 'number_file' => count(File::model()->getAllFilesFromFolder($folder,true)));
                }
                return $list;
            }
        }
        return null;
    }

    /**
     * @param $user_id
     * @return CDbDataReader|mixed|string
     * return number folder of current user.
     */
    public function getNumberFolders($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition("user_id ='" . $user_id . "'");
        $count = $this->count($criteria);
        return $count;
    }

    /**
     * check name folder has exist.
     * @param $user_id
     * @param $name
     */
    public function checkNameExist($user_id,$name){
        if($user_id && $name){
            $criteria = new CDbCriteria;
            $criteria->addCondition("user_id ='" . $user_id . "'");
            $criteria->addCondition("name ='" . $name . "'");
            $folders = $this->findAll($criteria);
            if($folders){
                return true;
            }

        }
        return false;
    }


    /**
     * Check and Create default Folder if has yet
     * @param int $user_id
     */
    public function setDefaultFoldersForUser($user_id = 0)
    {
        if ($this->getAllFoldersOfCurrentUser($user_id) == null && $user_id != 0) {
            foreach (Folder::$DEFAULT_LIST_FOLDERS as $name) {
                $folder = new Folder();
                $folder->name = $name;
                $folder->user_id = $user_id;
                if ($name == 'Help Documents')
                    $folder->default = 1;
                $folder->save();
            }

        }
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