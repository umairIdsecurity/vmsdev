<?php
/* @var $this CompanyController */
/* @var $model Company */



if (isset($_GET['viewFrom'])) {
                $viewFrom = $_GET['viewFrom'];
            } else {
                $viewFrom = '';
            }
 if ($viewFrom == '') {
   
$this->menu=array(
	array('label'=>'List Company', 'url'=>array('index')),
	array('label'=>'Manage Company', 'url'=>array('admin')),
 );}
?>

<h1>Create Company</h1>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>