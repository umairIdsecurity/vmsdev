<?php

/**
 * This is the model class for table "user_workstations".
 *
 * The followings are the available columns in table 'user_workstations':
 * @property integer $id
 * @property integer $user
 * @property integer $workstation
 * @property integer $created_by
 *
 * The followings are the available model relations:
 * @property Workstations $workstation0
 * @property User $createdBy
 * @property User $user0
 */
class UserWorkstations extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_workstation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user, workstation', 'required'),
			array('user, workstation, created_by', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user, workstation, created_by', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'workstation0' => array(self::BELONGS_TO, 'Workstations', 'workstation'),
			'createdBy' => array(self::BELONGS_TO, 'User', 'created_by'),
			'user0' => array(self::BELONGS_TO, 'User', 'user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user' => 'User',
			'workstation' => 'Workstation',
			'created_by' => 'Created By',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user',$this->user);
		$criteria->compare('workstation',$this->workstation);
		$criteria->compare('created_by',$this->created_by);
		//$criteria->compare('created_by',$this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserWorkstations the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getAllworkstations($userid){
            $connection = Yii::app()->db;
                $sql ="SELECT workstation.name as name
                        FROM user_workstation 
                        LEFT JOIN workstation ON workstation.id=user_workstation.`workstation`
                        WHERE user_workstation.`user`='$userid' ORDER BY workstation.name";
                $command = $connection->createCommand($sql);
                $row = $command->queryAll();
                
                if (count($row)>0)
                {
                    $res = array();
                    foreach ($row as $key=>$val) {
                       $res[] = $val;
                    }
                    $resp= array();
                    foreach ($res as $workstations){
                        $resp [] = $workstations;
                    }
                    foreach ($resp as $val){
                        $copy = $resp;
                        foreach ($val as $v){
                            echo $v;
                            if(!next($copy))
                            {echo "<br>";}
                        }
                     }
                }
                else {
                    return $result = '-'; 
                }
        }
}
