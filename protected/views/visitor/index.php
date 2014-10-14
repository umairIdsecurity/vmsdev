<?php
/* @var $this VisitorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Visitors',
);

$this->menu=array(
	array('label'=>'Create Visitor', 'url'=>array('create')),
	array('label'=>'Manage Visitor', 'url'=>array('admin')),
);
?>

<h1>Visitors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
