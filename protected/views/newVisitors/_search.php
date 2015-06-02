<?php
/* @var $this NewVisitorsController */
/* @var $model NewVisitors */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'middle_name'); ?>
		<?php echo $form->textField($model,'middle_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_number'); ?>
		<?php echo $form->textField($model,'contact_number',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_of_birth'); ?>
		<?php echo $form->textField($model,'date_of_birth'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company'); ?>
		<?php echo $form->textField($model,'company',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'department'); ?>
		<?php echo $form->textField($model,'department',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'position'); ?>
		<?php echo $form->textField($model,'position',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'staff_id'); ?>
		<?php echo $form->textField($model,'staff_id',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'role'); ?>
		<?php echo $form->textField($model,'role',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visitor_type'); ?>
		<?php echo $form->textField($model,'visitor_type',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visitor_status'); ?>
		<?php echo $form->textField($model,'visitor_status',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vehicle'); ?>
		<?php echo $form->textField($model,'vehicle',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'photo'); ?>
		<?php echo $form->textField($model,'photo',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tenant'); ?>
		<?php echo $form->textField($model,'tenant',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tenant_agent'); ?>
		<?php echo $form->textField($model,'tenant_agent',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visitor_card_status'); ?>
		<?php echo $form->textField($model,'visitor_card_status',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visitor_workstation'); ?>
		<?php echo $form->textField($model,'visitor_workstation',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'profile_type'); ?>
		<?php echo $form->textField($model,'profile_type',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'identification_type'); ?>
		<?php echo $form->textField($model,'identification_type',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'identification_country_issued'); ?>
		<?php echo $form->textField($model,'identification_country_issued'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'identification_document_no'); ?>
		<?php echo $form->textField($model,'identification_document_no',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'identification_document_expiry'); ?>
		<?php echo $form->textField($model,'identification_document_expiry'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'identification_alternate_document_name1'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_name1',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'identification_alternate_document_no1'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_no1',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'identification_alternate_document_expiry1'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_expiry1'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'identification_alternate_document_name2'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_name2',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'identification_alternate_document_no2'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_no2',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'identification_alternate_document_expiry2'); ?>
		<?php echo $form->textField($model,'identification_alternate_document_expiry2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_unit'); ?>
		<?php echo $form->textField($model,'contact_unit',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_street_no'); ?>
		<?php echo $form->textField($model,'contact_street_no',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_street_name'); ?>
		<?php echo $form->textField($model,'contact_street_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_street_type'); ?>
		<?php echo $form->textField($model,'contact_street_type',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_suburb'); ?>
		<?php echo $form->textField($model,'contact_suburb',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_state'); ?>
		<?php echo $form->textField($model,'contact_state',array('size'=>3,'maxlength'=>3)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_country'); ?>
		<?php echo $form->textField($model,'contact_country'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'asic_no'); ?>
		<?php echo $form->textField($model,'asic_no',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'asic_expiry'); ?>
		<?php echo $form->textField($model,'asic_expiry'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'verifiable_signature'); ?>
		<?php echo $form->textField($model,'verifiable_signature'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contact_postcode'); ?>
		<?php echo $form->textField($model,'contact_postcode',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->