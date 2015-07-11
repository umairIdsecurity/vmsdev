<?php
/* @var $this ContactPersonController */
/* @var $model ContactPerson */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-person-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_person_name'); ?>
		<?php echo $form->textField($model,'contact_person_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'contact_person_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_person_email'); ?>
		<?php echo $form->textField($model,'contact_person_email',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'contact_person_email'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->