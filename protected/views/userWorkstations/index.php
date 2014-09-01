<?php
/* @var $this UserWorkstationsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Workstations',
);

$this->menu=array(
	array('label'=>'Create UserWorkstations', 'url'=>array('create')),
	array('label'=>'Manage UserWorkstations', 'url'=>array('admin')),
);
?>

<h1>User Workstations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
