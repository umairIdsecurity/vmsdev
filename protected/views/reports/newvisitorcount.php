<h1> Total New Visitor Profiles </h1>
<!-- Filter Form -->
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'visitor-type-filter-form',
	'enableAjaxValidation'=>false,
)); ?>
        <label> Date From:  </label>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(    
                        'name'=>'date_from_filter',
                        'value'=>Yii::app()->request->getParam("date_from_filter"),
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'changeYear' => true,
                            'dateFormat'=>'dd-MM-yy',
                            'changeMonth'=> true,
                        ),

            )); ?>  
        
             <label> Date To: </label>
              <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(    
                        'name'=>'date_to_filter',
                        'value'=>Yii::app()->request->getParam("date_to_filter"),
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'changeYear' => true,
                            'dateFormat'=>'dd-MM-yy',
                            'changeMonth'=> true,
                        ),

            )); ?>
         
	 <?php echo CHtml::submitButton('Filter'); ?>
	 
        <?php $this->endWidget()?>    
    </div>


<?php
    $fromDateFilter = Yii::app()->request->getParam("date_from_filter");
    $toDateFilter = Yii::app()->request->getParam("date_to_filter");
    if( !empty($fromDateFilter) && !empty($toDateFilter) ) {
        $this->renderPartial('_newVisitorsWithFilters', array('results' =>$results));
    }else{
        $this->renderPartial('_newVisitorsNoFilters', array('results' =>$results));
    }
?>


