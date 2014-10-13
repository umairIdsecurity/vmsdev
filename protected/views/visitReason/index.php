<?php
/* @var $this VisitReasonController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Visit Reasons',
);

$this->menu=array(
	array('label'=>'Create VisitReason', 'url'=>array('create')),
	array('label'=>'Manage VisitReason', 'url'=>array('admin')),
);
?>

<h1>Visit Reasons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
