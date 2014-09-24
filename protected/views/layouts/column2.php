<?php
/* @var $this Controller */
$session = new CHttpSession;
?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
    <div id="content" style="">
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<div class="span-5 last">
    <div id="sidebar">
        <?php
        if (!isset($_GET['viewFrom'])) {
            require_once(Yii::app()->basePath . '/views/user/admin_menu.php');
        }
        ?>
    </div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>

