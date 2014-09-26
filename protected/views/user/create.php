<?php
/* @var $this UserController */
/* @var $model User */

$session = new CHttpSession;
?>
<h1>Create User</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>



