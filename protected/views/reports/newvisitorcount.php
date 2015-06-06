<h1> Total New Visitor Profiles </h1>
<!-- Filter Form -->
<div class="form-inline">
<?php 

$rangeRadio = Yii::app()->request->getParam("rangeRadio");
$weeklyInterval = Yii::app()->request->getParam("weeklyInterval");
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'visitor-type-filter-form',
	'enableAjaxValidation'=>false,
)); 

?>
    
    <fieldset>
        <legend>
            Select Interval
        </legend>
        
        <div class="some-class">
            
            <input onclick="this.form.submit();" type="radio" value="monthly" name="rangeRadio" checked="checked" /> 
            <label> Monthly </label> 
            
            &nbsp;&nbsp;
            <input onclick="this.form.submit();" type="radio" value="weekly" name="rangeRadio" <?php if(!empty($rangeRadio) && $rangeRadio == "weekly") {echo "checked";}?> />
             <label> Weekly </label> 
            
            &nbsp;&nbsp;
            <input type="radio" value="daily" name="rangeRadio" <?php if(!empty($rangeRadio) && $rangeRadio == "daily") {echo "checked";}?> />
             <label> Daily </label> 
        </div>
    </fieldset>
    <br>
    
    
    <?php
    
        if(empty($rangeRadio) || $rangeRadio == "daily" || $rangeRadio == "monthly" ) {
           
    ?>
    
    <div id="datePickersDiv">    
        <label> Date From  </label><br>
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
        <br>
        <label> Date To </label><br>
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
    </div>
    
    <?php
            
        }
    ?>

    
            <?php

                if($rangeRadio == "weekly" ) {

            ?>
            <div id="weeklyDiv">
                <select name="weeklyInterval" onchange="this.form.submit();">
                    <option value="1" selected="selected">Last 1 Week</option>
                    <option value="2" <?php if(!empty($weeklyInterval) && $weeklyInterval == "2") {echo "selected";}?> >Last 2 Weeks</option>
                    <option value="4" <?php if(!empty($weeklyInterval) && $weeklyInterval == "4") {echo "selected";}?> >Last 4 Weeks</option>
                    <option value="8" <?php if(!empty($weeklyInterval) && $weeklyInterval == "8") {echo "selected";}?> >Last 8 Weeks</option>
                </select>
            </div>
            <?php

                }
            ?>
            
             <?php
    
            if(empty($rangeRadio) || $rangeRadio == "daily" || $rangeRadio == "monthly" ) {
           
            ?>
            <br>
            <input id="filterBtn" type="submit" name="yt0" value="Filter">
             <?php
            
            }
            ?>
            
        <?php $this->endWidget();?>    
    </div>


<?php

     if(empty($rangeRadio) || $rangeRadio == "daily" || $rangeRadio == "monthly" ) {
         $fromDateFilter = Yii::app()->request->getParam("date_from_filter");
        $toDateFilter = Yii::app()->request->getParam("date_to_filter");
        if( !empty($fromDateFilter) && !empty($toDateFilter) ) {
            $this->renderPartial('_newVisitorsWithFilters', array('results' =>$results));
        }else{
            $this->renderPartial('_newVisitorsNoFilters', array('results' =>$results,"reversed"=>$reversed));
        }
     }else{
          $this->renderPartial('_weeklyPartial', array('results' =>$results,"reversed"=>$weeksReversed));
     }

    
?>

