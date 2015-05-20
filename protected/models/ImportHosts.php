<?php

/**
 * This is the model class for table "import_hosts".
 *
 * The followings are the available columns in table 'import_hosts':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $department
 * @property string $staff_id
 * @property string $contact_number
 * @property string $company
 * @property integer $imported_by
 * @property string $date_imported
 * @property string $password
 * @property integer $role
 */
class ImportHosts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'import_hosts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, email, department, staff_id, contact_number', 'required'),
			array('imported_by, role', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, department, staff_id, contact_number, company, password, position', 'length', 'max'=>50),
			array('email', 'length', 'max'=>255),
			array('date_imported, date_of_birth', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, last_name, email, department, staff_id, contact_number, company, imported_by, date_imported, password, role, date_of_birth, position', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'department' => 'Department',
			'staff_id' => 'Staff ID',
			'contact_number' => 'Contact Number',
			'company' => 'Company',
			'imported_by' => 'Imported By',
			'date_imported' => 'Date Imported',
			'password' => 'Password',
			'role' => 'Role',
                        'position' => 'Position',
                        'date_of_birth' => 'Date of Birth',
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
		$criteria->compare('department',$this->department,true);
		$criteria->compare('staff_id',$this->staff_id,true);
		$criteria->compare('contact_number',$this->contact_number,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('imported_by',$this->imported_by);
		$criteria->compare('date_imported',$this->date_imported,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('role',$this->role);
                $criteria->compare('position',$this->position);
                $criteria->compare('date_of_birth',$this->date_of_birth);
                // Show Logged in user specific records
                $criteria->addCondition("imported_by = ".Yii::app()->user->id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ImportHosts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         * Insert Duplicate Records
         * 
         * @param type $line
         */
        public function saveImportHosts ($line ) {
             
            $session = new CHttpSession;
            $this->first_name = $line[0];
            $this->last_name = $line[1];
            $this->email = $line[2];
            $this->department = $line[3];                    
            $this->staff_id = $line[4];                        
            $this->contact_number = $line[5];
            $this->date_of_birth = date("Y-m-d", strtotime($line[6]));
            $this->position = $line[7];
            
            $this->role = Roles::ROLE_STAFFMEMBER;  
            $this->company = $session["company"];
            $this->imported_by = Yii::app()->user->id;
            $this->date_imported = date("Y-m-d");
            if($this->validate()) {
                $this->save();
                return true;
            }
            else return false;
        }
        
  /**
     * Change date Formate 
   */
    protected function afterFind ()
    {
            // convert to display format
        $this->date_of_birth = date("d-m-Y", strtotime ($this->date_of_birth) );
        parent::afterFind ();
    }
    /**
     * Change date format to DB format 
     * 
     * @return type
     */
    protected function beforeSave() {
         
        $this->date_of_birth = date("Y-m-d", strtotime ($this->date_of_birth) );
         return parent::beforeSave();
   }
}
