
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

// If user change from VIC to ASIC then unset asic_no and asic_expiry & set visitor_card_status is ASIC_ISSUED
if (isset($_GET['profile_type']) && $_GET['profile_type'] != $model->profile_type && $_GET['profile_type'] == Visitor::PROFILE_TYPE_ASIC) {
	$model->unsetAttributes(['asic_no', 'asic_expiry']);
	$model->visitor_card_status = Visitor::ASIC_ISSUED;
	$formSuffix = '_' . strtolower($_GET['profile_type']);
}

$this->renderPartial('_form' . $formSuffix, ['model' => $model]);
?>
