<<<<<<< HEAD
<?php
/* @var $this PhotoController */
/* @var $model Photo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'photo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'filename'); ?>
		<?php echo $form->textArea($model,'filename',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'filename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unique_filename'); ?>
		<?php echo $form->textArea($model,'unique_filename',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'unique_filename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'relative_path'); ?>
		<?php echo $form->textArea($model,'relative_path',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'relative_path'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

=======
<?php
/* @var $this PhotoController */
/* @var $model Photo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'photo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'filename'); ?>
		<?php echo $form->textArea($model,'filename',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'filename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unique_filename'); ?>
		<?php echo $form->textArea($model,'unique_filename',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'unique_filename'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'relative_path'); ?>
		<?php echo $form->textArea($model,'relative_path',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'relative_path'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

>>>>>>> origin/Issue35
</div><!-- form -->