<?php
/* @var $this ImportVisitorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Import Visitors',
);

$this->menu=array(
	array('label'=>'Create ImportVisitor', 'url'=>array('create')),
	array('label'=>'Manage ImportVisitor', 'url'=>array('admin')),
);
?>

<h1>Import Visitors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
