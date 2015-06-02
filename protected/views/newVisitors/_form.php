<?php
/* @var $this NewVisitorsController */
/* @var $model NewVisitors */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'new-visitors-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'middle_name'); ?>
		<?php echo $form->textField($model,'middle_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'middle_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_number'); ?>
		<?php echo $form->textField($model,'contact_number',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'contact_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_of_birth'); ?>
		<?php echo $form->textField($model,'date_of_birth'); ?>
		<?php echo $form->error($model,'date_of_birth'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company'); ?>
		<?php echo $form->textField($model,'company',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'company'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'department'); ?>
		<?php echo $form->textField($model,'department',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'department'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'staff_id'); ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'staff_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->textField($model,'role',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visitor_type'); ?>
		<?php echo $form->textField($model,'visitor_type',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'visitor_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visitor_status'); ?>
		<?php echo $form->textField($model,'visitor_status',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'visitor_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vehicle'); ?>
		<?php echo $form->textField($model,'vehicle',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'vehicle'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'photo'); ?>
		<?php echo $form->textField($model,'photo',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'photo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted'); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tenant'); ?>
		<?php echo $form->textField($model,'tenant',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'tenant'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tenant_agent'); ?>
		<?php echo $form->textField($model,'tenant_agent',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'tenant_agent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visitor_card_status'); ?>
		<?php echo $form->textField($model,'visitor_card_status',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'visitor_card_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visitor_workstation'); ?>
		<?php echo $form->textField($model,'visitor_workstation',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'visitor_workstation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profile_type'); ?>
		<?php echo $form->textField($model,'profile_type',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'profile_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identification_type'); ?>
		<?php echo $form->textField($model,'identification_type',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'identification_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identification_country_issued'); ?>
		<?php echo $form->textField($model,'identification_country_issued'); ?>
		<?php echo $form->error($model,'identification_country_issued'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identification_document_no'); ?>
		<?php echo $form->textField($model,'identification_document_no',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'identification_document_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identification_document_expiry'); ?>
		<?php echo $form->textField($model,'identification_document_expiry'); ?>
		<?php echo $form->error($model,'identification_document_expiry'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identification_alternate_document_name1'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_name1',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'identification_alternate_document_name1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identification_alternate_document_no1'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_no1',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'identification_alternate_document_no1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identification_alternate_document_expiry1'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_expiry1'); ?>
		<?php echo $form->error($model,'identification_alternate_document_expiry1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identification_alternate_document_name2'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_name2',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'identification_alternate_document_name2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identification_alternate_document_no2'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_no2',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'identification_alternate_document_no2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'identification_alternate_document_expiry2'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_expiry2'); ?>
		<?php echo $form->error($model,'identification_alternate_document_expiry2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_unit'); ?>
		<?php echo $form->textField($model,'contact_unit',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'contact_unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_street_no'); ?>
		<?php echo $form->textField($model,'contact_street_no',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'contact_street_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_street_name'); ?>
		<?php echo $form->textField($model,'contact_street_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'contact_street_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_street_type'); ?>
		<?php echo $form->textField($model,'contact_street_type',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'contact_street_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_suburb'); ?>
		<?php echo $form->textField($model,'contact_suburb',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'contact_suburb'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_state'); ?>
		<?php echo $form->textField($model,'contact_state',array('size'=>3,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'contact_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_country'); ?>
		<?php echo $form->textField($model,'contact_country'); ?>
		<?php echo $form->error($model,'contact_country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'asic_no'); ?>
		<?php echo $form->textField($model,'asic_no',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'asic_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'asic_expiry'); ?>
		<?php echo $form->textField($model,'asic_expiry'); ?>
		<?php echo $form->error($model,'asic_expiry'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'verifiable_signature'); ?>
		<?php echo $form->textField($model,'verifiable_signature'); ?>
		<?php echo $form->error($model,'verifiable_signature'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_postcode'); ?>
		<?php echo $form->textField($model,'contact_postcode',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'contact_postcode'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->