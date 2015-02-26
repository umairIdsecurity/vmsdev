<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/script-sidebar.js');
/* @var $this UserController */
/* @var $model User */
$session = new ChttpSession;
?> 
<input type="hidden" value="<?php echo $session['role'] ?>" id="sessionRoleForSideBar">

<div id="sidebar2" style="<?php
if ($session['role'] == Roles::ROLE_AGENT_OPERATOR || $session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_STAFFMEMBER || $session['role'] == Roles::ROLE_VISITOR) {
    echo 'display:none;';
}
?>" class="administrationMenu">
    <div class="sidebarTitle" style="">Administration</div><br><div id='cssmenu' >
        <ul>
            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                ?>
                <li class='has-sub'><?php
                    echo CHtml::ajaxLink("Manage Companies", CController::createUrl('company/adminAjax'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
            $('.manageworkstations').next().slideUp('normal');
            $('.managecompanies').next().slideDown('normal');
            $('.manageusers').next().slideUp('normal');
            //$('.manageusers').next().hide();
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitreasons').next().slideUp('normal');
            $('.managereports').next().slideUp('normal');
        }",
                            ), array(
                        'class' => 'managecompanies',
                    ));
                    ?>
                    <ul <?php
                    if ($this->id == 'company' || $this->id == 'companyLafPreferences') {
                        echo "style='display:block ;'";
                    }
                    ?>>

                        <li><a href='<?php echo Yii::app()->createUrl('company/create'); ?>' class="addSubMenu ajaxLinkLi"><span>Add Company</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('CompanyLafPreferences/customisation'); ?>' class="ajaxLinkLi"><span>Customise Display</span></a></li>
                    </ul>
                </li>
                <?php
            } else {
                if ($session['role'] == Roles::ROLE_ADMIN) {
                    ?>
                    <li class='has-sub'>

                        <a href='<?php echo Yii::app()->createUrl('company/update/&id=' . $session['company']); ?>'><span>Organisation Settings</span></a>
                        <ul <?php
                        if ($this->id == 'company' || $this->id == 'companyLafPreferences') {
                            echo "style='display:block ;'";
                        }
                        ?>>
                            <li><a href='<?php echo Yii::app()->createUrl('CompanyLafPreferences/customisation'); ?>' class="ajaxLinkLi"><span>Customise Display</span></a></li>

                        </ul>
                    </li>
                    <?php
                } else {
                    ?>
                    <li>
                    <a href='<?php echo Yii::app()->createUrl('CompanyLafPreferences/customisation'); ?>' class="ajaxLinkLi"><span>Customise Display</span></a>
                    </li>
                        <?php }
                ?>




            <?php }
            ?>
            <li class='has-sub'><?php
                echo CHtml::ajaxLink("Manage Workstations", CController::createUrl('workstation/adminAjax'), array(
                    'update' => '#content',
                    'complete' => "js:function(html){
            $('.managecompanies').next().slideUp('normal');
            $('.manageworkstations').next().slideDown('normal');
            $('.manageusers').next().slideUp('normal');
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitreasons').next().slideUp('normal');
            $('.managereports').next().slideUp('normal');
        }",
                        ), array(
                    'class' => 'manageworkstations',
                ));
                ?>
                <ul <?php
                if ($this->id == 'workstation') {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('workstation/create'); ?>' class="addSubMenu"><span>Add Workstation</span></a></li>
                </ul>
            </li>

            <li class='has-sub'><?php
                echo CHtml::ajaxLink("Manage Users", CController::createUrl('user/adminAjax'), array(
                    'update' => '#content',
                    'complete' => "js:function(html){
            $('.managecompanies').next().slideUp('normal');
            $('.manageworkstations').next().slideUp('normal');
            $('.manageusers').next().slideDown('normal');
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitreasons').next().slideUp('normal');
            $('.managereports').next().slideUp('normal');
        }",
                        ), array(
                    'class' => 'manageusers',
                ));
                ?>
                <ul <?php
                if ($this->id == 'user') {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('user/create'); ?>' class="has-sub-sub"><span>Add User</span></a></li>

                    <?php
                    switch ($session['role']) {
                        case Roles::ROLE_SUPERADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=1'); ?>'><span>Add Administrator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=6'); ?>'><span>Add Agent Administrator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=8'); ?>'><span>Add Operator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=7'); ?>'><span>Add Agent Operator</span></a></li>

                            <?php
                            break;
                        case Roles::ROLE_ADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=1'); ?>'><span>Add Administrator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=6'); ?>'><span>Add Agent Administrator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=8'); ?>'><span>Add Operator</span></a></li>

                            <?php
                            break;

                        case Roles::ROLE_AGENT_ADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=7'); ?>'><span>Add Agent Operator</span></a></li>
                            <?php
                            break;
                        default:
                            echo "";
                            break;
                    };
                    ?>
                    <li >

                        <a href='<?php echo Yii::app()->createUrl('user/systemaccessrules'); ?>'><span>Set Access Rules</span></a></li>


                </ul>
            </li>

            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                ?>
                <li class='has-sub'><a class='managevisitorrecords' href='<?php echo Yii::app()->createUrl('visitor/admin'); ?>'><span>Manage Visitors</span></a>

                    <ul <?php
                    if ($this->id == 'visitor' || $this->action->id == 'exportvisitorrecords') {
                        echo "style='display:block ;'";
                    }
                    ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/addvisitor'); ?>' class="addSubMenu"><span>Add Visitor Profile</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/create&action=register'); ?>' class="addSubMenu"><span>Log Visit</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/create&action=preregister'); ?>' class="addSubMenu"><span>Preregister Visit</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('visit/exportvisitorrecords'); ?>' ><span>Export Visit History</span></a></li>
                    </ul>
                </li>   
                <li class='has-sub'><?php
                    echo CHtml::ajaxLink("Manage Visitor Types", CController::createUrl('visitorType/adminAjax'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
            $('.managecompanies').next().slideUp('normal');
            $('.manageworkstations').next().slideUp('normal');
            $('.manageusers').next().slideUp('normal');
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitortype').next().slideDown('normal');
            $('.managevisitreasons').next().slideUp('normal');
            $('.managereports').next().slideUp('normal');
        }",
                            ), array(
                        'class' => 'managevisitortype',
                    ));
                    ?>
                    <ul <?php
                    if ($this->id == 'visitortype') {
                        echo "style='display:block ;'";
                    }
                    ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('visitorType/create'); ?>' class="addSubMenu"><span>Add Visitor Type</span></a></li>
                    </ul>
                </li> 
                <li class='has-sub'><?php
                    echo CHtml::ajaxLink("Manage Visit Reasons", CController::createUrl('visitReason/adminAjax'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
            $('.managecompanies').next().slideUp('normal');
            $('.manageworkstations').next().slideUp('normal');
            $('.manageusers').next().slideUp('normal');
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitreasons').next().slideDown('normal');
            $('.managereports').next().slideUp('normal');
        }",
                            ), array(
                        'class' => 'managevisitreasons',
                    ));
                    ?>
                    <ul <?php
                    if ($this->id == 'visitReason') {
                        echo "style='display:block ;'";
                    }
                    ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('visitReason/create'); ?>' class="addSubMenu"><span>Add Visit Reason</span></a></li>
                    </ul>
                </li>
                <li class=''><?php
                    echo CHtml::ajaxLink("Manage Visits", CController::createUrl('visit/admin'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
            $('.manageworkstations').next().slideUp('normal');
            $('.managecompanies').next().slideUp('normal');
            $('.manageusers').next().slideUp('normal');
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitreasons').next().slideUp('normal');
            $('.managereports').next().slideUp('normal');
        }",
                            ), array(
                        'class' => 'managevisits',
                    ));
                    ?>

                </li>

            <?php } else {
                ?>

                <li class='has-sub'><a class='managevisitorrecords' href='<?php echo Yii::app()->createUrl('visitor/admin'); ?>'><span>Manage Visitors</span></a>

                    <ul <?php
                    if ($this->id == 'visitor' || $this->action->id == 'exportvisitorrecords') {
                        echo "style='display:block ;'";
                    }
                    ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/addvisitor'); ?>' class="addSubMenu"><span>Add Visitor Profile</span></a></li>

                        <li><a href='<?php echo Yii::app()->createUrl('visitor/create&action=register'); ?>' class="addSubMenu"><span>Log Visit</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/create&action=preregister'); ?>' class="addSubMenu"><span>Preregister Visit</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('visit/exportvisitorrecords'); ?>' ><span>Export Visit History</span></a></li>
                    </ul>
                </li>
            <?php }
            ?>
            <li class='has-sub'><?php
                echo CHtml::ajaxLink("Reports", CController::createUrl('visit/evacuationReportAjax'), array(
                    'update' => '#content',
                    'complete' => "js:function(html){
            $('.manageworkstations').next().slideUp('normal');
            $('.managecompanies').next().slideUp('normal');
            $('.manageusers').next().slideUp('normal');
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitreasons').next().slideUp('normal');
            $('.managereports').next().slideDown('normal');
        }",
                        ), array(
                    'class' => 'managereports',
                ));
                ?>
                <ul <?php
                if ($this->action->id == 'evacuationReport' || $this->action->id == 'visitorRegistrationHistory') {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/evacuationReport'); ?>' ><span>Evacuation Report</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/visitorRegistrationHistory'); ?>'><span>Visitor Registration History</span></a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<script>
    $(document).ready(function() {

    })
</script>

