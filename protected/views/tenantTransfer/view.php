<?php
/* @var $this TenantTransferInfoController */
/* @var $model TenantTransferForm */


?>

<h1>Transfer Tenant</h1>
<?php
foreach(Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}

?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>