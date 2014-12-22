<?php
/* @var $this SiteController */
/* @var $error array */
$session = new CHttpSession;
$this->pageTitle = Yii::app()->name . ' - Error';

?>
<div class="errorPage">
    <h5>Error <?php echo $code; ?></h5>

    <div class="error">
        <?php echo CHtml::encode($message); ?>
    </div>
</div>