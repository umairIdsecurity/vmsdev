<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 14/03/2016
 * Time: 7:36 PM
 */

Yii::import('CActiveForm');


class EActiveForm extends CActiveForm
{
    public $readOnly = false;

    public function textField($model, $attribute, $htmlOptions = [])
    {
       return parent::textField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function checkBox($model, $attribute, $htmlOptions = [])
    {
        return parent::checkBox($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function dropDownList($model, $attribute, $data, $htmlOptions = [])
    {
        return parent::dropDownList($model, $attribute, $data, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly', 'disabled'=>'disabled'] : []));

    }

    public function emailField($model, $attribute, $htmlOptions = [])
    {
        return parent::emailField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function listBox($model, $attribute,$data, $htmlOptions = [])
    {
        return parent::listBox($model, $attribute,$data, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function numberField($model, $attribute, $htmlOptions = [])
    {
        return parent::numberField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function passwordField($model, $attribute, $htmlOptions = [])
    {
        return parent::passwordField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function radioButton($model, $attribute, $htmlOptions = [])
    {
        return parent::radioButton($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function radioButtonList($model, $attribute, $data, $htmlOptions = [])
    {
        return parent::radioButtonList($model, $attribute, $data, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function searchField($model, $attribute, $htmlOptions = [])
    {
        return parent::searchField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function telField($model, $attribute, $htmlOptions = [])
    {
        return parent::telField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function colorField($model, $attribute, $htmlOptions = [])
    {
        return parent::colorField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function checkBoxList($model, $attribute,$data, $htmlOptions = [])
    {
        return parent::checkBoxList($model,$attribute,$data,array_merge($htmlOptions,$this->readOnly?['readOnly' => 'readOnly']:[]));
    }

    public function dateField($model, $attribute,$options = [], $htmlOptions = [])
    {
        if($this->readOnly){

            Chtml::resolveNameID($model,$attribute,$htmlOptions);
            return Chtml::textField($htmlOptions['name'],
                                    EDatePicker::formatDate($model->attributes[$attribute]),
                                    array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly','disabled'=>'disabled'] : []));
        } else {
            $picker = $this->widget('EDatePicker',
                                    array_merge(['model'=>$model,'attribute'=>$attribute,'htmlOptions'=>$htmlOptions]
                                                ,$options));
            //return $picker->build();
            return "";
        }

        //return parent::dateField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
        //return parent::dateField($model, $attribute, $htmlOptions);
    }

    public function dateTimeField($model, $attribute, $htmlOptions = [])
    {
        return parent::dateTimeField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function dateTimeLocalField($model, $attribute, $htmlOptions = [])
    {
        return parent::dateTimeLocalField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function textArea($model, $attribute, $htmlOptions = [])
    {
        return parent::textArea($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function timeField($model, $attribute, $htmlOptions = [])
    {
        return parent::timeField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function urlField($model, $attribute, $htmlOptions = [])
    {
        return parent::urlField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function weekField($model, $attribute, $htmlOptions = [])
    {
        return parent::weekField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function submitButton($label,$htmlOptions){
        $result = "";
        if(!$this->readOnly) {
            $result =  CHtml::submitButton($label, array_merge($htmlOptions, $this->readOnly ? ['disabled' => 'disabled'] : []));
        }
        return $result;
    }


}