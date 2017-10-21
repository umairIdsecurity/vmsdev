<?php
$session = new CHttpSession;
?> 
 
 <div class="page-content">

 <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'asic-submit-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            /*'afterValidate'    => 'js:function(form, data, hasError){
                return afterValidate(form, data, hasError);
            }'*/
        ),
        'htmlOptions'=>array(
            'class'=> 'form-comfirm-detail'
        )
    ));
    ?>
	<div class="form-group">
            <?php echo $form->hiddenField($model, 'selected_asic_id' ,
                array('value'=>'')
            ); ?>
        </div>

    <h3 class="text-primary subheading-size">Thank You!</h3>
    <div class="privacy-info text-size">
    <label>The airport office will contact you shortly to arrange your appointment. If you don't hear from us in today or tomorrow please call [office number]</label>
<h3 class="text-primary subheading-size">What you need for your appointment</h3>
 <label>Please bring the original copy of the identification documentation you have entered for verification.</label>

	<ul style='margin-left:15px;'>
	<li>Category A - Full Birth Certificate, Australian Citizenship Certificate, Immicard</li>
	<li>Category B - Australian Drivers Licence, Current Australian Passport, Licence Issued under the Law of</li>
	<li>Category C - Medicare Card, Marriage Certificate, Current previous ASIC, Evidence of employment (payslip less than 6 months)</li>
	<li>Category D - Australian Electoral Role, Bank Statement or Utility bill ( if current address is not shown on above identifications only)</li>
	<li>Change of Name Documentation (if applicable)</li>
	</ul>
	<br>
	<label>Company Information</label> 
	<ul style='margin-left:15px;'>
	<li>Authorised Company Contact Form</li>
	<li>Access and Operational  Need Letter (AUS)</li>
	</ul>
    </div>
	<div class="privacy-info text-size">
    <label>Applicants Acknowledgement</label> 
	<ul style='margin-left:15px;'>
	<li>I understand that I am applying for a security identification card for the aviation industry</li>
	<li>I certify that the person application that I have provided in this application relates to me and is correct to the best of my knowledge.</li>
	<li>I understand and consent to the forwarding of my personal information to Auscheck to co-ordinate the background check and Security Assessment through Australian Intelligence Organisation (ASIO) Crimtrac and the Department of Immigration and Citizenship (DIAC) where necessary.</li>
	</br></br>
	<input type="checkbox" name="acknowledged" value="acknowledge"> I agree to and acknowledge the above
	</ul>
	</div>
	<div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
	 <div class="row">
            <div class="col-sm-12">
                <div class="">
                    <div class="pull-left">
                        <a href="<?=Yii::app()->createUrl("preregistration/paymentAppointment")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                    </div>
                    <div style='text-align:center;'>
                        <?php
                            echo CHtml::tag('button', array(
                                'type'=>'submit',
                                'id' => 'btnSubmit',
                                'class' => 'btn btn-primary btn-next',
								'style'=>'background: grey;border-color: grey;height: 50px;width: 150px;',
                            ), 'SUBMIT <span class="glyphicon glyphicon-chevron-right"></span> ');
                        ?>
                    </div>
                </div>
            </div>
        </div>  
		<?php $this->endWidget(); ?>
	</div>