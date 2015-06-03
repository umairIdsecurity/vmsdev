<?php

/**
 * This is the model class for table "import_visitor".
 *
 * The followings are the available columns in table 'import_visitor':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $company
 * @property string $check_in_date
 * @property string $check_out_date
 * @property string $card_code
 * @property integer $imported_by
 * @property integer $import_date
 * @property date $date_printed
 * @property date $date_expiration
 * @property string $check_in_time
 * @property string $check_out_time
 * @property string $position
 * @property string $vehicle
 * @property string $contact_number
 */
class ImportVisitor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'import_visitor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, email, company, check_in_date, check_out_date, imported_by, import_date', 'required'),
			array('first_name, last_name, email, company, card_code', 'length', 'max'=>255),
			array('check_in_date, check_out_date, card_code, date_printed, date_expiration, check_in_time, check_out_time, position, vehicle, contact_number', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, card_code, first_name, last_name, email, company, check_in_date, check_out_date,  card_code, date_printed, date_expiration, check_in_time, check_out_time, position, vehicle, contact_number', 'safe', 'on'=>'search'),
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
//                    "visitor"=>array(self::BELONGS_TO, 'Visitor', 'email')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
                        'card_code' =>'Card Code',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'company' => 'Company',
			'check_in_date' => 'Check In Date',
			'check_out_date' => 'Check Out Date',
                        'imported_by'=>'Imported By',
                        'import_date'=>'Date imported',
                        'date_printed'=> 'Card Date Printed', 
                        'date_expiration'=> 'Card Expiration', 
                        'check_in_time'=> 'Check In Time', 
                        'check_out_time'=> 'Check Out Time', 
                        'position'=>'Position', 
                        'vehicle'=>'Vehicle',
                        'contact_number' =>'Contact Number'
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
               
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('check_in_date',$this->check_in_date,true);
		$criteria->compare('check_out_date',$this->check_out_date,true);
                $criteria->compare('imported_by',$this->imported_by,true);
                $criteria->compare('import_date',$this->import_date,true);
                $criteria->compare('card_code',$this->card_code,true);
                
                $criteria->compare('date_printed',$this->date_printed,true);
                $criteria->compare('date_expiration',$this->date_expiration,true);
                $criteria->compare('check_in_time',$this->check_in_time,true);
                $criteria->compare('check_out_time',$this->check_out_time,true);
                $criteria->compare('position',$this->position,true);
                $criteria->compare('vehicle',$this->vehicle,true);
                $criteria->compare('contact_number',$this->contact_number,true);
                
//                $criteria->select = "t.*";
//                $criteria->join = 'INNER JOIN visitor v on v.email = t.email';
                $criteria->addCondition('imported_by = '.Yii::app()->user->id);
//                $criteria->group = 'v.email';
                   
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImportVisitor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        /**
         * Change date Formate
         * 
         */
    protected function afterFind ()
    {
            // convert to display format
        $this->check_in_date = date("d-m-Y", strtotime ($this->check_in_date) );
        $this->check_out_date = date("d-m-Y", strtotime ($this->check_out_date) );
        $this->import_date = date("d-m-Y", strtotime ($this->import_date) );
        $this->date_printed = date("d-m-Y", strtotime ($this->date_printed) );
        $this->date_expiration = date("d-m-Y", strtotime ($this->date_expiration) );

        parent::afterFind ();
    }
    /**
     * Convert date to DB formate Y-m-d
     */
    protected function beforeSave() {
         
        $this->check_in_date = date("Y-m-d", strtotime ($this->check_in_date) );
        $this->check_out_date = date("Y-m-d", strtotime ($this->check_out_date) );
        $this->import_date = date("Y-m-d", strtotime ($this->import_date) );
        $this->date_printed = date("Y-m-d", strtotime ($this->date_printed) );
        $this->date_expiration = date("Y-m-d", strtotime ($this->date_expiration) );
        
        return parent::beforeSave();
    }
      
    /**
     * save Duplicate 
     * @param type $line
     * @return booleanSa
     */
    public function saveVisitors( $line ) {
        // Insert ONLY DUPLICATE Into Temp table to resolve duplicate visitor record. 
                                           
                            $this->first_name = $line[0];
                            $this->last_name = $line[1];
                            $this->email = $line[2];
                            $this->check_in_date  = date("Y-m-d", strtotime($line[3]));
                            $this->check_in_time  = $line[4];                           
                            $this->check_out_date = date("Y-m-d", strtotime($line[5]) );
                            $this->check_out_time = $line[6];
                            $this->company = $line[7];
                            $this->position = $line[8];
                            $this->card_code = $line[9];
                            $this->date_printed = date("Y-m-d", strtotime($line[10]));
                            $this->date_expiration = date("Y-m-d", strtotime($line[11]));
                            //$this->vehicle = $line[12];
                            $this->contact_number = $line[12];
                            
                            $this->imported_by = Yii::app()->user->id;
                            $this->import_date = date("Y-m-d");
                            
                            if( $this->validate() ) {
                                $this->save();
                                return true; // Duplicate found. Just a flag to redirect admin to resolve duplicate entries. 
                            } else 
                                return false;
    }

    public function behaviors()
    {
        return array(

            'AuditTrailBehaviors'=>
                'application.components.behaviors.AuditTrailBehaviors',
        );
    }

}
