<?php
/* @var $this Controller */
$session = new CHttpSession;
if (isset($_GET['viewFrom'])) {
    $viewFrom = $_GET['viewFrom'];
} else {
    $viewFrom = '';
}
?>
<?php $this->beginContent('//layouts/main');
?>
<div class="span-19">
    <div id="content" style="<?php
    if ($viewFrom != '' || $this->action->id == 'detail') {
        echo "border:1px solid white !important;";
    }
    ?>"
    <?php
    if ($this->action->id == 'detail') {
        echo "class='overflowxvisible'";
    }
    ?>
         >
             <?php echo $content; ?>
    </div><!-- content -->
</div>
<div class="span-5 last">
    <div id="sidebar">
        <?php
        if ($session['role'] == Roles::ROLE_STAFFMEMBER) {
            require_once(Yii::app()->basePath . '/views/visit/dashboardSidebar.php');
        } elseif (!isset($_GET['viewFrom'])) {
            require_once(Yii::app()->basePath . '/views/user/admin_menu.php');
        }
        ?>
    </div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>

