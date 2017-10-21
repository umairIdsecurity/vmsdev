<?php /* @var $this Controller */ ?>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->controller->assetsBase.'/css/manage-file-upload.css');
$cs->registerScriptFile(Yii::app()->controller->assetsBase.'/js/JQuery.MultiFile.min.js');
?>
<?php $this->beginContent('//layouts/main'); ?>
<?php echo $content; ?>
<?php $this->endContent(); ?>