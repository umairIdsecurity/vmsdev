<?php
/* @var $this ReasonsController */
/* @var $model Reasons */

$this->breadcrumbs=array(
	'Reasons'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Reasons', 'url'=>array('index')),
	array('label'=>'Create Reasons', 'url'=>array('create')),
	array('label'=>'View Reasons', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Reasons', 'url'=>array('admin')),
);
?>

<h1>Update Reasons <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>