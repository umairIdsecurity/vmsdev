<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 10/03/2016
 * Time: 6:05 PM
 */
class EDatePicker extends CInputWidget
{

    public $mode = null;


    /**
     * @var string the locale ID (eg 'fr', 'de') for the language to be used by the date picker.
     * If this property is not set, I18N will not be involved. That is, the date picker will show in English.
     * You can force English language by setting the language attribute as '' (empty string)
     */
    public $language;
    /**
     * @var string The i18n Jquery UI script file. It uses scriptUrl property as base url.
     */
    public $i18nScriptFile='jquery-ui-i18n.min.js';
    /**
     * @var array The default options called just one time per request. This options will alter every other CJuiDatePicker instance in the page.
     * It has to be set at the first call of CJuiDatePicker widget in the request.
     */
    public $defaultOptions;
    /**
     * @var boolean If true, shows the widget as an inline calendar and the input as a hidden field.
     */
    public $flat=false;

    public $options = [];


    public function run(){

        list($name,$id)=$this->resolveNameID();


        $displayId = $id."_container";
        $displayName = $name."_container";




        if($this->model){
            $displayValue = $this->reformatDate($this->model[$this->attribute],'d/m/y');
            echo CHtml::activeHiddenField($this->model,$this->attribute,$this->htmlOptions);
            echo CHtml::textField($displayName,$displayValue,$this->htmlOptions);
            $this->options['defaultDate'] = $displayValue;

        } else {
            $displayValue = $this->reformatDate($this->value,'d/m/y');
            echo CHtml::hiddenField($this->name,$this->value,$this->htmlOptions);
            echo CHtml::textField($displayName,$displayValue,$this->htmlOptions);
        }

        $this->options['altField'] = '#'.$id;
        $this->options['altFormat'] = 'yyyy-mm-dd';
        $this->options['dateFormat'] = 'dd/mm/yy';
        $this->options['changeMonth'] = true;
        $this->options['changeYear'] = true;
        $this->options['constrainInput'] = true;
        $this->options['gotoCurrent'] = true;

        if($this->mode == 'date_of_birth'){
            $this->options['yearRange'] = (Date('Y')-100).':'.(Date('Y')-10);
        } elseif($this->mode == 'expiry'){
            $this->options['yearRange'] = (Date('Y')).':'.(Date('Y')+10);
            $this->options['minDate'] = Date('Y-m-d');
        }

        $this->htmlOptions['id']=$displayId;
        $this->htmlOptions['name'] = $displayName;


        //$this->htmlOptions['id']=$displayId;
        //$this->htmlOptions['name']=$displayName;

        $options=CJavaScript::encode($this->options);
        $js = "jQuery('#{$displayId}').datepicker($options);";

        if($this->language!='' && $this->language!='en')
        {
            $this->registerScriptFile($this->i18nScriptFile);
            $js = "jQuery('#{$displayId}').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['{$this->language}'],{$options}));";
        }

        $cs = Yii::app()->getClientScript();

        if(isset($this->defaultOptions))
        {
            $this->registerScriptFile($this->i18nScriptFile);
            $cs->registerScript(__CLASS__,$this->defaultOptions!==null?'jQuery.datepicker.setDefaults('.CJavaScript::encode($this->defaultOptions).');':'');
        }
        $cs->registerScript(__CLASS__.'#'.$displayId,$js);
    }


    private function reformatDate($date,$format){

        $ts = CDateTimeParser::parse($date,'yyyy-MM-dd');
        return date('d/m/Y',$ts);

    }
}