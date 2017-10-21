<?php
$session = new CHttpSession;
?>
<!-- <div class="page-content"> -->

    <!-- <div class="row"><div class="col-sm-12">&nbsp;</div></div> -->
<style>


td, th {
    border: 1px solid;
    text-align: left;
    padding: 8px;
}


</style>
    
	<div class="privacy-info text-size">
		 <h3 class="text-primary subheading-size">Application Lodgement Appointment</h3>
		<p>Your application must be submitted at least 4-6 weeks prior to need to allow sufficient time for processing. At the end of this online application you will be asked to select two alternate appointment times 48 hours in advance. If your application is urgent you should contact the Airport Administration Office to arrange an earlier appointment time.You should allow at least 60 minutes to complete your application and your induction at the appointment.</p>
		<h3 class="text-primary subheading-size">Application Fees & Charges</h3>
		<p>Payment of refundable bond and ASIC fee must be submitted on initial application lodgement either prior via company invoice or in person via EFTPOS at your appointment. Cash and Cheques are not accepted.</p>
		<h3 class="text-primary subheading-size">Refundable Deposit</h3>
		<p>For all ASIC’s issued, a refundable deposit is required to be paid to the Airport on collection of the printed ASIC.When the cardholder ceases employment at the airport, or no longer requires an ASIC, on returning the card to the Security Services Office will reimburse the deposit to the cardholder or company of the card holder.<br>Please indicate below if the deposit will be  paid by the company or the applicant and list the account details where the refund should be reimbursed.</p>

