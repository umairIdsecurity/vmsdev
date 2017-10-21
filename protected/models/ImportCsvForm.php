<?php
class ImportCsvForm extends CFormModel
{
    public $file;
	public $file1;
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
		if(Yii::app()->controller->action->id=='lodgedApplicants' || Yii::app()->controller->action->id=='approvedApplicants'  )
		{        
			return array(  
             array('file,file1', 'file', 'types'=>'csv,xlsx,xls', 'maxSize'=>1024 * 1024 * 10, // 10MB
                            'tooLarge'=>'The file was larger than 10MB. Please upload a smaller file.',
                            'allowEmpty' => true,
                            'message' => 'Please upload a file.',
                            'wrongType' => 'Only CSV files are allowed.'                             
                   ),
             );
		}
		else
		{
			
			return array(  
             array('file', 'file', 'types'=>'csv', 'maxSize'=>1024 * 1024 * 10, // 10MB
                            'tooLarge'=>'The file was larger than 10MB. Please upload a smaller file.',
                            'allowEmpty' => false,
                            'message' => 'Please upload a file.',
                            'wrongType' => 'Only CSV files are allowed.'                             
                   ),
             );
		}
    }
 
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'file' => 'CSV file',
        );
    }
 
}