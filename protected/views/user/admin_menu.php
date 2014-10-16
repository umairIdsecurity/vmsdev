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
if ( $session['role'] == Roles::ROLE_AGENT_OPERATOR || $session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_STAFFMEMBER || $session['role'] == Roles::ROLE_VISITOR) {
    echo 'display:none;';
}
?>" >
    <div class="sidebarTitle" style="">Administration</div><br><div id='cssmenu'>
        <ul>
            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                ?>
                <li class='has-sub'><a href='<?php echo Yii::app()->createUrl('company/admin'); ?>'><span>Manage Companies</span></a>
                    <ul>
                        <li><a href='<?php echo Yii::app()->createUrl('company/create'); ?>' class="has-sub-sub"><span>Add Company</span></a></li>
                    </ul>
                </li>

                <?php
            } else {
                ?>
                <li class=''><a href='<?php echo Yii::app()->createUrl('company/update/&id=' . $session['company']) ?>'><span>Organisation Settings</span></a></li>
            <?php }
            ?>
            <li class='has-sub'><a href='<?php echo Yii::app()->createUrl('workstation/admin') ?>'><span>Manage Workstations</span></a>
                <ul>
                    <li><a href='<?php echo Yii::app()->createUrl('workstation/create'); ?>' class="has-sub-sub"><span>Add Workstation</span></a></li>
                </ul>
            </li>

            <li class='has-sub'><a href='<?php echo Yii::app()->createUrl('user/admin'); ?>'><span>Manage Users</span></a>
                <ul>
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
                    <li ><a href='<?php echo Yii::app()->createUrl('user/systemaccessrules'); ?>'><span>Set Access Rules</span></a></li>

                </ul>
            </li>

            <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) {
                ?>
                <li class='has-sub'><a href='<?php echo Yii::app()->createUrl('visitor/admin'); ?>'><span>Manage Visitor Records</span></a>
                    <ul>
                        <li><a href='<?php echo Yii::app()->createUrl('visitor/create'); ?>' class="has-sub-sub"><span>Register a Visitor</span></a></li>
                    </ul>
                </li>    
                <li class='has-sub'><a href='<?php echo Yii::app()->createUrl('visitReason/admin'); ?>'><span>Manage Visit Reasons</span></a>
                    <ul>
                        <li><a href='<?php echo Yii::app()->createUrl('visitReason/create'); ?>' class="has-sub-sub"><span>Add Reason</span></a></li>
                    </ul>
                </li>


                <?php
            }
            ?>
            <li class=''><a href='#' ><span>Active Directory</span></a></li>

            <li class=''><a href='#'><span>Reports</span></a></li>
        </ul>
    </div>
</div>