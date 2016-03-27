<?php

/**
 * Created by PhpStorm.
 * User: geoffstewart
 * Date: 20/03/2016
 * Time: 11:03 AM
 */
Yii::import('zii.widgets.jui.CJuiInputWidget');

class ETimePicker extends CJuiInputWidget
{

    public $model;
    public $attribute;
    public $value;
    public $htmlOptions = [];
    public $options = [];
    public $language = 'en';

    public function run()
    {
        echo $this->build();
    }

    public function build()
    {

        list($name,$id)=$this->resolveNameID();



        if($this->model){
            $dateValue = $this->model[$this->attribute];
        } else {
            $dateValue = $this->value;
        }

        if(!isset($this->htmlOptions['placeholder'])) {
            if(isset($this->attribute) && isset($this->model)) {
                $this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
            } else {
                $this->htmlOptions['placeholder'] = "HH:MM AM/PM";
            }
        }

        $this->ensureOption('timeFormat','H:i');


        //$this->language = 'en';

        $this->ensureHtmlOption('id',$id);
        $this->ensureHtmlOption('name',$name);

        $options=CJavaScript::encode($this->options);
        $js = "jQuery('#{$id}').timeEntry($options);";

        if($this->language!='' && $this->language!='en')
        {
            $this->registerScriptFile($this->i18nScriptFile);
            $js = "jQuery('#{$id}').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['{$this->language}'],{$options}));";
        }


        #render the control
        if($this->model){
            $html =  CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
        } else {
            $html =  CHtml::textField($name,$this->value,$this->htmlOptions);
        }


        $cs = Yii::app()->getClientScript();


        if(isset($this->defaultOptions))
        {
            $this->registerScriptFile($this->i18nScriptFile);
            $cs->registerScript(__CLASS__,$this->defaultOptions!==null?'jQuery.timePicker.setDefaults('.CJavaScript::encode($this->defaultOptions).');':'');
        }




        $baseUrl = Yii::app()->controller->assetsBase;
        $cs->registerCssFile($baseUrl."/css/jquery.timeentry.css");
        $cs->registerScriptFile($baseUrl.'/js/jquery.plugin.js');
        $cs->registerScriptFile($baseUrl.'/js/jquery.timeentry.js');

        $cs->registerScript(__CLASS__.'#'.$id,$js);


        return $html;

    }
    private function ensureOption($name,$value){
        if(!isset($this->options[$name])){
            $this->options[$name] = $value;
        }
    }

    private function ensureHtmlOption($name,$value){
        if(!isset($this->htmlOptions[$name])){
            $this->htmlOptions[$name] = $value;
        }
    }


}