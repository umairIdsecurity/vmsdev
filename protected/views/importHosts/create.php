<?php
/* @var $this ImportHostsController */
/* @var $model ImportHosts */

$this->breadcrumbs=array(
	'Import Hosts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ImportHosts', 'url'=>array('index')),
	array('label'=>'Manage ImportHosts', 'url'=>array('admin')),
);
?>

<h1>Create ImportHosts</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>