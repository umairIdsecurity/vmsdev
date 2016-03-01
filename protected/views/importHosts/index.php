<?php
/* @var $this ImportHostsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Import Hosts',
);

$this->menu=array(
	array('label'=>'Create ImportHosts', 'url'=>array('create')),
	array('label'=>'Manage ImportHosts', 'url'=>array('admin')),
);
?>

<h1>Import Hosts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
