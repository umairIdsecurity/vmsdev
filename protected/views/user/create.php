<?php
/* @var $this UserController */
/* @var $model User */

$session = new CHttpSession;
?>
<h1 style="display:inline;">Add User </h1>

<span class="note indentLeft addLineHeight">Fields with <span class="required">*</span> are required.</span>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>



