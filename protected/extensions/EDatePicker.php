<?php

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 10/03/2016
 * Time: 6:05 PM
 */
Yii::import('zii.widgets.jui.CJuiInputWidget');

class EDatePicker extends CJuiInputWidget
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


    public function run()
    {
        echo $this->build();
    }
    public function build()
    {

        list($name,$id)=$this->resolveNameID();

        $displayId = $id."_container";
        $displayName = $displayId;
        $dateValue = null;
        $displayValue = null;

        if($this->model){
            $dateValue = $this->model[$this->attribute];
        } else {
            $dateValue = $this->value;
        }

        $displayValue = $dateValue?DateUtil::reformat($dateValue,'dd/MM/yyyy'):'';

        if(!isset($this->htmlOptions['placeholder'])) {
            if(isset($this->attribute) && isset($this->model)) {
                $this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
            } else {
                $this->htmlOptions['placeholder'] = "DD/MM/YYYY";
            }
        }





        if($this->mode == 'date_of_birth'){
            $this->ensureOption('yearRange',(Date('Y')-100).':'.(Date('Y')-10));
            $this->ensureOption('defaultDate','01/01/1970');

        } elseif($this->mode == 'asic_expiry'){
            $now         = new DateTime(date('Y-m-d'));
            $asicMaxDate = new DateTime(date('Y-m-d', strtotime('+2 month +2 year')));
            $interval    = $asicMaxDate->diff($now);
            $this->ensureOption('yearRange',(Date('Y')).':'.(Date('Y')+10));
            $this->ensureOption('minDate','0');
            $this->ensureOption('maxDate', $interval->days);

        } elseif($this->mode == 'expiry'){
            $now         = new DateTime(date('Y-m-d'));
            $asicMaxDate = new DateTime(date('Y-m-d', strtotime('+2 month +5 year')));
            $interval    = $asicMaxDate->diff($now);
            $this->ensureOption('minDate','0');
            $this->ensureOption('maxDate',$interval->days);
        }

        $this->ensureOption('dateFormat','dd/mm/yy');
        $this->ensureOption('changeMonth',true);
        $this->ensureOption('changeYear',true);
        $this->ensureOption('constrainInput',false);
        $this->ensureOption('gotoCurrent',true);
        $this->ensureOption('defaultDate',$displayValue);

        $this->language = 'en';
        //$this->ensureOption('language','en');

        $this->ensureOption('altField','#'.$id);
        $this->ensureOption('altFormat','dd-mm-yy');

        $this->ensureHtmlOption('id',$displayId);
        $this->ensureHtmlOption('name',$displayName);
        $this->ensureHtmlOption('size','0');
        $this->ensureHtmlOption('maxlength','10');


        $options=CJavaScript::encode($this->options);
        //$js = "if(!$('#{$displayId}').datepicker('options','dateFormat)){jQuery('#{$displayId}').datepicker();};";
        //$js = $js."jQuery('#{$displayId}').datepicker('option', $options);";
        $js = "jQuery('#{$displayId}').datepicker($options);";

        if($this->language!='' && $this->language!='en')
        {
            $this->registerScriptFile($this->i18nScriptFile);
            $js = "jQuery('#{$displayId}').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['{$this->language}'],{$options}));";
        }


        #render the control
        $html =  CHtml::textField($displayName,$displayValue,$this->htmlOptions)
            ." ". CHtml::hiddenField($name,$dateValue,['id'=>$id]);

        $cs = Yii::app()->getClientScript();


        if(isset($this->defaultOptions))
        {
            $this->registerScriptFile($this->i18nScriptFile);
            $cs->registerScript(__CLASS__,$this->defaultOptions!==null?'jQuery.datepicker.setDefaults('.CJavaScript::encode($this->defaultOptions).');':'');
        }


        $cs->registerScript(__CLASS__.'#'.$displayId,$js);


        return $html;
    }

    public static function formatDate($date){
        return DateUtil::reformat($date,"d/m/Y");
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