</div>
    <div class="privacy-info text-size">
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
		
        <b>Please select one of the following ASIC Application types</b>
        <br>
		  <div class="row">
            <div class="col-sm-4 fixedMargin" style='width: 50%;'>
                
                <?php
                   // $ws=Workstation::model()->findAll('is_deleted=0 and tenant = '.($tenant==null?"-1":$tenant));
                   // $list=CHtml::listData($ws,'id','name');
                    /*echo $form->dropDownList($model,'entrypoint',
                        $list,
                        array(
                            'class'=>'form-control input-sm' ,
                            'empty' => 'Chose your entry point')
                    );*/
					
					echo $form->radioButtonList($model, 'radiobutton',array(
					'1'=>'New', 
					'2'=>'Renewal',
					'3'=>'Replacement'
					),
array('class' => 'password_requirement form-label'
,'separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;',));
					
                ?>
				<?php echo $form->error($model,'radiobutton'); ?>
				
                
             
            </div>
        </div>
		 
        <table id='new' style='display:none'>

			<tr>
			<td> Bond (On Application)</td>
			<td>$50.00 </td>
			<td> 
			<b> Provide bank account details for refund on return (optional)</b></br>
			 <?php echo $form->textField($model, 'accname', array('maxlength' => 25, 'placeholder' => 'Account Name' ,'class'=>'form-control input-sm', 'style'=>'width:200px;')); ?>
			 </br>
			  <?php echo $form->textField($model, 'bsb', array('maxlength' => 25, 'placeholder' => 'BSB' ,'class'=>'form-control input-sm', 'style'=>'width:200px;')); ?>
			</br>
			 <?php echo $form->textField($model, 'accno', array('maxlength' => 25, 'placeholder' => 'Account Number' ,'class'=>'form-control input-sm', 'style'=>'width:200px;')); ?>
			</td>
			</tr>
			<tr>
			<td> ASIC Fee (payable prior to lodgement) </td>
			<td>$283.00</td>
			<td id='payby'> 
			 <?php
					echo $form->radioButtonList($model, 'radiobutton2',array(
					'1'=>'Company', 
					'2'=>'Card Holder',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;'));
                ?>
				
				<?php echo $form->error($model,'radiobutton2');?>
			</td>
			</tr>
			
			</table>
			<div id='renewdiv' style='display:none'>
			<b> Bond Paid</b>
			<?php
					echo $form->radioButtonList($model, 'renewal',array(
					'1'=>'Yes', 
					'2'=>'No',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;'));
                ?>
				<?php echo $form->error($model,'renewal');?>
			</div>
			     <table id='renew' style='display:none'>

			<tr id='renewtr' style='display:none'>
			<td> Bond (On Application)</td>
			<td>$50.00 </td>
			<td> 
			<b> Provide bank account details for refund on return (optional)</b></br>
			 <?php echo $form->textField($model, 'accname', array('maxlength' => 25, 'placeholder' => 'Account Name' ,'class'=>'form-control input-sm', 'style'=>'width:200px;')); ?>
			 </br>
			  <?php echo $form->textField($model, 'bsb', array('maxlength' => 25, 'placeholder' => 'BSB' ,'class'=>'form-control input-sm', 'style'=>'width:200px;')); ?>
			</br>
			 <?php echo $form->textField($model, 'accno', array('maxlength' => 25, 'placeholder' => 'Account Number' ,'class'=>'form-control input-sm', 'style'=>'width:200px;')); ?>
			</td>
			</tr>
			<tr>
			<td> ASIC Fee (payable prior to lodgement) </td>
			<td>$283.00</td>
			<td id='payby'> 
			 <?php
					echo $form->radioButtonList($model, 'radiobutton2',array(
					'1'=>'Company', 
					'2'=>'Card Holder',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;'));
                ?>
				<?php echo $form->error($model,'radiobutton2');?>
			</td>
			</tr>
			</table>
			<div id='replacediv' style='display:none'>
			<b> Bond Paid</b>
			<?php
					echo $form->radioButtonList($model, 'renewal',array(
					'1'=>'Yes', 
					'2'=>'No',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;'));
                ?>
				<?php echo $form->error($model,'renewal');?>
			</div>
			     <table id='replace' style='display:none'>

			<tr id='replacetr' style='display:none'>
			<td> Bond (On Application)</td>
			<td>$50.00 </td>
			<td> 
			<b> Provide bank account details for refund on return (optional)</b></br>
			 <?php echo $form->textField($model, 'accname', array('maxlength' => 25, 'placeholder' => 'Account Name' ,'class'=>'form-control input-sm', 'style'=>'width:200px;')); ?>
			 </br>
			  <?php echo $form->textField($model, 'bsb', array('maxlength' => 25, 'placeholder' => 'BSB' ,'class'=>'form-control input-sm', 'style'=>'width:200px;')); ?>
			</br>
			 <?php echo $form->textField($model, 'accno', array('maxlength' => 25, 'placeholder' => 'Account Number' ,'class'=>'form-control input-sm', 'style'=>'width:200px;')); ?>
			</td>
			</tr>
			<tr>
			<td> Card Replacement Fee </td>
			<td>$104.00</td>
			<td id='payby'> 
			 <?php
					echo $form->radioButtonList($model, 'radiobutton2',array(
					'1'=>'Company', 
					'2'=>'Card Holder',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;'));
                ?>
				<?php echo $form->error($model,'radiobutton2');?>
			</td>
			</tr>
			</table>
    </div>
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
<!-- </div> -->

<script>$(document).ready(function () {
	
	$("input[name='AsicType[radiobutton]']").on("click",function(e){
	var val=$(this).val();
	
		//alert('umair');
	var payBy1='<?php
					echo $form->radioButtonList($model, 'radiobutton2',array(
					'1'=>'Company', 
					'2'=>'Card Holder',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;'));
                ?>';
				
	var payBy2='<?php echo $form->error($model,'radiobutton2');?>';
		

	var rep='<b> Bond Paid</b>';
	var rep1='<?php
					echo $form->radioButtonList($model, 'renewal',array(
					'1'=>'Yes', 
					'2'=>'No',
					),array('class' => 'password_requirement form-label','separator'=>'&nbsp','style'=>'display:inline; margin-left:20px;'));
                ?>';
				
	var rep2='<?php echo $form->error($model,'renewal');?>';
	 
	 if(val==1)
	  {
		  
		  
		   $('#new').show();
		    $('#renew').hide();
		   $('#replace').hide();
		   $('#renewdiv').hide();
		   $('#replacediv').hide();
		   if($('#new').find('#payby').html()=='')
		   {
			 $('#new').find('#payby').html(payBy1+payBy2);  
		   }
		   
		   $('#new').find(':hidden, input').attr('disabled',false);
		   $('#renew').find(':hidden, input').attr('disabled',true);
		   $('#replace').find(':hidden, input').attr('disabled',true);
			$('#renew').find('#payby').html('');
			$('#replace').find('#payby').html('');
			$('#renewdiv').find(':hidden, input').attr('disabled',true);
			$('#replacediv').find(':hidden, input').attr('disabled',true);

			if(pay!='')
				$("input[name='AsicType[radiobutton2]'][value=" + pay + "]").prop('checked', true);
		 
	  }
	if(val==2)
	  {
		   $('#renew').show();
		   $('#renewdiv').show();
		   $('#new').hide();
		   $('#replace').hide();
		   $('#replacediv').hide();
		   $('#renew').find(':hidden, input').attr('disabled',false);
		   $('#renewdiv').find(':hidden, input').attr('disabled',false);
		    if($('#renew').find('#payby').html()=='' )
		   {
			 $('#renew').find('#payby').html(payBy1+payBy2);  
		   }
		    if($('#renewdiv').html()=='')
		   {
			   $('#renewdiv').html(rep+rep1+rep2);
		   }
		   $("input[name='AsicType[renewal]']").on("click",function(e){
				var val=$(this).val();
				if(val==2)
				{
					$('#renewtr').show();
				}
				else
				{
					$('#renewtr').hide();
				}
	
				});
			$('#new').find(':hidden, input').attr('disabled',true);
			$('#replace').find(':hidden, input').attr('disabled',true);
			$('#new').find('#payby').html('');
			$('#replace').find('#payby').html('');
			$('#replacediv').html('');
			$('#replacediv').find(':hidden, input').attr('disabled',true);
			if(bond!='')
				$("input[name='AsicType[renewal]'][value=" + bond + "]").prop("checked", true).trigger("click");
			if(pay!='')
				$("input[name='AsicType[radiobutton2]'][value=" + pay + "]").prop('checked', true);
			
	  }
	if(val==3)
	  {
		   $('#renew').hide();
		   $('#new').hide();
		   $('#replace').show();
			$('#renewdiv').hide();
		   $('#replacediv').show();
		   if($('#replace').find('#payby').html()=='')
		   {
			 $('#replace').find('#payby').html(payBy1+payBy2);  
		   }
		   if($('#replacediv').html()=='')
		   {
			   $('#replacediv').html(rep+rep1+rep2);
		   }
		   $("input[name='AsicType[renewal]']").on("click",function(e){
				var val=$(this).val();
				if(val==2)
				{
					$('#replacetr').show();
				}
				else
				{
					$('#replacetr').hide();
				}
	
				});
		$('#renew').find(':hidden, input').attr('disabled',true);
		$('#replace').find(':hidden, input').attr('disabled',false);
		$('#replacediv').find(':hidden, input').attr('disabled',false);
		
		   $('#new').find(':hidden, input').attr('disabled',true);
		   $('#renew').find('#payby').html('');
			$('#new').find('#payby').html('');
			$('#renewdiv').html('');
			$('#renewdiv').find(':hidden, input').attr('disabled',true);
			if(bond!='')
				$("input[name='AsicType[renewal]'][value=" + bond + "]").prop("checked", true).trigger("click");
			if(pay!='')
				$("input[name='AsicType[radiobutton2]'][value=" + pay + "]").prop('checked', true);
	  }
	
	});
	var checked='<?php if(isset($session['Asictype'])) echo $session['Asictype']; else echo '';?>';
	var bond='<?php if(isset($session['BondPaid'])) echo $session['BondPaid']; else echo ''; ?>';
	var accname='<?php if(isset($session['Accname'])) echo $session['Accname']; else echo '';?>';
	var	bsb='<?php if(isset($session['Bsb'])) echo $session['Bsb']; else echo '';?>';
	var	acno='<?php if(isset($session['Accno'])) echo $session['Accno']; else echo '';?>';
	var pay='<?php if(isset($session['paidby'])) echo $session['paidby']; else echo '';?>';
//alert(pay);
	if(checked!='')
	{
		//$("input[name='AsicType[radiobutton]'][value=" + checked + "]").attr('checked', 'checked');
		if(accname!='')
		$("input[name='AsicType[accname]']").val(accname);
		if(bsb!='')
		$("input[name='AsicType[bsb]']").val(bsb);
		if(acno!='')
		$("input[name='AsicType[accno]']").val(acno);
	
		$("input[name='AsicType[radiobutton]'][value=" + checked + "]").prop("checked", true).trigger("click");
		//$("input[name='AsicType[radiobutton]']").attr('onclick', 'true');
	}
   
});

</script>