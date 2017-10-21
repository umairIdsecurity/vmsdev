<?php
class AsicType extends CFormModel{
    public $asictype;
	public $asicno;
	public $accno;
	public $accname;
	public $bsb;
	public $asicexpiry;
	public $radiobutton;
	Public $radiobutton2;
	public $renewal;
	//public $victype;
    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(

            array('radiobutton', 'required' , 'message'=>'Please choose one of the type'),
			array('renewal','ext.validator.RadioCustom', 'radiobutton'=>$this->radiobutton),
			array('radiobutton2','required','message'=>'Please choose Company or Card holder'),
			//array('asicno', 'required' , 'message'=>'Please enter {attribute}', 'on'=>'replacement'),
			//array('asicexpiry','required' , 'message'=>'Please enter {attribute}', 'on'=>'replacement'),
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
            'asictype'=>'Asic Type',
			'asicno'=>'Asic Number',
			'asicexpiry'=>'Asic expiry',
			'radiobutton'=>'Radio button',
			'accno'=>'Account Number',
			'bsb'=>'BSB',
			'accname'=>'Account Name',
			'radiobutton2'=>'Paid By',
			'renewal'=>'Renewal'
        );
    }
	
}