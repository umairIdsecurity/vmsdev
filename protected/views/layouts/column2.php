<?php
/* @var $this Controller */
$session = new CHttpSession;
//echo $session['lastPage'];
if (isset($_GET['viewFrom'])) {
    $viewFrom = $_GET['viewFrom'];
} else {
    $viewFrom = '';
}
?>
<?php $this->beginContent('//layouts/main');
?>
<div class="span-5 last">
    <div id="sidebar">
        <?php
        if (isset($_GET['viewFrom'])) {
            
        } elseif ($session['role'] == Roles::ROLE_STAFFMEMBER) {
            require_once(Yii::app()->basePath . '/views/visit/dashboardSidebar.php');
            
        } elseif ($this->id == 'dashboard' || $session['lastPage'] == 'dashboard') {
            //  require_once(Yii::app()->basePath . '/views/dashboard/viewdashboardsidebar.php');
            if ($this->id != 'dashboard') {
                $this->renderPartial("../dashboard/viewdashboardsidebar");
            } else {
                $this->renderPartial("viewdashboardsidebar");
              
            }
           
        } elseif ($session['role'] == Roles::ROLE_SUPERADMIN || $session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_AGENT_ADMIN) {
            require_once(Yii::app()->basePath . '/views/user/admin_menu.php');
            
        } else {
            require_once(Yii::app()->basePath . '/views/dashboard/viewdashboardsidebar.php');
            
        }
        ?>
    </div><!-- sidebar -->
</div>
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

        <?php $this->endContent(); ?>

