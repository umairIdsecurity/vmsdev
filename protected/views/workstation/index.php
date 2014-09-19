<?php
/* @var $this WorkstationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Workstations',
);

$this->menu=array(
	array('label'=>'Create Workstation', 'url'=>array('create')),
	array('label'=>'Manage Workstation', 'url'=>array('admin')),
);
?>

<h1>Workstations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
