<?php
    $session = new CHttpSession;
/*$timeIn = explode(":", '00:00:00');
if ($model->time_in != '') {
    $timeIn = explode(":", $model->time_in);
}*/
$timeIn[0] = date("H");
$timeIn[1] = date("i");


?>

<style type="text/css">
.middleLabels{margin-top:16px;}
</style>

<div class="page-content">
<h3 class="text-primary subheading-size">Application Lodgement Appointment</h3>
<p>Please select two alternate appointment times 48 hours in advance. Airport Administration office will contact you to confirm your appointment once your application is submitted.</p>

<p>If your application is urgent you should contact the Airport Administration Office to arrange an earlier appointment time.  Please also allow at least 60 minutes to complete your application and your induction at the appointment</p>

         
	




    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'visit-details-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions' =>
            array(
                'class' => 'form-log-visit',
            ),

        )); ?>


    <div class="row">
<!--        <div class="col-sm-4 text-center">-->
<!--            <a href="#"><img src="<?php//=Yii::app()->theme->baseUrl?>/images/vic24h.png" alt="Vic24h"></a>-->
<!--        </div>-->
	<label>Preffered Appointment Date & Time Option 1</br></label>
				 <br><br>
        <div class="col-sm-8">
            <div class="">
                  <div class="row">
                    <div class="col-sm-3" style="line-height:30px">Date of Visit</div>
                    <div class="col-sm-6" style=" position:relative; line-height:30px;">
                        
						<?php
						   
                            $this->widget('application.extensions.YiiDateTimePicker.jqueryDateTime', array(
                                'model'       => $model,
                                'attribute'   => 'appointment_1',
								'options'     => array('format'=>'d/m/Y H:i','defaultTime'=>'10:00'),
								'htmlOptions'=> array('class'=>'form-control input-sm', 'style'=>'width:238px;'),
								
                            ));
							//echo '<i class="glyphicon glyphicon-calendar"></i>';
                        ?>
                        <!--<span style="line-height:30px" class="glyphicon glyphicon-calendar">-->
                    </div>
                   
                  </div>
            </div>

            <div class="">
                <div class="row"><div class="col-sm-12">&nbsp;</div></div>
            </div>    

            
        </div>
		
        <div class="col-sm-1"></div>
    </div>

 <div class="row">
<!--        <div class="col-sm-4 text-center">-->
<!--            <a href="#"><img src="<?php//=Yii::app()->theme->baseUrl?>/images/vic24h.png" alt="Vic24h"></a>-->
<!--        </div>-->
	<label>Preffered Appointment Date & Time Option 2</br></label>
				 <br><br>
        <div class="col-sm-8">
            <div class="">
                  <div class="row">
                    <div class="col-sm-3" style="line-height:30px">Date of Visit</div>
                    <div class="col-sm-6" style=" position:relative; line-height:30px;">
                        
						<?php
						   
                            $this->widget('application.extensions.YiiDateTimePicker.jqueryDateTime', array(
                                'model'       => $model,
                                'attribute'   => 'appointment_2',
								'options'     => array('format'=>'d/m/Y H:i','defaultTime'=>'10:00'),
								'htmlOptions'=> array('class'=>'form-control input-sm', 'style'=>'width:238px;'),
								
                            ));
							
							//echo '<i class="glyphicon glyphicon-calendar"></i>';
                        ?>
                        <!--<span style="line-height:30px" class="glyphicon glyphicon-calendar">-->
                    </div>
                   
                  </div>
            </div>

            <div class="">
                <div class="row"><div class="col-sm-12">&nbsp;</div></div>
            </div>    

        </div>
		
        <div class="col-sm-1"></div>
    </div>

    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>



    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?=Yii::app()->createUrl("preregistration/asicOperationalNeed")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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
</div>
<script type="text/javascript">
        $(document).ready(function(){
			if('<?php if(isset($session['appt1']) && isset($session['appt2'])){echo '1';} else {echo '0';} ?>'=='1')
				{
					$('#RegistrationAsic_appointment_1').val('<?php echo $session['appt1']; ?>');
					$('#RegistrationAsic_appointment_2').val('<?php echo $session['appt2']; ?>');
				}
			
			
           
        });
</script>