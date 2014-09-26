<?php
/* @var $this WorkstationController */
/* @var $dataProvider CActiveDataProvider */


?>

<h1>Workstations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
