<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 25/03/2016
 * Time: 1:41 PM
 */
class EDateRangeManager extends CWidget
{

    public $model;
    public $startAttribute;
    public $endAttribute;
    public $options;


    public function run(){

        $startField = get_class($this->model).'_'.$this->startAttribute;
        $endField = get_class($this->model).'_'.$this->endAttribute;

        $cs = Yii::app()->getClientScript();
        $baseUrl = Yii::app()->controller->assetsBase;
        $cs->registerScriptFile($baseUrl.'/js/daterangemanager.js');

        $js = "DateRangeManager(jQuery('#$startField'),jQuery('#$endField'),".CJavaScript::encode($this->options).");";

        $cs->registerScript(__CLASS__.'#'.$startField.'#'.$endField,$js);

    }

}