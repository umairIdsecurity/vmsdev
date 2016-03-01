
<?php
/* @var $this CompanyController */
/* @var $model Company */

?>

<h1 style="margin-left: 70px"> Add <?php echo strtoupper(Yii::app()->request->getParam("module" , "CVMS")); ?>Tenant Agent </h1>

<?php $this->renderPartial('_form', array('model'=>$model, "allTenant"=>$allTenant)); ?>