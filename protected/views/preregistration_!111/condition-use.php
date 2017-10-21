<?php
$session = new CHttpSession;
?>
<!-- <div class="page-content"> -->
<style>
li {
	margin-left: 30px;
}



td, th {
    border: 1px solid;
    text-align: left;
    padding: 8px;
	width: 85%;
}


</style>

    <!-- <div class="row"><div class="col-sm-12">&nbsp;</div></div> -->
	&nbsp
<p><b>Please read conditions carefully before proceeding with application</b></p>
    <h3 class="text-primary subheading-size">Criminal Charge, Conviction or Pecuniary Penalties</h3>
	<?php
            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'criminal-check-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'style' => 'height:100%;position:relative'
                )
            ));
        ?>
		<div class='row'>
    <div class="privacy-info text-size">

        Please answer the following questions by selecting Yes or No
        <br><br>
		<table>
		<tr>
		<td>
		Are you the subject of any criminal charges(s) still pending before a court? 
		</td>
		<td>
		<?php
					echo $form->radioButtonList($model, 'radiobutton1',array(
					'1'=>'Yes', 
					'2'=>'No',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left: 5%;'));
                ?>
				
				<?php echo $form->error($model,'radiobutton1');?>
		</td>
		
		</tr>
		<tr>
		<td>
		Do you have any criminal convictions (s) or findings or guilt which are less that ten(10) years old, or juvenile convictions (s) or finding(s) of guilt which are less that five (5) years old?
		</td>
		<td>
		<?php
					echo $form->radioButtonList($model, 'radiobutton2',array(
					'1'=>'Yes', 
					'2'=>'No',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left: 5%;'));
                ?>
				
				<?php echo $form->error($model,'radiobutton2');?>
		</td>
		</tr>
		<tr>
		<td>
		Do you have any convictions (s) or finding(s)or guilt which are over ten (10) years old, or five (5) years for juvenile convictions or finding (s) or guilt where the sentence imposed was less than thirty (30) months imprisonment?
		</td>
		<td>
		<?php
					echo $form->radioButtonList($model, 'radiobutton3',array(
					'1'=>'Yes', 
					'2'=>'No',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left: 5%;'));
                ?>
				
				<?php echo $form->error($model,'radiobutton3');?>
		</td>
		</tr>
		<tr>
		<td>
		Do you have any convictions) or findings of guilt which are over ten (10) years old, or five (5) years for juvenile convictions) or findings where the sentence imposed was greater than thirty (30) months imprisonment?
		</td>
		<td>
		<?php
					echo $form->radioButtonList($model, 'radiobutton4',array(
					'1'=>'Yes', 
					'2'=>'No',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline;	margin-left: 5%;'));
                ?>
				
				<?php echo $form->error($model,'radiobutton4');?>
		</td>
		</tr>
		</table>
        <ul>

			</ul>
			</br>
			<p>Note: The applicant is required under Regulation 6.41 of the ATSR 2005 to notify Sunshine Coast Airport (SCA) in writing of conviction within 7 days if they have been convicted of an Aviation Security Related Offence (ASRO) Penalties apply for not informing SCA of a conviction.</p>
			</br>
			<label class="checkbox text-size" style='margin: auto; width: 60%;'>
			<?php
					echo $form->checkBox($model, 'check1',array('class'=>'checkbox'));
                ?>
				<span class="checkbox-style" style='margin-left:-4.5%;'></span><span class=" text-size" style="line-height:21px">I certify that the above information and details are correct to the best of my knowledge.</span>
				<?php echo $form->error($model,'check1');?>
			</label>
							
			<label class="checkbox text-size" style='margin: auto; width: 60%;'>
			<?php
					echo $form->checkBox($model, 'check2',array('class'=>'checkbox'));
                ?>
				<span class="checkbox-style" style='margin-left:-4.5%;'></span><span class=" text-size" style="line-height:21px">I agree to notify the SCA Management Office of any changes to the above particulars.</span>
				<?php echo $form->error($model,'check2');?>
			</label>	
				
    </div>
   </div>
    <br>

    <div class="declarations" style="">
        <div class="form-group" id="privacy_notice">
			
			<label class="checkbox text-size">
			<?php
					echo $form->checkBox($model, 'check3',array('class'=>'checkbox'));
                ?>
				<span class="checkbox-style"></span><span class=" text-size" style="line-height:21px">I have read and agreed to the above conditions of use of all cards</span>
				<?php echo $form->error($model,'check3');?>
			</label>	
            

        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?php echo Yii::app()->createUrl("preregistration/asicFee"); ?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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
<!-- </div> -->

<script>
  $(document).ready(function () {
	var check1='<?php if(isset($session['Crime1'])) echo $session['Crime1']; else echo '';?>';
	var check2='<?php if(isset($session['Crime2'])) echo $session['Crime2']; else echo ''; ?>';
	var check3='<?php if(isset($session['Crime3'])) echo $session['Crime3']; else echo '';?>';
	var	check4='<?php if(isset($session['Crime4'])) echo $session['Crime4']; else echo '';?>';
	var	check5='<?php if(isset($session['use1'])) echo $session['use1']; else echo '';?>';
	var check6='<?php if(isset($session['use2'])) echo $session['use2']; else echo '';?>';
	var check7='<?php if(isset($session['use3'])) echo $session['use3']; else echo '';?>';
//alert(pay);
if(check1!='')
	$("input[name='CriminalCheck[radiobutton1]'][value=" + check1 + "]").prop("checked", true)
if(check2!='')
	$("input[name='CriminalCheck[radiobutton2]'][value=" + check2 + "]").prop("checked", true)
if(check3!='')
	$("input[name='CriminalCheck[radiobutton3]'][value=" + check3 + "]").prop("checked", true)
if(check4!='')
	$("input[name='CriminalCheck[radiobutton4]'][value=" + check4 + "]").prop("checked", true)
if(check5!='')
	$("input[name='CriminalCheck[check1]'][value=" + check5 + "]").prop("checked", true)
if(check6!='')
	$("input[name='CriminalCheck[check2]'][value=" + check6 + "]").prop("checked", true)
if(check7!='')
	$("input[name='CriminalCheck[check3]'][value=" + check7 + "]").prop("checked", true)

  });
</script>