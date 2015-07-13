<?php /* @var $this Controller */ ?>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->controller->assetsBase.'/css/manage-file-upload.css');
?>
<?php $this->beginContent('//layouts/main'); ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>