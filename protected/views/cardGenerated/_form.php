
<?php
/* @var $this CardGeneratedController */
/* @var $model CardGenerated */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'card-generated-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'date_printed'); ?>
		<?php echo $form->textField($model,'date_printed'); ?>
		<?php echo $form->error($model,'date_printed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_expiration'); ?>
		<?php echo $form->textField($model,'date_expiration'); ?>
		<?php echo $form->error($model,'date_expiration'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'card_image_generated_filename'); ?>
		<?php echo $form->textField($model,'card_image_generated_filename',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'card_image_generated_filename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visitor_id'); ?>
		<?php echo $form->textField($model,'visitor_id',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'visitor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'created_by'); ?>
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
		<?php echo $form->labelEx($model,'company_code'); ?>
		<?php echo $form->textField($model,'company_code',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'company_code'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'card_count'); ?>
		<?php echo $form->textField($model,'card_count',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'card_count'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'print_count'); ?>
		<?php echo $form->textField($model,'print_count',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'print_count'); ?>
	</div>
        
        

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->