<?php
/* @var $this ImportHostsController */
/* @var $model ImportHosts */

$this->breadcrumbs=array(
	'Import Hosts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ImportHosts', 'url'=>array('index')),
	array('label'=>'Create ImportHosts', 'url'=>array('create')),
	array('label'=>'View ImportHosts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ImportHosts', 'url'=>array('admin')),
);
?>

<h1>Update ImportHosts <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>