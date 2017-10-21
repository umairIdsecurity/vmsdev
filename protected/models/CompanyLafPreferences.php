<?php

/**
 * This is the model class for table "company_laf_preferences".
 *
 * The followings are the available columns in table 'company_laf_preferences':
 * @property string $id
 * @property string $logo
 * @property string $action_forward_bg_color
 * @property string $action_forward_hover_color
 * @property string $action_forward_font_color
 * @property string $complete_bg_color
 * @property string $complete_hover_color
 * @property string $complete_font_color
 * @property string $neutral_bg_color
 * @property string $neutral_hover_color
 * @property string $neutral_font_color
 *
 * The followings are the available model relations:
 * @property Company[] $companies
 */
class CompanyLafPreferences extends CActiveRecord
{
    public $logo;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'company_laf_preferences';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('logo', 'length', 'max'=>20),
			array('css_file_path', 'safe'),
			array(
                            'action_forward_bg_color,action_forward_bg_color2, '
                            . 'action_forward_hover_color,action_forward_hover_font_color,action_forward_hover_color2, '
                            . 'action_forward_font_color, '
                            . 'complete_bg_color, '
                            . 'complete_hover_color,complete_hover_font_color,complete_hover_color2, '
                            . 'complete_font_color, '
                            . 'neutral_bg_color,neutral_hover_font_color,complete_bg_color2,neutral_bg_color2,neutral_hover_color2, '
                            . 'neutral_hover_color, '
                            . 'neutral_font_color,nav_bg_color,nav_hover_color,nav_font_color,nav_hover_font_color,'
                            . 'sidemenu_bg_color,sidemenu_hover_color,sidemenu_font_color,sidemenu_hover_font_color', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, logo, '
                            . 'action_forward_bg_color,complete_bg_color2, '
                            . 'css_file_path,'
                            . 'action_forward_hover_color,action_forward_hover_font_color,action_forward_hover_color2,action_forward_bg_color2, '
                            . 'action_forward_font_color, '
                            . 'complete_bg_color, '
                            . 'complete_hover_color, complete_hover_font_color,complete_hover_color2,'
                            . 'complete_font_color, '
                            . 'neutral_bg_color, neutral_hover_font_color,neutral_bg_color2,neutral_hover_color2,'
                            . 'neutral_hover_color, neutral_font_color,nav_bg_color,nav_hover_color,nav_font_color,nav_hover_font_color,'
                            . 'sidemenu_bg_color,sidemenu_hover_color,sidemenu_font_color,sidemenu_hover_font_color', 'safe', 'on'=>'search'),
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
			'companies' => array(self::HAS_MANY, 'Company', 'company_laf_preferences'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'logo' => 'Logo',
			'action_forward_bg_color' => 'Action Forward Background Color',
			'complete_bg_color2' => 'Action Forward Background Color 2',
			'action_forward_hover_color' => 'Action Forward Hover Color',
			'action_forward_font_color' => 'Action Forward Font Color',
			'action_forward_hover_font_color' => 'Action Forward Hover Font Color',
			'complete_bg_color' => 'Complete Background Color',
			'complete_hover_color' => 'Complete Hover Color',
			'complete_font_color' => 'Complete Font Color',
			'complete_hover_font_color' => 'Complete Hover Font Color',
			'neutral_bg_color' => 'Neutral Background Color',
			'neutral_hover_color' => 'Neutral Hover Color',
			'neutral_font_color' => 'Neutral Font Color',
			'neutral_hover_font_color' => 'Neutral Hover Font Color',
                    
			'nav_bg_color' => 'Navigation Menu Background Color',
			'nav_hover_color' => 'Navigation Menu Hover Color',
			'nav_font_color' => 'Navigation Menu Font Color',
			'nav_hover_font_color' => 'Navigation Menu Hover Font Color',
			
                        'sidemenu_bg_color' => 'Side Menu Background Color',
			'sidemenu_hover_color' => 'Side Menu Hover Color',
			'sidemenu_font_color' => 'Side Menu Font Color',
			'sidemenu_hover_font_color' => 'Side Menu Hover Font Color',
			'css_file_path' => 'CSS File Path',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('action_forward_bg_color',$this->action_forward_bg_color,true);
		$criteria->compare('action_forward_bg_color2',$this->action_forward_bg_color2,true);
		$criteria->compare('complete_bg_color2',$this->complete_bg_color2,true);
		$criteria->compare('action_forward_hover_color',$this->action_forward_hover_color,true);
		$criteria->compare('action_forward_hover_color2',$this->action_forward_hover_color2,true);
		$criteria->compare('action_forward_font_color',$this->action_forward_font_color,true);
		$criteria->compare('action_forward_hover_font_color',$this->action_forward_hover_font_color,true);
		$criteria->compare('complete_bg_color',$this->complete_bg_color,true);
		$criteria->compare('complete_hover_color',$this->complete_hover_color,true);
		$criteria->compare('complete_hover_color2',$this->complete_hover_color2,true);
		$criteria->compare('complete_font_color',$this->complete_font_color,true);
		$criteria->compare('complete_hover_font_color',$this->complete_hover_font_color,true);
		$criteria->compare('neutral_bg_color',$this->neutral_bg_color,true);
		$criteria->compare('neutral_bg_color2',$this->neutral_bg_color2,true);
		$criteria->compare('neutral_hover_color',$this->neutral_hover_color,true);
		$criteria->compare('neutral_hover_color2',$this->neutral_hover_color2,true);
		$criteria->compare('neutral_font_color',$this->neutral_font_color,true);
		$criteria->compare('neutral_hover_font_color',$this->neutral_hover_font_color,true);
		
                $criteria->compare('nav_bg_color',$this->nav_bg_color,true);
		$criteria->compare('nav_hover_color',$this->nav_hover_color,true);
		$criteria->compare('nav_font_color',$this->nav_font_color,true);
		$criteria->compare('nav_hover_font_color',$this->nav_hover_font_color,true);
                
                $criteria->compare('sidemenu_bg_color',$this->sidemenu_bg_color,true);
		$criteria->compare('sidemenu_hover_color',$this->sidemenu_hover_color,true);
		$criteria->compare('sidemenu_font_color',$this->sidemenu_font_color,true);
		$criteria->compare('sidemenu_hover_font_color',$this->sidemenu_hover_font_color,true);
		$criteria->compare('css_file_path',$this->css_file_path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserLafPreferences the static model class
	 */
	public static function model($className=__CLASS__)
	{
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
