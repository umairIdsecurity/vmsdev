<<<<<<< HEAD
<?php
/* @var $this PatientController */
/* @var $model Patient */

$this->breadcrumbs=array(
	'Patients'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Patient', 'url'=>array('index')),
	array('label'=>'Manage Patient', 'url'=>array('admin')),
);
?>

<h1>Create Patient</h1>

=======
<?php
/* @var $this PatientController */
/* @var $model Patient */

$this->breadcrumbs=array(
	'Patients'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Patient', 'url'=>array('index')),
	array('label'=>'Manage Patient', 'url'=>array('admin')),
);
?>

<h1>Create Patient</h1>

>>>>>>> origin/Issue35
<?php $this->renderPartial('_form', array('model'=>$model)); ?>