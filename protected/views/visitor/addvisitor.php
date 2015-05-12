
<?php
/* @var $this VisitorController */
/* @var $model Visitor */

?>

<?php

if (!isset($_GET['profile_type']) || $_GET['profile_type'] == Visitor::PROFILE_TYPE_CORPORATE) {
    $formSuffix = '';
} else {
    $formSuffix = '_' . strtolower($_GET['profile_type']);
    $model->profile_type = $_GET['profile_type'];
}

$this->renderPartial('_form' . $formSuffix, array('model'=>$model));
?>