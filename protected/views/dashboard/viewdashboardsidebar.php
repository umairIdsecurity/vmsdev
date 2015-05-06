<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase. '/js/script-sidebar.js');
/* @var $this UserController */
/* @var $model User */
$session = new ChttpSession;
?> 
<style type="text/css">
.addcompanymenu{   background-position-x: 3px !important;background-position-y: 5px !important;}
</style>
<input type="hidden" value="<?php echo $session['role'] ?>" id="sessionRoleForSideBar">

<div id="sidebar2">
    <div class="sidebarTitle" style=""><a href="#" class="dashboard-icon"></a>Main Menu</div><br><div id='cssmenu' class="dashboardMenu">
        <ul>

            <li class=''><a href='<?php echo Yii::app()->createUrl('visitor/create&action=register'); ?>' id="addvisitorSidebar" class="sidemenu-icon log-current"><span>Log Visit</span></a></li>
            <!--<li class=''>
                <a href='<?php /*echo Yii::app()->createUrl('visitor/create&action=preregister'); */?>' class="sidemenu-icon pre-visits">
                    <span >Preregister Visit</span>
                </a>
            </li>-->
            <li><a href='<?php echo Yii::app()->createUrl('visitor/addvisitor'); ?>' class="submenu-icon addvisitorprofile"><span>Add Visitor Profile</span></a></li>
             <li><a onclick="addCompany2()" class="addcompanymenu"><span>Add Company</span></a></li>
                        
            

            <li class=''><a href='<?php echo Yii::app()->createUrl('visit/view'); ?>' id="findrecordSidebar" class="submenu-icon findrecord"><span>Search Visits</span></a></li>
            <li class=''><a href='<?php echo Yii::app()->createUrl('visit/evacuationReport&p=d'); ?>' id="evacuationreportSidebar" class="sidemenu-icon evacuationreport"><span>Evacuation Report</span></a></li>
        </ul>
    </div>
</div>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Click me',
    'type' => 'primary',
    'htmlOptions' => array(
        'data-toggle' => 'modal',
        'data-target' => '#addCompanyModal',
        'id' => 'modalBtn',
        'style' => 'display:none',
    ),
));
?>

<div class="modal hide fade" id="addCompanyModal" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >X</a>
        <br>
    </div>
    <div id="modalBody"></div>

</div>

<script>
 function addCompany2() {
        
            
                /* if role is superadmin tenant is required. Pass selected tenant and tenant agent of user to company. */
                url = '<?php echo Yii::app()->createUrl('company/create&viewFrom=1'); ?>';
            

            $("#modalBody").html('<iframe id="companyModalIframe" width="100%" height="80%" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
            $("#modalBtn").click();
        
    }
</script>
