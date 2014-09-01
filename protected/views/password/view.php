<?php
/* @var $this PasswordController */
/* @var $model Password */

$this->breadcrumbs=array(
	'Passwords'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Password', 'url'=>array('index')),
	array('label'=>'Create Password', 'url'=>array('create')),
	array('label'=>'Update Password', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Password', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Password', 'url'=>array('admin')),
);
?>

<h1>View Password #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'email',
		'contact_number',
		'date_of_birth',
		'company',
		'department',
		'position',
		'staff_id',
		'notes',
		'photo',
		'password',
		'role',
		'user_type',
		'user_status',
		'created_by',
	),
)); ?>
<?php if(Yii::app()->user->hasFlash('success')): ?>
<div class="flash-success">
<?php echo Yii::app()->user->getFlash('success'); ?>
</div>
<?php endif; ?>