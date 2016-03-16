<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 14/03/2016
 * Time: 7:36 PM
 */
class EActiveForm extends CActiveForm
{
    public $readOnly = false;

    public function textField($model, $attribute, $htmlOptions = [])
    {
        parent::textField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function checkBox($model, $attribute, $htmlOptions = [])
    {
        parent::checkBox($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function dropDownList($model, $attribute, $data, $htmlOptions = [])
    {
        parent::dropDownList($model, $attribute, $data, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function emailField($model, $attribute, $htmlOptions = [])
    {
        parent::emailField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function listBox($model, $attribute, $htmlOptions = [])
    {
        parent::listBox($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function numberField($model, $attribute, $htmlOptions = [])
    {
        parent::numberField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function passwordField($model, $attribute, $htmlOptions = [])
    {
        parent::passwordField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function radioButton($model, $attribute, $htmlOptions = [])
    {
        parent::radioButton($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function radioButtonList($model, $attribute, $data, $htmlOptions = [])
    {
        parent::radioButtonList($model, $attribute, $data, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function searchField($model, $attribute, $htmlOptions = [])
    {
        parent::searchField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function telField($model, $attribute, $htmlOptions = [])
    {
        parent::telField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function colorField($model, $attribute, $htmlOptions = [])
    {
        parent::colorField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function checkBoxList($model, $attribute,$data, $htmlOptions = [])
    {
        parent::checkBoxList($model,$attribute,$data,array_merge($htmlOptions,$this->readOnly?['readOnly' => 'readOnly']:[]));
    }

    public function dateField($model, $attribute, $htmlOptions = [])
    {
        parent::dateField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function dateTimeField($model, $attribute, $htmlOptions = [])
    {
        parent::dateTimeField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function dateTimeLocalField($model, $attribute, $htmlOptions = [])
    {
        parent::dateTimeLocalField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function textArea($model, $attribute, $htmlOptions = [])
    {
        parent::textArea($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function timeField($model, $attribute, $htmlOptions = [])
    {
        parent::timeField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function urlField($model, $attribute, $htmlOptions = [])
    {
        parent::urlField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }

    public function weekField($model, $attribute, $htmlOptions = [])
    {
        parent::weekField($model, $attribute, array_merge($htmlOptions, $this->readOnly ? ['readOnly' => 'readOnly'] : []));
    }


}