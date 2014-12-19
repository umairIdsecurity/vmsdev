<?php
/* @var $this VisitController */
/* @var $model Visit */
/* @var $form CActiveForm */
$session = new CHttpSession;
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	
    <div class="row">
		<?php echo $form->label($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>20,'maxlength'=>20)); ?>
	</div>
    <div class="row">
		<?php echo $form->label($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>20,'maxlength'=>20)); ?>
	</div>
    <div class="row">
        <?php echo $form->label($model, 'contactnumber'); ?>
        <?php echo $form->textField($model, 'contactnumber', array('size' => 20, 'maxlength' => 20)); ?>
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
		<?php echo $form->label($model,'visitor_status'); ?>
		<?php echo $form->textField($model,'visitor_status',array('size'=>20,'maxlength'=>20)); ?>
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

	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->