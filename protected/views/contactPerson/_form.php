<?php
/* @var $this ContactPersonController */
/* @var $model ContactPerson */
/* @var $form CActiveForm */

$module = CHelper::get_allowed_module(); 
if ($module == "CVMS") {
	$user_roles = Roles::get_cvms_roles_name();
} else if ($module == "AVMS") {
	$user_roles = Roles::get_avms_roles_name();
} else {
	$user_roles = Roles::get_cavms_roles_name();
}

$tenant = '';
if(Yii::app()->user->role == Roles::ROLE_ADMIN){
    $tenant = "tenant='".Yii::app()->user->tenant."'";
} 
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
		<?php echo $form->labelEx($model,'user_role'); ?>
		<?php 
			echo $form->dropdownList(
                $model,
                'user_role',
                $user_roles,
                array('empty'=>'Select a user role')
        );?>
		<?php echo $form->error($model,'user_role'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'reason_id'); ?>
		<?php echo $form->dropDownList(
                $model,
                'reason_id',
                CHtml::listData(Reasons::model()->findAll($tenant),
                        'id',
                        'nameFuncForReasons'),
                        array('empty'=>'Select a reason')
        );?>
		<?php echo $form->error($model,'reason_id'); ?>
	</div>

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
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class"=>"complete")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->