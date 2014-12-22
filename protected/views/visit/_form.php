<<<<<<< HEAD
<?php
/* @var $this VisitController */
/* @var $model Visit */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'visit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<div class="row">
        <?php echo $form->labelEx($model, 'visitor'); ?>
        <?php echo $form->textField($model, 'visitor', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'visitor'); ?>
    </div>
	<div class="row">
		<?php echo $form->labelEx($model,'card'); ?>
		<?php echo $form->textField($model,'card',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'card'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visitor_type'); ?>
		<?php echo $form->textField($model,'visitor_type',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'visitor_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textField($model,'reason',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visitor_status'); ?>
		<?php echo $form->textField($model,'visitor_status',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'visitor_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'host'); ?>
		<?php echo $form->textField($model,'host',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'host'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'patient'); ?>
		<?php echo $form->textField($model,'patient',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'patient'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_in'); ?>
		<?php echo $form->textField($model,'date_in'); ?>
		<?php echo $form->error($model,'date_in'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->labelEx($model,'date_out'); ?>
		<?php echo $form->textField($model,'date_out'); ?>
		<?php echo $form->error($model,'date_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_out'); ?>
		<?php echo $form->textField($model,'time_out'); ?>
		<?php echo $form->error($model,'time_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_check_in'); ?>
		<?php echo $form->textField($model,'date_check_in'); ?>
		<?php echo $form->error($model,'date_check_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_check_in'); ?>
		<?php echo $form->textField($model,'time_check_in'); ?>
		<?php echo $form->error($model,'time_check_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_check_out'); ?>
		<?php echo $form->textField($model,'date_check_out'); ?>
		<?php echo $form->error($model,'date_check_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_check_out'); ?>
		<?php echo $form->textField($model,'time_check_out'); ?>
		<?php echo $form->error($model,'time_check_out'); ?>
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
		<?php echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted'); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>
	
        <div class="row">
		<?php echo $form->labelEx($model,'workstation'); ?>
		<?php echo $form->textField($model,'workstation'); ?>
		<?php echo $form->error($model,'workstation'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

=======
<?php
/* @var $this VisitController */
/* @var $model Visit */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'visit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
<div class="row">
        <?php echo $form->labelEx($model, 'visitor'); ?>
        <?php echo $form->textField($model, 'visitor', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($model, 'visitor'); ?>
    </div>
	<div class="row">
		<?php echo $form->labelEx($model,'card'); ?>
		<?php echo $form->textField($model,'card',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'card'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visitor_type'); ?>
		<?php echo $form->textField($model,'visitor_type',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'visitor_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason'); ?>
		<?php echo $form->textField($model,'reason',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'reason'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'visitor_status'); ?>
		<?php echo $form->textField($model,'visitor_status',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'visitor_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'host'); ?>
		<?php echo $form->textField($model,'host',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'host'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'patient'); ?>
		<?php echo $form->textField($model,'patient',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'patient'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_in'); ?>
		<?php echo $form->textField($model,'date_in'); ?>
		<?php echo $form->error($model,'date_in'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->labelEx($model,'date_out'); ?>
		<?php echo $form->textField($model,'date_out'); ?>
		<?php echo $form->error($model,'date_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_out'); ?>
		<?php echo $form->textField($model,'time_out'); ?>
		<?php echo $form->error($model,'time_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_check_in'); ?>
		<?php echo $form->textField($model,'date_check_in'); ?>
		<?php echo $form->error($model,'date_check_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_check_in'); ?>
		<?php echo $form->textField($model,'time_check_in'); ?>
		<?php echo $form->error($model,'time_check_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_check_out'); ?>
		<?php echo $form->textField($model,'date_check_out'); ?>
		<?php echo $form->error($model,'date_check_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_check_out'); ?>
		<?php echo $form->textField($model,'time_check_out'); ?>
		<?php echo $form->error($model,'time_check_out'); ?>
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
		<?php echo $form->labelEx($model,'is_deleted'); ?>
		<?php echo $form->textField($model,'is_deleted'); ?>
		<?php echo $form->error($model,'is_deleted'); ?>
	</div>
	
        <div class="row">
		<?php echo $form->labelEx($model,'workstation'); ?>
		<?php echo $form->textField($model,'workstation'); ?>
		<?php echo $form->error($model,'workstation'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

>>>>>>> origin/Issue35
</div><!-- form -->