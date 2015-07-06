<?php
/* @var $this ContactPersonController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Contact People',
);

$this->menu=array(
	array('label'=>'Create ContactPerson', 'url'=>array('create')),
	array('label'=>'Manage ContactPerson', 'url'=>array('admin')),
);
?>

<h1>Contact Person</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
