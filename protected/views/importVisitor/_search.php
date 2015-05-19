<?php
/* @var $this ImportVisitorController */
/* @var $model ImportVisitor */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'company'); ?>
		<?php echo $form->textField($model,'company',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'check_in_date'); ?>
		<?php echo $form->textField($model,'check_in_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'check_out_date'); ?>
		<?php echo $form->textField($model,'check_out_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'card_code'); ?>
		<?php echo $form->textField($model,'card_code',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'imported_by'); ?>
		<?php echo $form->textField($model,'imported_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'import_date'); ?>
		<?php echo $form->textField($model,'import_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->