<?php
/* @var $this ImportVisitorController */
/* @var $model ImportVisitor */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'import-visitor-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?><br>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?> <br>
		<?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?><br>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company'); ?><br>
		<?php echo $form->textField($model,'company',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'company'); ?>
	</div>

	<div class="row">
          
		<?php echo $form->labelEx($model,'check_in_date'); ?> <br>
		 <?php $this->widget('EDatePicker', array(
                'value'=>$model->check_in_date,
                'model'=>$model,
                ));
            ?>
		<?php echo $form->error($model,'check_in_date'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'check_in_time'); ?> <br>
		<?php echo $form->textField($model,'check_in_time'); ?>
		<?php echo $form->error($model,'check_in_time'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'check_out_date'); ?> <br>
		 <?php $this->widget('EDatePicker', array(
                'name'=>'ImportVisitor[check_out_date]',
                'value'=>$model->check_out_date,  
                'model'=>$model,
                ));
            ?>
		<?php echo $form->error($model,'check_out_date'); ?>
	</div>
         <div class="row">
		<?php echo $form->labelEx($model,'check_out_time'); ?> <br>
		<?php echo $form->textField($model,'check_out_time'); ?>
		<?php echo $form->error($model,'check_out_time'); ?>
	</div>
        

	<div class="row">
		<?php echo $form->labelEx($model,'card_code'); ?> <br>
		<?php echo $form->textField($model,'card_code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'card_code'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'contact_number'); ?> <br>
		<?php echo $form->textField($model,'contact_number',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'contact_number'); ?>
	</div>
        
         
        
        

	<div class="row">
		 
		<?php echo $form->hiddenField($model,'imported_by'); ?>
	 
		 
		<?php echo $form->hiddenField($model,'import_date'); ?>
		 
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->