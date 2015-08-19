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
// Only show Allowed modules to tenant
$module = CHelper::get_allowed_module();
?>
<input type="hidden" value="<?php echo $session['role'] ?>" id="sessionRoleForSideBar">

<div id="sidebar2" style="<?php
if ($session['role'] == Roles::ROLE_AGENT_OPERATOR || $session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_STAFFMEMBER || $session['role'] == Roles::ROLE_VISITOR) {
    echo 'display:none;';
}
?>" class="administrationMenu">
    <div class="sidebarTitle" style=""><a href="<?php echo Yii::app()->createUrl('dashboard/admindashboard'); ?>" class="dashboard-icon"></a>Administration</div>
    <br>
    <div id='cssmenu'>
        <ul>

            <!-- menu for Tenant -->
            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) { ?>
                <li class='has-sub'>
                    <?php echo CHtml::link('Tenant', array('tenant/admin'), array('class' => 'managetenant')) ?>

                    <ul <?php if ($this->id == 'tenant') {
                        echo "style='display:block ;'";
                    }
                    ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('tenant/create/&role=1'); ?>' class="addSubMenu ajaxLinkLi"><span>Add Tenant</span></a></li>
                    </ul>
                </li>
            <?php
            }
            ?><!-- menu for tenant -->

            <?php
            if ($session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_ISSUING_BODY_ADMIN) {
                ?>
                <!-- menu for Organisation Settings -->

                <li class='has-sub'>

                    <a href='<?php echo Yii::app()->createUrl('tenant/edit/&id=' . $session['tenant']); ?>'><span>Organization Settings</span></a>
                    <ul <?php
                    if ($this->id == 'tenant' || $this->id == 'companyLafPreferences') {
                        echo "style='display:block ;'";
                    }
                    ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('CompanyLafPreferences/customisation'); ?>'
                               class="ajaxLinkLi"><span>Customise Display</span></a></li>

                    </ul>
                </li>
                <!-- menu for Organisation Settings -->

            <?php } ?>


            <!-- menu for Workstations -->
            <li class='has-sub'><a class='manageworkstations'
                                   href='<?php echo Yii::app()->createUrl('workstation/admin'); ?>'><span>Workstations</span></a>


                <ul <?php
                if ($this->id == 'workstation') {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('workstation/create'); ?>' class="addSubMenu"><span>Add Workstation</span></a>
                    </li>
                </ul>
            </li>
            <!-- menu for Workstations -->

            <!-- menu for CVMS Users -->
            <?php if( $module == "CVMS" || $module == "Both")  { ?>
            <li class='has-sub'><a class='manageusers' href='<?php echo Yii::app()->createUrl('user/admin',
                    array('vms' => 'cvms')); ?>'><span>CVMS Users</span></a>

                <ul <?php
                if ($this->id == 'user' && !CHelper::is_accessing_avms_features()) {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('user/create'); ?>' class="has-sub-sub">
                            <div class="customIcon-adminmenu">+</div>
                            <span>Add User</span></a></li>

                    <?php
                    switch ($session['role']) {
                        case Roles::ROLE_SUPERADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a
                                    href='<?php echo Yii::app()->createUrl('user/create/&role=1'); ?>'><span <?php CHelper::is_selected_item(1);?> >Add Administrator</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a
                                    href='<?php echo Yii::app()->createUrl('user/create/&role=6'); ?>'><span <?php CHelper::is_selected_item(6);?> >Add Agent Administrator</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a
                                    href='<?php echo Yii::app()->createUrl('user/create/&role=8'); ?>'><span <?php CHelper::is_selected_item(8);?> >Add Operator</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a
                                    href='<?php echo Yii::app()->createUrl('user/create/&role=7'); ?>'><span <?php CHelper::is_selected_item(7);?> >Add Agent Operator</span></a>
                            </li>
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
                            <li class="submenu addSubMenu"><a
                                    href='<?php echo Yii::app()->createUrl('user/create/&role=1'); ?>'><span <?php CHelper::is_selected_item(1);?> >Add Administrator</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a
                                    href='<?php echo Yii::app()->createUrl('user/create/&role=6'); ?>'><span <?php CHelper::is_selected_item(6);?> >Add Agent Administrator</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a
                                    href='<?php echo Yii::app()->createUrl('user/create/&role=8'); ?>'><span <?php CHelper::is_selected_item(8);?> >Add Operator</span></a>
                            </li>
                            <li class='submenu addSubMenu'><?php
                                //                                echo CHtml::ajaxLink("<span>Add Host</span>",
                                //                                    CController::createUrl('dashboard/addHost/&role=9'), array('update' => '#content')
                                //                                );
                                ?>
                                <a href='<?php echo Yii::app()->createUrl('user/create/&role=9'); ?>'><span <?php CHelper::is_selected_item(9);?> >Add Host</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a
                                    href='<?php echo Yii::app()->createUrl('user/importhost'); ?>'><span>Import Staff/Host Profiles</span></a>
                            </li>
                            <?php
                            break;

                        case Roles::ROLE_AGENT_ADMIN:
                        case Roles::ROLE_AGENT_AIRPORT_ADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a
                                    href='<?php echo Yii::app()->createUrl('user/create/&role=6'); ?>'><span <?php CHelper::is_selected_item(6);?> >Add Agent Administrator</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a
                                    href='<?php echo Yii::app()->createUrl('user/create/&role=7'); ?>'><span <?php CHelper::is_selected_item(7);?> >Add Agent Operator</span></a>
                            </li>
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
                </ul>
            </li>
             
            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN || $session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_ISSUING_BODY_ADMIN) { ?>
                <li class='has-sub'>
                    <a class='managevisitorrecords'
                       href='<?php echo Yii::app()->createUrl('user/systemaccessrules', array('vms' => 'cvms')); ?>'>
                        <span>CVMS Access Control</span>
                    </a>
                    <ul <?php echo ($this->id == 'user' && $this->action->id == 'systemaccessrules') ? "style='display:block'" : "style='display:none'"; ?>>
                        <li>
                            <a href='<?php echo Yii::app()->createUrl('user/systemaccessrules', array('vms' => 'cvms')); ?>'><span>Workstation Access Control</span></a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <!-- menu for CVMS Users -->
            
             <!-- menu for CVMS Visitors -->
            <li class='has-sub'><a class='managevisitorrecords'
                                   href='<?php echo Yii::app()->createUrl('visitor/admin', array('vms' => 'cvms')); ?>'><span>CVMS Visitors</span></a>

                <ul <?php
                if ( ( ($this->id == 'visitor' || $this->id == 'visitorType' || $this->id == 'visitReason'  ) && Yii::app()->request->getParam('vms') == 'cvms') || $this->action->id == 'exportvisitorrecords') {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/exportvisitorrecords'); ?>'><span>Export Visit History</span></a>
                    </li>
                    <li><a href='<?php echo Yii::app()->createUrl('visitor/importVisitHistory'); ?>'><span>Import Visit History</span></a>
                    </li>
                        <?php if($session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_ISSUING_BODY_ADMIN){ ?>
                        <li>
                            <a class="managevisitortype addSubMenu" href='<?php echo Yii::app()->createUrl('visitorType/index', array('vms' => 'cvms')); ?>'><span>Visitor Types</span></a>
                            <ul <?php
                            if ($this->id == 'visitorType') {
                                echo "style='display:block ;'";
                            }
                            ?>>
                                <li><a href='<?php echo Yii::app()->createUrl('visitorType/create', array('vms' => 'cvms')); ?>'><span>Add Visitor Type</span></a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="managevisitreasons addSubMenu" href='<?php echo Yii::app()->createUrl('visitReason/admin', array('vms' => 'cvms')); ?>'><span>Visit Reasons</span></a>
                            <ul <?php
                            if ($this->id == 'visitReason') {
                                echo "style='display:block ;'";
                            }
                            ?>>
                                <li><a href='<?php echo Yii::app()->createUrl('visitReason/create', array('vms' => 'cvms')); ?>' class="subMenu"><span>Add Visit Reason</span></a></li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </li>  <!-- end menu for CVMS Visitors -->
            
        <?php } ?>
            
            <!-- menu for AVMS Users -->
            <?php if($module == "AVMS" || $module == "Both") { ?>
            <li class='has-sub'><a class='manageusers' href='<?php echo Yii::app()->createUrl('user/admin',
                    array('vms' => 'avms')); ?>'><span>AVMS Users</span></a>
                <ul <?php
                if ($this->id == 'user' && CHelper::is_accessing_avms_features() && $this->action->id != 'systemaccessrules') {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('user/create',
                        array('role' => Roles::ROLE_AGENT_AIRPORT_ADMIN)); ?>' class="has-sub-sub">
                        <div class="customIcon-adminmenu">+</div>
                        <span>Add User</span></a></li>

                    <?php
                    switch ($session['role']) {
                        case Roles::ROLE_SUPERADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create',
                                    array('role' => Roles::ROLE_ISSUING_BODY_ADMIN)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_ISSUING_BODY_ADMIN);?> >Add Issuing Body Admin</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create',
                                    array('role' => Roles::ROLE_AIRPORT_OPERATOR)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AIRPORT_OPERATOR);?>>Add Airport Operator</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create',
                                    array('role' => Roles::ROLE_AGENT_AIRPORT_ADMIN)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AGENT_AIRPORT_ADMIN);?>> Add Agent Airport Admin</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create',
                                    array('role' => Roles::ROLE_AGENT_AIRPORT_OPERATOR)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AGENT_AIRPORT_OPERATOR);?>> Add Agent Airport Operator</span></a>
                            </li>

                            <?php
                            break;

                        case Roles::ROLE_ADMIN:
                        case Roles::ROLE_ISSUING_BODY_ADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create',
                                    array('role' => Roles::ROLE_ISSUING_BODY_ADMIN)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_ISSUING_BODY_ADMIN);?>>Add Issuing Body Admin</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create',
                                    array('role' => Roles::ROLE_AIRPORT_OPERATOR)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AIRPORT_OPERATOR);?>>Add Airport Operator</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create',
                                    array('role' => Roles::ROLE_AGENT_AIRPORT_ADMIN)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AGENT_AIRPORT_ADMIN);?>>Add Agent Airport Admin</span></a>
                            </li>

                            <?php
                            break;

                        case Roles::ROLE_AGENT_ADMIN:
                        case Roles::ROLE_AGENT_AIRPORT_ADMIN:
                            ?>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create',
                                    array('role' => Roles::ROLE_AGENT_AIRPORT_ADMIN)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AGENT_AIRPORT_ADMIN);?>>Add Agent Airport Admin</span></a>
                            </li>
                            <li class="submenu addSubMenu"><a href='<?php echo Yii::app()->createUrl('user/create',
                                    array('role' => Roles::ROLE_AGENT_AIRPORT_OPERATOR)); ?>'><span <?php CHelper::is_selected_item(Roles::ROLE_AGENT_AIRPORT_OPERATOR);?>>Add Agent Airport Operator</span></a>
                            </li>

                            <?php
                            break;
                        default:
                            echo "";
                            break;
                    };
                    ?>

                </ul>
            </li>

            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN || $session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_ISSUING_BODY_ADMIN) { ?>
                <li class='has-sub'>
                    <a class='managevisitorrecords'
                       href='<?php echo Yii::app()->createUrl('user/systemaccessrules', array('vms' => 'avms')); ?>'>
                        <span>AVMS Access Control</span>
                    </a>
                    <ul <?php echo ($this->id == 'user' && $this->action->id == 'systemaccessrules') ? "style='display:block'" : "style='display:none'"; ?>>
                        <li>
                            <a href='<?php echo Yii::app()->createUrl('user/systemaccessrules', array('vms' => 'avms')); ?>'><span>Workstation Access Control</span></a>
                        </li>
                    </ul>
                </li>
            <?php } ?>
            <!-- menu for AVMS Users -->
            
            <!-- menu for AVMS Visitors -->
            <li class='has-sub'><a class='managevisitorrecords'
                                   href='<?php echo Yii::app()->createUrl('visitor/admin', array('vms' => 'avms')); ?>'><span>AVMS Visitors</span></a>

                <ul <?php
                if ( ( ($this->id == 'visitor' || $this->id == 'visitorType' || $this->id == 'visitReason') && Yii::app()->request->getParam('vms') == 'avms' )  || $this->action->id == 'exportvisitorrecords') {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/exportvisitorrecords'); ?>'><span>Export Visit History</span></a>
                    </li>
                    <li><a href='<?php echo Yii::app()->createUrl('visitor/importVisitHistory'); ?>'><span>Import Visit History</span></a>
                    </li>
                    <?php if($session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_ISSUING_BODY_ADMIN){ ?>
                    <li>
                        <a class="managevisitortype addSubMenu" href='<?php echo Yii::app()->createUrl('visitorType/index', array('vms' => 'avms')); ?>'><span>Visitor Types</span></a>
                        <ul <?php
                        if ($this->id == 'visitorType') {
                            echo "style='display:block ;'";
                        }
                        ?>>
                            <li><a href='<?php echo Yii::app()->createUrl('visitorType/create', array('vms' => 'avms')); ?>' class="subMenu"><span>Add Visitor Type</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="managevisitreasons addSubMenu" href='<?php echo Yii::app()->createUrl('visitReason/admin', array('vms' => 'avms')); ?>'><span>Visit Reasons</span></a>
                        <ul <?php
                        if ($this->id == 'visitReason') {
                            echo "style='display:block ;'";
                        }
                        ?>>
                            <li><a href='<?php echo Yii::app()->createUrl('visitReason/create', array('vms' => 'avms')); ?>' class="subMenu"><span>Add Visit Reason</span></a></li>
                        </ul>
                    </li>
                    <?php } ?>

                </ul>
            </li>   <!-- end menu for AVMS Visitors -->
        <?php } ?>





            <!-- menu for companies -->
            <?php 
                if ($session['role'] == Roles::ROLE_SUPERADMIN || 
                        $session['role'] == Roles::ROLE_ADMIN || 
                            $session['role'] == Roles::ROLE_ISSUING_BODY_ADMIN ) {
            ?>
                <li class='has-sub'>
                    <?php echo CHtml::link('Companies', array('company/index'), array('class' => 'managecompanies')) ?>
                    <ul <?php
                    if ($this->id == 'company') {
                        echo "style='display:block ;'";
                    }
                    ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('company/create'); ?>'
                               class="addSubMenu ajaxLinkLi"><span>Add Company</span></a></li>
                    </ul>
                </li>
            <?php
            }                
        ?><!-- menu for companies -->
 
     <?php if($module == "Both" || $module == "CVMS") {  ?>
            <!-- menu for Reports -->
            <li class='has-sub'>
                <?php echo CHtml::link('CVMS Reports', array('visit/evacuationReport'), array('class' => 'managereports')) ?>
                <ul <?php
                if ($this->action->id == 'evacuationReport' || $this->action->id == 'visitorsByProfiles' || $this->action->id == 'visitorsByWorkstationReport' || $this->action->id == 'visitorsByTypeReport' || $this->action->id == 'visitorRegistrationHistory' || $this->action->id == 'corporateTotalVisitCount' || $this->action->id == 'cvms') {
                    echo "style='display:block ;'";
                }
                ?>>

                    <li><a href='<?php echo Yii::app()->createUrl('visit/evacuationReport'); ?>' ><span>Evacuation Report</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/visitorRegistrationHistory'); ?>'><span>Visitor Registration History</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/corporateTotalVisitCount'); ?>'><span>Corporate Total Visit Count</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('visitorType/visitorsByTypeReport'); ?>'><span>Total Visitors by Visitor Type</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('visitorType/visitorsByWorkstationReport'); ?>'><span>Total Visitors by Workstation</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('reports/visitorsByProfiles'); ?>'><span>New Visitors Profiles</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('auditTrail/cvms'); ?>'><span>Audit Trail</span></a></li>

                </ul>
            </li>
            <!-- menu for Reports -->
            <?php } ?>
            
            <?php if($module == "Both" || $module == "AVMS") {  ?>
            <!-- menu for AVMS Reports -->
            <li class='has-sub'>
                <?php
                echo CHtml::link("AVMS Reports", array('visit/vicTotalVisitCount'), array(
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
                if ($this->action->id == 'vicTotalVisitCount' || $this->action->id == 'vicRegister' || $this->action->id == 'totalVicsByWorkstation' || $this->action->id == 'profilesAvmsVisitors' || $this->action->id == 'visitorsVicByType' || $this->action->id == 'visitorsVicByCardType' || $this->action->id == 'conversionVicToAsic' || $this->action->id == 'avms') {
                    echo "style='display:block ;'";
                }
                ?>>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/vicTotalVisitCount'); ?>'><span>Total Visits</span></a>
                    </li>
                    <li>
                        <a href='<?php echo Yii::app()->createUrl('visit/vicRegister'); ?>'><span>VIC Register</span></a>
                    </li>
                    <li><a href='<?php echo Yii::app()->createUrl('visit/totalVicsByWorkstation'); ?>'><span>Total VICs by Workstation</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('reports/visitorsVicByType'); ?>'><span>Total VICs by Visitor Type</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('reports/visitorsVicByCardType'); ?>'><span>Total VICs by Card Type</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('reports/profilesAvmsVisitors'); ?>'><span>New Visitors</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('reports/conversionVicToAsic'); ?>'><span>Conversion of VIC to ASIC</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('auditTrail/avms'); ?>'><span>Audit Trail</span></a></li>
                </ul>
            </li>
            <!-- menu for AVMS Reports -->
            <?php } ?>
            
            <!-- menu for Helpdesk -->
            <li class='has-sub'>
                <a class='managevisitorrecords' href='<?php echo Yii::app()->createUrl('helpDesk/admin'); ?>'><span>Help Desk</span></a>
                <ul <?php
                if ($this->id == 'helpDesk' || $this->id == 'helpDeskGroup') {
                    echo "style='display:block ;'";
                }
                ?> >

                    <li><a href='<?php echo Yii::app()->createUrl('helpDeskGroup/create'); ?>' class="addSubMenu"><span>Add Help Desk Group</span></a>
                    </li>
                    <li><a href='<?php echo Yii::app()->createUrl('helpDesk/create'); ?>' class="addSubMenu"><span>Add Help Desk</span></a>
                    </li>
                    <li><a href='<?php echo Yii::app()->createUrl('helpDesk/admin'); ?>'><span>Help Desk</span></a></li>
                    <li>
                        <a href='<?php echo Yii::app()->createUrl('helpDeskGroup/admin'); ?>'><span>Help Desk Group</span></a>
                    </li>
                </ul>
            </li>
            <!-- menu for helpdesk -->

            <!-- Notifications -->
            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN || $session['role'] == Roles::ROLE_ADMIN || $session['role'] == Roles::ROLE_ISSUING_BODY_ADMIN) { ?>
                <li class='has-sub'>
                    <a class='managevisitorrecords'
                       href='<?php echo Yii::app()->createUrl('notifications/admin'); ?>'><span>Notifications</span></a>
                    <ul <?php echo $this->id == 'notifications' ? "style='display:block'" : "style='display:none'"; ?>>
                        <li><a href='<?php echo Yii::app()->createUrl('notifications/create'); ?>'
                               class="addSubMenu"><span>Create Notification</span></a></li>
                    </ul>
                </li>
            <?php } ?>
            <!-- Ends Notifications -->
            
            <!-- REASONS -->
            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN || $session['role'] == Roles::ROLE_ADMIN) { ?>
                <li class='has-sub'>
                    <a class='managevisitorrecords' href='<?php echo Yii::app()->createUrl('contactPerson/admin'); ?>'><span>Contact Support</span></a>
                    
                    <ul <?php if($this->id == 'reasons' || $this->id == 'contactPerson'){echo "style='display:block'";}else{echo "style='display:none'";}?>>
                        <li><a href='<?php echo Yii::app()->createUrl('contactPerson/create'); ?>' class="addSubMenu"><span>Add Contact Person</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('reasons/admin'); ?>' class="addSubMenu"><span>Manage Reason</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('reasons/create'); ?>' class="addSubMenu"><span>Add Contact Reason</span></a></li>
                    </ul>
                </li>
            <?php } ?>
            <!-- Ends REASONS -->
            
        </ul>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#addContactLink').on('click', function(e) {
            $('.errorMessage').hide();
            $('#myModalLabel').html('Add Contact To Company');
            $("tr.company_contact_field").addClass('hidden');
            $("#AddCompanyContactForm_email").val("");
            $("#AddCompanyContactForm_firstName").val("");
            $("#AddCompanyContactForm_lastName").val("");
            $("#AddCompanyContactForm_mobile").val("");
            $("#AddCompanyContactForm_companyName").val($(".select2-selection__rendered").html());
            $('#AddCompanyContactForm_companyName').prop('disabled',true);
            $('#typePostForm').val('contact');
        });

        $('#addCompanyLink').on('click', function(e) {
            $('.errorMessage').hide();
            $('#myModalLabel').html('Add Company');
            $('#AddCompanyContactForm_companyName').enable();
            $("tr.company_contact_field").addClass("hidden");
            $("#AddCompanyContactForm_companyName").val("");
            $("#AddCompanyContactForm_email").val("");
            $("#AddCompanyContactForm_firstName").val("");
            $("#AddCompanyContactForm_lastName").val("");
            $("#AddCompanyContactForm_mobile").val("");
            $('#typePostForm').val('company');
        });
    });
</script>

<?php $this->renderPartial('/visitor/_add_company_contact',
    array('tenant' => $session['tenant'], 'model' => new AddCompanyContactForm())); ?>
