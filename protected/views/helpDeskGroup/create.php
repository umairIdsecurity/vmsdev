
<?php
/* @var $this HelpDeskGroupController */
/* @var $model HelpDeskGroup */

$this->breadcrumbs=array(
	'Help Desk Groups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Faq Groups', 'url'=>array('index')),
	array('label'=>'Manage Faq Groups', 'url'=>array('admin')),
);
?>

<h1>Create Help Desk Group</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>