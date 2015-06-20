<?php
/* @var $this ReasonsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Reasons',
);

$this->menu=array(
	array('label'=>'Create Reasons', 'url'=>array('create')),
	array('label'=>'Manage Reasons', 'url'=>array('admin')),
);
?>

<h1>Reasons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
