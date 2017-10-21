<?php
/* @var $this SiteController */
/* @var $error array */


$this->pageTitle=Yii::app()->name . ' - Error';

?>


<div class="page-content">
    <h1 class="text-primary title">Error <?php echo $code; ?></h1>
    <div class="bg-danger form-info">
        <?php echo CHtml::encode($message); ?>
    </div>
</div>