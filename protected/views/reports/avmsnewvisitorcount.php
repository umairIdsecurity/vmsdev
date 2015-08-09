
<h1> New Visitor Profiles (VIC and ASIC) </h1>
<!-- Filter Form -->
<div class="form-inline">
<?php 

$form=$this->beginWidget('CActiveForm', array(
	'id'=>'visitor-type-filter-form',
	'enableAjaxValidation'=>false,
)); 

?> 
    <div id="datePickersDiv">   
        <label> Date From:  </label><br>
            <?php
                $this->widget( 'zii.widgets.jui.CJuiDatePicker',array(
                    'attribute'   => 'date_from_filter',
                    'language'=> 'en',
                    'name'=>'date_from_filter',
                    'value'=>Yii::app()->request->getParam("date_from_filter"),
                    'options'=>array(
                            'changeYear' => true,
                            'dateFormat'=>'dd-mm-yy',
                            'changeMonth'=> true,
                            'onClose' => 'js:function (selectedDate) { $("#date_to_filter").datepicker("option", "minDate", selectedDate); }',
                    ),
                   'htmlOptions'=>array('readonly'=>"readonly"),
                ));
            ?>
            
        <br><br>
        <label> Date To: </label><br>
                <?php 
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'attribute'   => 'date_to_filter',
                        'language'=> 'en',
                        'name'=>'date_to_filter',
                        'value'=>Yii::app()->request->getParam("date_to_filter"),
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'changeYear' => true,
                            'dateFormat'=>'dd-mm-yy',
                            'changeMonth'=> true,
                        ),
                        'htmlOptions'=>array('readonly'=>"readonly"),
                    )); 
                ?>
        
            &nbsp;
            <input id="filterBtn" type="submit" name="yt0" value="Filter">
        
    </div>
            
        <?php $this->endWidget();?>    
    </div>


<?php

    $this->renderPartial('_avmsnewVisitors', array("resultsVIC"=>$resultsVIC,"resultsASIC"=>$resultsASIC,"reversed"=>$reversed));
?>

