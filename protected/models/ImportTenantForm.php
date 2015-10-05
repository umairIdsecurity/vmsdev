<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 4/10/15
 * Time: 7:24 PM
 */
class ImportTenantForm extends CFormModel
{
    public $file;
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('file', 'file', 'types'=>'tenant', 'maxSize'=>1024 * 1024 * 20, // 30MB
                'tooLarge'=>'The file was larger than 20MB. Please upload a smaller file.',
                'allowEmpty' => false,
                'message' => 'Please upload a file.',
                'wrongType' => 'Only tenant files are allowed.'
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'file' => 'Tenant file',
        );
    }
}