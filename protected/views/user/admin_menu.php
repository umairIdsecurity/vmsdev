<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-sidebar.js');
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
    <div class="sidebarTitle" style=""><a href="<?php echo Yii::app()->createUrl('workstation/admin') ?>" class="dashboard-icon"></a>Administration</div><br><div id='cssmenu' >
        <ul>

            <?php
            if ($session['role'] == Roles::ROLE_ADMIN) {
            ?>
            <!-- menu for Organisation Settings -->

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
            <!-- menu for Organisation Settings -->

            <?php } ?>


            <!-- menu for Workstations -->
            <li class='has-sub'><a class='manageworkstations' href='<?php echo Yii::app()->createUrl('workstation/admin'); ?>'><span>Workstations</span></a>

            
                <ul <?php
                if ($this->id == 'workstation') {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('workstation/create'); ?>' class="addSubMenu"><span>Add Workstation</span></a></li>
                </ul>
            </li><!-- menu for Workstations -->

            <!-- menu for CVMS Users -->
           <li class='has-sub'><a class='manageusers' href='<?php echo Yii::app()->createUrl('user/admin',array('vms'=>'cvms')); ?>'><span>Users (CVMS Users)</span></a>

                <ul <?php
                if ($this->id == 'user' && !CHelper::is_accessing_avms_features()) {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('user/create/&role=1'); ?>' class="has-sub-sub"><div class="customIcon-adminmenu">+</div><span>Add User</span></a></li>

                    <?php
                    switch ($session['role']) {
                        case Roles::ROLE_SUPERADMIN:
                            ?>
                    <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=1'); ?>'><span <?php CHelper::is_selected_item(1);?> >Add Administrator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=6'); ?>'><span <?php CHelper::is_selected_item(6);?> >Add Agent Administrator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=8'); ?>'><span <?php CHelper::is_selected_item(8);?> >Add Operator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=7'); ?>'><span <?php CHelper::is_selected_item(7);?> >Add Agent Operator</span></a></li>
                            <li class='submenu addSubMenu'><?php
//                                echo CHtml::ajaxLink("<span>Add Host</span>",
//                                    CController::createUrl('dashboard/addHost/&role=9'), array('update' => '#content')
//                                );
                            ?>
                               <a href='<?php echo Yii::app()->createUrl('user/create/&role=9'); ?>'><span <?php CHelper::is_selected_item(9);?> >Add Host</span></a> 
                            </li>

                            <?php
                            break;
                        case Roles::ROLE_ADMIN:
                        case Roles::ROLE_ISSUING_BODY_ADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=1'); ?>'><span <?php CHelper::is_selected_item(1);?> >Add Administrator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=6'); ?>'><span <?php CHelper::is_selected_item(6);?> >Add Agent Administrator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=8'); ?>'><span <?php CHelper::is_selected_item(8);?> >Add Operator</span></a></li>
                            <li class='submenu addSubMenu'><?php
//                                echo CHtml::ajaxLink("<span>Add Host</span>",
//                                    CController::createUrl('dashboard/addHost/&role=9'), array('update' => '#content')
//                                );
                                ?>
                                <a href='<?php echo Yii::app()->createUrl('user/create/&role=9'); ?>'><span <?php CHelper::is_selected_item(9);?> >Add Host</span></a> 
                            </li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/importhost'); ?>'><span>Import Staff/Host Profiles</span></a></li>      
                            <?php
                            break;

                        case Roles::ROLE_AGENT_ADMIN:
                        case Roles::ROLE_AGENT_AIRPORT_ADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=6'); ?>'><span <?php CHelper::is_selected_item(6);?> >Add Agent Administrator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create/&role=7'); ?>'><span <?php CHelper::is_selected_item(7);?> >Add Agent Operator</span></a></li>
                            <li class='submenu addSubMenu'><?php
//                                echo CHtml::ajaxLink("<span>Add Host</span>",
//                                    CController::createUrl('dashboard/addHost/&role=9'), array('update' => '#content')
//                                );
                                ?>
                                <a href='<?php echo Yii::app()->createUrl('user/create/&role=9'); ?>'><span <?php CHelper::is_selected_item(9);?> >Add Host</span></a> 
                            </li>
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
            </li><!-- menu for CVMS Users -->

            <!-- menu for AVMS Users -->
            <li class='has-sub'><a class='manageusers' href='<?php echo Yii::app()->createUrl('user/admin',array('vms'=>'avms')); ?>'><span>Users (AVMS Users)</span></a>


                <ul <?php
                if ($this->id == 'user' && CHelper::is_accessing_avms_features()) {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('user/create',array('role'=> Roles::ROLE_ISSUING_BODY_ADMIN)); ?>' class="has-sub-sub"><div class="customIcon-adminmenu">+</div><span>Add User</span></a></li>

                    <?php
                    switch ($session['role']) {
                        case Roles::ROLE_SUPERADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create', array('role'=> Roles::ROLE_ISSUING_BODY_ADMIN) ); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_ISSUING_BODY_ADMIN);?> >Add Issuing Body Admin</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create', array('role'=> Roles::ROLE_AIRPORT_OPERATOR) ); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AIRPORT_OPERATOR);?>>Add Airport Operator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create', array('role'=> Roles::ROLE_AGENT_AIRPORT_ADMIN) ); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AGENT_AIRPORT_ADMIN);?>> Add Agent Airport Admin</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create', array('role'=> Roles::ROLE_AGENT_AIRPORT_OPERATOR) ); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AGENT_AIRPORT_OPERATOR);?>> Add Agent Airport Operator</span></a></li>

                            <?php
                            break;

                        case Roles::ROLE_ADMIN:
                        case Roles::ROLE_ISSUING_BODY_ADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create', array('role'=> Roles::ROLE_ISSUING_BODY_ADMIN) ); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_ISSUING_BODY_ADMIN);?>>Add Issuing Body Admin</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create', array('role'=> Roles::ROLE_AIRPORT_OPERATOR) ); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AIRPORT_OPERATOR);?>>Add Airport Operator</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create', array('role'=> Roles::ROLE_AGENT_AIRPORT_ADMIN)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AGENT_AIRPORT_ADMIN);?>>Add Agent Airport Admin</span></a></li>

                            <?php
                            break;

                        case Roles::ROLE_AGENT_ADMIN:
                        case Roles::ROLE_AGENT_AIRPORT_ADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create', array('role'=> Roles::ROLE_AGENT_AIRPORT_ADMIN)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AGENT_AIRPORT_ADMIN);?>>Add Agent Airport Admin</span></a></li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create', array('role'=> Roles::ROLE_AGENT_AIRPORT_OPERATOR)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AGENT_AIRPORT_OPERATOR);?>>Add Agent Airport Operator</span></a></li>

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
            </li><!-- menu for AVMS Users -->


            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                ?>
                <!-- menu for Visitors -->
                <li class='has-sub'><a class='managevisitorrecords' href='<?php echo Yii::app()->createUrl('visitor/admin'); ?>'><span>Visitors</span></a>

                    <ul <?php
                    if ($this->id == 'visitor' || $this->action->id == 'exportvisitorrecords') {
                        echo "style='display:block ;'";
                    }
                    ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/addvisitor'); ?>' class="addSubMenu"><span>Add Visitor Profile</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/create&action=register'); ?>' class="addSubMenu"><span>Log Visit</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/create&action=preregister'); ?>' class="addSubMenu"><span>Preregister Visit</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('visit/exportvisitorrecords'); ?>' ><span>Export Visit History</span></a></li>
                         <li><a href='<?php echo Yii::app()->createUrl('visitor/importVisitHistory'); ?>' ><span>Import Visit History</span></a></li>
                    </ul>
                </li>   <!-- menu for Visitors -->

                <!-- menu for Visitors Types -->
                <li class='has-sub'><?php
                    echo CHtml::ajaxLink("Visitor Types", CController::createUrl('visitorType/adminAjax'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
            $('.managecompanies').next().slideUp('normal');
            $('.manageworkstations').next().slideUp('normal');
            $('.manageusers').next().slideUp('normal');
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitortype').next().slideDown('normal');
            $('.managevisitreasons').next().slideUp('normal');
            $('.managereports').next().slideUp('normal');
            $('.manageavmsreports').next().slideUp('normal');
        }",
                            ), array(
                        'class' => 'managevisitortype',
                    ));
                    ?>
                    <ul <?php
                    if ($this->id == 'visitorType' && $this->action->id != 'visitorsByTypeReport' && $this->action->id != 'visitorsByProfiles') {
                        echo "style='display:block ;'";
                    }
                    ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('visitorType/create'); ?>' class="addSubMenu"><span>Add Visitor Type</span></a></li>
                    </ul>
                </li> <!-- menu for Visitors Types -->

                <!-- menu for Visitors Reasons -->
                <li class='has-sub'><?php
                    echo CHtml::ajaxLink("Visit Reasons", CController::createUrl('visitReason/adminAjax'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
            $('.managecompanies').next().slideUp('normal');
            $('.manageworkstations').next().slideUp('normal');
            $('.manageusers').next().slideUp('normal');
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitreasons').next().slideDown('normal');
            $('.managereports').next().slideUp('normal');
            $('.managevisitortype').next().slideUp('normal');
            $('.manageavmsreports').next().slideUp('normal');
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
                </li><!-- menu for Visitors Reasons --

                <!-- menu for Visits -->
                <li class=''><?php
                    echo CHtml::ajaxLink("Visits", CController::createUrl('visit/admin'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
            $('.manageworkstations').next().slideUp('normal');
            $('.managecompanies').next().slideUp('normal');
            $('.manageusers').next().slideUp('normal');
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitreasons').next().slideUp('normal');
            $('.managereports').next().slideUp('normal');
            $('.managevisitortype').next().slideUp('normal');
            $('.manageavmsreports').next().slideUp('normal');
        }",
                            ), array(
                        'class' => 'managevisits',
                    ));
                    ?>

                </li><!-- menu for Visits -->

            <?php } else {
                ?>
                <!-- menu for Visitors -->
                <li class='has-sub'><a class='managevisitorrecords' href='<?php echo Yii::app()->createUrl('visitor/admin'); ?>'><span>Visitors</span></a>

                    <ul <?php
                    if ($this->id == 'visitor' || $this->action->id == 'exportvisitorrecords') {
                        echo "style='display:block ;'";
                    }
                    ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/addvisitor'); ?>' class="addSubMenu"><span>Add Visitor Profile</span></a></li>

                        <li><a href='<?php echo Yii::app()->createUrl('visitor/create&action=register'); ?>' class="addSubMenu"><span>Log Visit</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/create&action=preregister'); ?>' class="addSubMenu"><span>Preregister Visit</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('visit/exportvisitorrecords'); ?>' ><span>Export Visit History</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/importVisitHistory'); ?>' ><span>Import Visit History</span></a></li>
                    </ul>
                </li><!-- menu for Visitors -->
            <?php }
                  // Show Visitor Types to All Admins only  
                  if( Yii::app()->user->role == Roles::ROLE_ADMIN) {
             ?>    <!-- menu for Visitors Types -->
                <li class='has-sub'><?php
                    echo CHtml::ajaxLink("Visitor Types", CController::createUrl('visitorType/adminAjax'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
                        $('.managecompanies').next().slideUp('normal');
                        $('.manageworkstations').next().slideUp('normal');
                        $('.manageusers').next().slideUp('normal');
                        $('.managevisitorrecords').next().slideUp('normal');
                        $('.managevisitortype').next().slideDown('normal');
                        $('.managevisitreasons').next().slideUp('normal');
                        $('.managereports').next().slideUp('normal');
                        $('.manageavmsreports').next().slideUp('normal');
                    }",
                            ), array(
                        'class' => 'managevisitortype',
                    ));
            ?>
                    <ul <?php
                    if ($this->id == 'visitorType') {
                        echo "style='display:block ;'";
                    }
                    ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('visitorType/create'); ?>' class="addSubMenu"><span>Add Visitor Type</span></a></li>
                    </ul>
                </li> <!-- menu for Visitors Types -->

             <?php         
                  }
             ?>

            <!-- menu for companies -->
            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                ?>

                <li class='has-sub'><?php
                    echo CHtml::ajaxLink("Companies", CController::createUrl('company/adminAjax'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
            $('.manageworkstations').next().slideUp('normal');
            $('.managecompanies').next().slideDown('normal');
            $('.manageusers').next().slideUp('normal');
            //$('.manageusers').next().hide();
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitreasons').next().slideUp('normal');
            $('.managereports').next().slideUp('normal');
            $('.managevisitortype').next().slideUp('normal');
            $('.manageavmsreports').next().slideUp('normal');
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
                    </ul>
                </li>
            <?php
            } else {
            if ($session['role'] == Roles::ROLE_ADMIN) {
                ?>
                <!--WangFu Modified-->

                <li class='has-sub'>
                    <?php
                    echo CHtml::ajaxLink("Companies", CController::createUrl('company/adminAjax'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
				            $('.manageworkstations').next().slideUp('normal');
				            $('.managecompanies').next().slideDown('normal');
				            $('.manageusers').next().slideUp('normal');
				            //$('.manageusers').next().hide();
				            $('.managevisitorrecords').next().slideUp('normal');
				            $('.managevisitreasons').next().slideUp('normal');
				            $('.managereports').next().slideUp('normal');
				            $('.managevisitortype').next().slideUp('normal');
				            $('.manageavmsreports').next().slideUp('normal');
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
                    </ul>
                </li>


                <!--WangFu Modified-->


            <?php
            }
            ?>
            <?php }
            ?><!-- menu for companies -->

			<!-- menu for Tenant -->
            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                ?>

                <li class='has-sub'><?php
                    echo CHtml::ajaxLink("Tenant", CController::createUrl('tenant/adminAjax'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
            $('.manageworkstations').next().slideUp('normal');
			$('.managecompanies').next().slideUp('normal');
            $('.managetenant').next().slideDown('normal');
            $('.manageusers').next().slideUp('normal');
            //$('.manageusers').next().hide();
            $('.managevisitorrecords').next().slideUp('normal');
            $('.managevisitreasons').next().slideUp('normal');
            $('.managereports').next().slideUp('normal');
            $('.managevisitortype').next().slideUp('normal');
        }",
                    ), array(
                        'class' => 'managetenant',
                    ));
                    ?>
                    <ul <?php
                    if ($this->id == 'company' || $this->id == 'companyLafPreferences') {
                        echo "style='display:block ;'";
                    }
                    ?>>

                        <li><a href='<?php echo Yii::app()->createUrl('tenant/create/&role=1'); ?>' class="addSubMenu ajaxLinkLi"><span>Add Tenant</span></a></li>
                    </ul>
                </li>
            <?php
            } else {
            if ($session['role'] == Roles::ROLE_ADMIN) {
                ?>
                <!--WangFu Modified-->

                <li class='has-sub'>
                    <?php
                    echo CHtml::ajaxLink("Tenant", CController::createUrl('tenant/adminAjax'), array(
                        'update' => '#content',
                        'complete' => "js:function(html){
				            $('.manageworkstations').next().slideUp('normal');
				            $('.managecompanies').next().slideUp('normal');
							$('.managetenant').next().slideDown('normal');
				            $('.manageusers').next().slideUp('normal');
				            //$('.manageusers').next().hide();
				            $('.managevisitorrecords').next().slideUp('normal');
				            $('.managevisitreasons').next().slideUp('normal');
				            $('.managereports').next().slideUp('normal');
				            $('.managevisitortype').next().slideUp('normal');
				        }",
                    ), array(
                        'class' => 'managetenant',
                    ));
                    ?>
                    <ul <?php
                    if ($this->id == 'company' || $this->id == 'companyLafPreferences') {
                        echo "style='display:block ;'";
                    }
                    ?>>

                        <li><a href='<?php echo Yii::app()->createUrl('tenant/create'); ?>' class="addSubMenu ajaxLinkLi"><span>Add Tenant</span></a></li>
                    </ul>
                </li>


                <!--WangFu Modified-->


            <?php
            }
            ?>
            <?php }
            ?><!-- menu for tenant -->
			
            <!-- menu for Reports -->
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
            $('.managevisitortype').next().slideUp('normal');
            $('.manageavmsreports').next().slideUp('normal');
        }",
                        ), array(
                    'class' => 'managereports',
                ));
                ?>
                <ul <?php
                if ($this->action->id == 'evacuationReport' || $this->action->id == 'visitorsByProfiles' || $this->action->id == 'visitorsByTypeReport' || $this->action->id == 'visitorRegistrationHistory' || $this->action->id == 'corporateTotalVisitCount' || Yii::app()->controller->id == 'auditTrail') {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/evacuationReport'); ?>' ><span>Evacuation Report</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/visitorRegistrationHistory'); ?>'><span>Visitor Registration History</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/corporateTotalVisitCount'); ?>'><span>Corporate Total Visit Count</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('visitorType/visitorsByTypeReport'); ?>'><span>Total Visitors by Visitor Type</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('reports/visitorsByProfiles'); ?>'><span>New Visitors Profiles</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('auditTrail/admin'); ?>'><span>Audit Trail</span></a></li>
                </ul>
            </li><!-- menu for Reports -->

            <!-- menu for AVMS Reports -->
            <li class='has-sub'>
                <?php
                echo CHtml::ajaxLink("AVMS Reports", CController::createUrl('visit/vicTotalVisitCountAjax'), array(
                    'update' => '#content',
                    'complete' => "js:function(html){
                        $('.manageworkstations').next().slideUp('normal');
                        $('.managecompanies').next().slideUp('normal');
                        $('.manageusers').next().slideUp('normal');
                        $('.managevisitorrecords').next().slideUp('normal');
                        $('.managevisitreasons').next().slideUp('normal');
                        $('.managereports').next().slideUp('normal');
                        $('.managevisitortype').next().slideUp('normal');
                        $('.manageavmsreports').next().slideDown('normal');
                    }",
                ), array(
                    'class' => 'manageavmsreports',
                ));
                ?>
                <ul <?php
                if ($this->action->id == 'vicTotalVisitCount') {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/vicTotalVisitCount'); ?>'><span>Total Visits VICs</span></a></li>
                </ul>
            </li><!-- menu for AVMS Reports -->

            <!-- menu for Helpdesk -->
            <li class='has-sub'>
                <a class='managevisitorrecords' href='<?php echo Yii::app()->createUrl('helpDesk/admin'); ?>'><span>Help Desk</span></a>
              <ul <?php
                    if ($this->id == 'helpDesk'  || $this->id == 'helpDeskGroup') {
                        echo "style='display:block ;'";
                    }
                    ?> >
                
                 <li><a href='<?php echo Yii::app()->createUrl('helpDeskGroup/create'); ?>' class="addSubMenu"><span>Add Help Desk Group</span></a></li>
                  <li><a href='<?php echo Yii::app()->createUrl('helpDesk/create'); ?>' class="addSubMenu"><span>Add Help Desk</span></a></li>
                 <li><a href='<?php echo Yii::app()->createUrl('helpDesk/admin'); ?>' ><span>Help Desk</span></a></li>
                 <li><a href='<?php echo Yii::app()->createUrl('helpDeskGroup/admin'); ?>' ><span>Help Desk Group</span></a></li>
              </ul>
            </li><!-- menu for helpdesk -->
            
            <!-- Notifications -->
             <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) { ?>
            <li class='has-sub'>
                   <a class='managevisitorrecords' href='<?php echo Yii::app()->createUrl('notifications/admin'); ?>'><span>Notifications</span></a>
                   <ul <?php echo $this->id == 'notifications'?"style='display:block'":"style='display:none'";?>>
                       <li><a href='<?php echo Yii::app()->createUrl('notifications/create'); ?>' class="addSubMenu"><span>Create Notification</span></a></li>
                   </ul>
            </li>
            <?php  } ?>
           
            <!-- Ends Notifications -->
        </ul>
    </div>
</div>

<script>
    $(document).ready(function() {

    })
</script>

