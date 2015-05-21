<?php
/* @var $this NotificationsController */
/* @var $model Notification */

$this->breadcrumbs=array(
	'Notifications'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Notification', 'url'=>array('index')),
	array('label'=>'Create Notification', 'url'=>array('create')),
	array('label'=>'View Notification', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Notification', 'url'=>array('admin')),
);
?>

<h1>Update Notification <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>