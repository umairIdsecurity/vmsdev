<?php

class Select2 extends CWidget
{
    public $model;
    public $attribute;
    public $items;
    public $placeHolder;
    public $selectedItems;
    public $disabled = 'false';
    
    public function init()
    {
        $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile($assets . '/select2.min.js', CClientScript::POS_END);
        $cs->registerCssFile($assets . '/select2.css');
        return parent::init();
    }

    public function run()
    {
    	$className = $this->model->getModelName() . '_' . $this->attribute;
    	$options = array(
			'class' => $className . ' ',
    		'options' => $this->getSelectedOptions()
		);
    	if ($this->disabled == 'true') {
    		$options['disabled'] = 'true';
    	}
    	
        echo CHtml::activeDropDownList(
            $this->model,
            $this->attribute,
            array('' => $this->placeHolder) + $this->items,
        	$options
        );
        $this->render('js', array('className' => $className, 'placeHolder' => $this->placeHolder, 'attribute' => $this->attribute));
    }

    private function getSelectedOptions()
    {
        $result = array();
        if ($this->selectedItems) {
            foreach ($this->selectedItems as $item) {
                $result[$item] = array('selected' => true);
            }
        }
        return $result;
    }

}