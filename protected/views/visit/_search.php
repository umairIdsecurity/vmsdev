<?php
/* @var $this VisitController */
/* @var $model Visit */
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
		<?php echo $form->label($model,'card'); ?>
		<?php echo $form->textField($model,'card',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visitor_type'); ?>
		<?php echo $form->textField($model,'visitor_type',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'reason'); ?>
		<?php echo $form->textField($model,'reason',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'visitor_status'); ?>
		<?php echo $form->textField($model,'visitor_status',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'host'); ?>
		<?php echo $form->textField($model,'host',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'patient'); ?>
		<?php echo $form->textField($model,'patient',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_in'); ?>
		<?php echo $form->textField($model,'date_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time_in'); ?>
		<?php echo $form->textField($model,'time_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_out'); ?>
		<?php echo $form->textField($model,'date_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time_out'); ?>
		<?php echo $form->textField($model,'time_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_check_in'); ?>
		<?php echo $form->textField($model,'date_check_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time_check_in'); ?>
		<?php echo $form->textField($model,'time_check_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_check_out'); ?>
		<?php echo $form->textField($model,'date_check_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time_check_out'); ?>
		<?php echo $form->textField($model,'time_check_out'); ?>
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
		<?php echo $form->label($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->