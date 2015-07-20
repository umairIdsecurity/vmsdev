<?php
/* @var $this NotificationsController */
/* @var $model Notification */
/* @var $form CActiveForm */
?>
<?php $module = CHelper::get_allowed_module(); ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'notification-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
        
	<div class="row">
             <?php echo $form->labelEx($model,'subject'); ?> <br>
	     <?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>250)); ?>
             <?php echo $form->error($model,'subject'); ?>
         </div>
        

	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?><br>
		<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50, 'style'=>'width:350px')); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>

	 
	<div class="row">
        <?php  $role_ids = CHelper::get_comma_separated_role_ids($module); ?>    
		<?php echo $form->labelEx($model,'role_id'); ?><br>
		<?php echo $form->dropDownList(
                                $model,
                                'role_id',
                                CHtml::listData(Roles::model()->findAll("id IN (".$role_ids.")"),
                                        'id',
                                        'nameFuncForNotifiLabels'),
                                        array('empty'=>'Send To All Users')
                        );?>
		<?php echo $form->error($model,'role_id'); ?>          
	</div>

 
	<div class="row">
		<?php echo $form->labelEx($model,'notification_type'); ?><br>
		<?php echo $form->dropDownList($model, 'notification_type',array("Product Updates"=>"Product Updates"));?>
		<?php echo $form->error($model,'notification_type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->