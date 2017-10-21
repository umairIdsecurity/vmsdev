<?php
class jqueryDateTime extends CInputWidget {

    public $attribute;
    public $name;
    public $value;
    public $htmlOptions;
    public $options;
        
    public function init() {
        if (!isset($this->options['allowTimes'])) {
            $this->options['allowTimes'] = array();
			$this->options['minDate']= date("Y/m/d", strtotime("+2 day"));
			$this->options['yearStart']=2017;
			//$this->options['beforeShowDay']=[0,6];
            //$this->ensureOption('maxDate', $interval->days);
            for ($i = 9; $i <= 17; $i++) {
                $hour = str_pad($i, 2, 0, STR_PAD_LEFT);
                $minutes = str_pad($i, 2, 0, STR_PAD_LEFT);
                $this->options['allowTimes'][] = $hour.':00';
				if($i!=17)
				{
					$this->options['allowTimes'][] = $hour.':15';
					$this->options['allowTimes'][] = $hour.':30';

				}
                
				//$this->
            }
        }
        return parent::init();
    }
    
    function run() {
        list($name, $id) = $this->resolveNameID();
        
        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;
        if (isset($this->htmlOptions['name']))
            $name = $this->htmlOptions['name'];
        else
            $this->htmlOptions['name'] = $name;
        
        if ($this->hasModel())
            echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
        else
            echo CHtml::textField($this->name, $this->value, $this->htmlOptions);
        
        if (isset($this->htmlOptions['id']))
            $id = $this->htmlOptions['id'];
        else
            $this->htmlOptions['id'] = $id;

        $options = CJavaScript::encode($this->options);

        $cs = Yii::app()->getClientScript();

        $assetUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('ext.YiiDateTimePicker.assets'));
        Yii::app()->clientScript->registerScriptFile($assetUrl . '/jquery.datetimepicker.js');
        Yii::app()->clientScript->registerCssFile($assetUrl . '/jquery.datetimepicker.css');

        $js = "$('#{$id}').datetimepicker($options);";
        
        $cs->registerScript(__CLASS__ . '#' . $id, $js);
    }
}
?>
