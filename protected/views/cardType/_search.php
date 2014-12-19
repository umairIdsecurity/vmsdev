<?php
/* @var $this CardTypeController */
/* @var $model CardType */
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
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_day_validity'); ?>
		<?php echo $form->textField($model,'max_day_validity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_time_validity'); ?>
		<?php echo $form->textField($model,'max_time_validity',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'max_entry_count_validity'); ?>
		<?php echo $form->textField($model,'max_entry_count_validity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'card_icon_type'); ?>
		<?php echo $form->textArea($model,'card_icon_type',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'card_background_image_path'); ?>
		<?php echo $form->textArea($model,'card_background_image_path',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->