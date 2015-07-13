
<?php
/* @var $this VisitorController */
/* @var $model Visitor */

?>

<h1>Edit Visitor </h1>

<?php
if ($model->profile_type == Visitor::PROFILE_TYPE_CORPORATE) {
    $formSuffix = '';
} else {
    $formSuffix = '_' . strtolower($model->profile_type);
}

if (isset($_GET['profile_type']) && $_GET['profile_type'] != $model->profile_type) {
	$model->unsetAttributes(['identification_document_no', 'identification_document_expiry']);
}

$this->renderPartial('_form' . $formSuffix, array('model'=>$model));
?>
