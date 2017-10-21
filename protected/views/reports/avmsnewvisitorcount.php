
<h1> New Visitor Profiles (VIC and ASIC) </h1>
<?php echo CHtml::button('Export to CSV', array('id' => 'export-button', 'class' => 'greenBtn complete'));?>
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
                $this->widget( 'EDatePicker',array(
                    'attribute'   => 'date_from_filter',
                    'name'=>'date_from_filter',
                    'value'=>Yii::app()->request->getParam("date_from_filter"),
                    'options'=>array(
                            'onClose' => 'js:function (selectedDate) { $("#date_to_filter").datepicker("option", "minDate", selectedDate); }',
                    ),
                   'htmlOptions'=>array('readonly'=>"readonly"),
                ));
            ?>
            
        <br><br>
        <label> Date To: </label><br>
                <?php 
                    $this->widget('EDatePicker', array(
                        'attribute'   => 'date_to_filter',
                        'name'=>'date_to_filter',
                        'value'=>Yii::app()->request->getParam("date_to_filter"),
                        'htmlOptions'=>array('readonly'=>"readonly"),
                    )); 
                ?>
        
            &nbsp;
            <input id="filterBtn" type="submit" name="yt0" value="Filter" class="complete">
        
    </div>
            
        <?php $this->endWidget();?>    
    </div>
<script>
		
        $('#export-button').on('click', function() {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('reports/profilesAvmsVisitors'); ?>",
                type: 'GET',
               // dataType: 'json',
                data: 'export=true',
                success: function () 
                {
					 window.location = '<?php echo $this->createUrl('exportFileNewVisitors');?>';
                },
                error: function(xhr,textStatus,errorThrown){
                console.log(xhr.responseText);
                console.log(textStatus);
                console.log(errorThrown);
            }

            });
        });
       
	</script>

<?php

    $this->renderPartial('_avmsnewVisitors', array("resultsVIC"=>$resultsVIC,"resultsASIC"=>$resultsASIC,"resultsVICASIC"=>$resultsVICASIC,"reversed"=>$reversed));
?>

