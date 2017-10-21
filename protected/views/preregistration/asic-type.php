<?php
    $session = new CHttpSession;
    //this is because to ensure the CAVMS-1144 and CAVMS-1092
    $tenant = '';
    if(isset(Yii::app()->user->tenant) && (Yii::app()->user->tenant != "")){
        $tenant = Yii::app()->user->tenant;
    }
    else
    {
        $tenant = (isset($session['tenant']) && ($session['tenant'] != "")) ? $session['tenant'] : '';
    }

?>
<style>


td, th {
    border: 1px solid;
    text-align: left;
    padding: 8px;
}


</style>
<!-- <div class="page-content"> -->
        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
        
        <?php
            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'asic-type-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'style' => 'height:100%;position:relative'
                )
            ));
        ?>
       
      

       

       <?php if(isset($session['Asictype']) && ($session['Asictype']=='3'||$session['Asictype']=='2')) {?>
	    <h3 class="text-primary subheading-size">Previous or Current ASIC Information Details</h3>
	    <b>If known please provide the following information</b>
        <br><br>
        <div class="row">
             <div class="col-sm-4">
                
                <div class="form-group">
                    <?php echo $form->textField($model, 'previous_card', array('placeholder' => 'Current or Former ASIC No.' , 'class'=>'form-control input-sm')); ?>
                    
                </div>
				<div class="form-group">
                    <?php echo $form->textField($model, 'previous_issuing_body', array('placeholder' => 'Previous Issuing Body Airport' , 'class'=>'form-control input-sm')); ?>
                    
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'other_info', array('maxlength'=>100,'placeholder' => 'Other Info' , 'class'=>'form-control input-sm')); ?>
                    
                </div>
				<div class="form-group">
                        <?php
                        $this->widget('EDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'previous_expiry',
                            //'mode'        => 'asic_expiry',
							'htmlOptions'=> array('class'=>'form-control input-sm')
                        ));
                        ?>
                        <?php echo $form->error($model, 'asicexpiry'); ?>
					</div>
            </div>
        </div>
	   <?php } ?>
	    <h3 class="text-primary subheading-size">Select ASIC Type</h3>
		
	    <div class="row">
             <div class="col-sm-4" style="width:75%;">
	   <?php
					
					echo $form->radioButtonList($model, 'asic_type',array(
					$session['tenant']=>Company::model()->findByPk($session['tenant'])->name, 
					'2'=>'Australia Wide',),
					array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:5px;',));
					
                ?>
				<?php echo $form->error($model,'asic_type'); ?>
				</div>
				</div>
				<br>
				<p><b>Note:</b> All application for AUS ASIC’s must be supported by a separate written explanation from the employer. The supporting letter must state that name of ports for which access is required, description of the nature of the duties indicating why an AUS ASIC is requirement and the number of times the AUS is required per annum.</p><p>(Please download letter template here to be completed and signed by your company)
</p>
		 <div class="row"><div class="col-sm-12">&nbsp;</div></div>
	  <h3 class="text-primary subheading-size">Select ASIC Areas of Access</h3>
	    <div class="row">
             <div class="col-sm-4" style='width: 550px;'>
	    <?php
					
					echo $form->radioButtonList($model, 'access',array(
					'1'=>'Red-Security Restricted Area', 
					'2'=>'Grey- General Aviation Area Only',),
					array('class' => 'password_requirement form-label','separator'=>'&nbsp&nbsp&nbsp','style'=>'display:inline; margin-left:5px;',));
					
                ?>
				<?php echo $form->error($model,'access'); ?>
				</div>
				</div>

		<h3 class="text-primary subheading-size">Frequency of Access</h3>
		<p>Select one option for areas applicable</p>
		<table id='new'>

			<tr id='red' style='display:none;'>
			<td> Security Restricted Area (Red)</td>
			<td>	
			 <?php
					
					echo $form->radioButtonList($model, 'frequency_red',array(
					'1'=>'Daily',
					'2'=>'Weekly',
					'3'=>'Monthly'
					),
					array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:5px;',));
					echo $form->error($model,'frequency_red'); 
                ?>
			
			</td>
			
			</tr>
			<tr>
			<td> General Aviation Area (Grey)</td>
			<td>	
			 <?php
					
					echo $form->radioButtonList($model, 'frequency_grey',array(
					'1'=>'Daily',
					'2'=>'Weekly',
					'3'=>'Monthly'
					),
					array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:5px;',));
					 echo $form->error($model,'frequency_grey');
                ?>
				
			</td>
			
			</tr>
			
			</table>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
		<b>Reason for access to security controlled area</b>
		<br><br>
		<?php echo $form->textArea($model, 'security_detail', array('maxlength' => 100,'class'=>'form-control input-sm', 'style'=>'width:400px;')); ?>
		<?php echo $form->error($model,'security_detail'); ?>
		<br>
		<b>Door/Gate that access is required </b>
		<br><br>
		<?php echo $form->textArea($model, 'door_detail', array('maxlength' => 100 ,'class'=>'form-control input-sm', 'style'=>'width:400px;')); ?>
		<?php echo $form->error($model,'door_detail'); ?>

		
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>



      <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?php echo Yii::app()->createUrl("preregistration/asicOnlinePrivacyPolicy"); ?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                </div>
                <div class="pull-right">
                    <?php
                        echo CHtml::tag('button', array(
                            'type'=>'submit',
                            'class' => 'btn btn-primary btn-next'
                        ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
                    ?>
                </div>
            </div>
        </div>
    </div> 

    <?php $this->endWidget(); ?>


<script>
if($("input[name='AsicInfo[access]']:checked").val()==1)
{
	$('#red').show();
}
else 
{
$('#red').hide();
$("input[name='AsicInfo[frequency_red]']").prop('checked',false);
}
    $("input[name='AsicInfo[access]']").on("click",function(e){
      var val=$(this).val();
	  if(val==1)
	  {
		  $('#red').show();
		  
	  }
	  else
	  {
		  $('#red').hide();
		  $("input[name='AsicInfo[frequency_red]']").prop('checked',false);
	  }
    });


</script>
