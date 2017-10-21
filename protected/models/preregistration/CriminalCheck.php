<?php
class CriminalCheck extends CFormModel{
    public $radiobutton1;
	public $radiobutton2;
	public $radiobutton3;
	public $radiobutton4;
	public $check1;
	public $check2;
	public $check3;
	

	//public $victype;
    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(

            array('radiobutton1', 'required' , 'message'=>'Please choose one of the type'),
			array('radiobutton2', 'required' , 'message'=>'Please choose one of the type'),
			array('radiobutton3', 'required' , 'message'=>'Please choose one of the type'),
			array('radiobutton4', 'required' , 'message'=>'Please choose one of the type'),
			array('check1', 'required' , 'message'=>'Please check the checkbox above'),
			array('check2', 'required' , 'message'=>'Please check the checkbox above'),
			array('check3', 'required' , 'message'=>'Please check the checkbox above'),

			
        );
    }
    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'radiobutton1'=>'Ans1',
			'radiobutton2'=>'Ans2',
			'radiobutton3'=>'Ans3',
			'radiobutton4'=>'Ans4',
			'check1'=>'Check1',
			'check2'=>'Check2',
			'check3'=>'Check3',
	
        );
    }
	
}