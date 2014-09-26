<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* @var $this UserController */
/* @var $model User */
$session = new ChttpSession;
?> 
<div id="sidebar2" style="border:1px solid #E7E7E7;width:205px;height:115%;padding-bottom:15px;<?php
if ($session['role'] == Roles::ROLE_AGENT_OPERATOR || $session['role'] == Roles::ROLE_OPERATOR || $session['role'] == Roles::ROLE_STAFFMEMBER || $session['role'] == Roles::ROLE_VISITOR) {
    echo 'display:none;';
}
?>" >
    <div style="font-size:13px;font-family:inherit;text-align:center !important;width:100%; !important;background-color:#B2B2B2;border-top-left-radius:8px;border-top-right-radius:8px;margin-top:-20px;padding:2px;margin-left:-2px;color:white;padding-top:6px;padding-bottom:5px;"><b>Administration Module</b></div><br><div id='cssmenu'>
        <ul>
<?php if ($session['role'] == Roles::ROLE_SUPERADMIN) {
    ?>
                <li class='has-sub'><a href='<?php echo Yii::app()->createUrl('company/admin'); ?>'><span>Manage Companies</span></a>
                    <ul>
                        <li><a href='<?php echo Yii::app()->createUrl('company/admin'); ?>'><span>View Companies</span></a></li>
                        <li><a href='<?php echo Yii::app()->createUrl('company/create'); ?>'><span>Add Company</span></a></li>
                    </ul>
                </li>

    <?php
} else {
    ?>
                <li class=''><a href='<?php echo Yii::app()->createUrl('company/update/&id=' . $session['company']) ?>'><span>Organization Settings</span></a></li>
                <?php }
            ?>
           <li class='has-sub'><a href='<?php echo Yii::app()->createUrl('workstation/admin') ?>'><span>Manage Workstations</span></a>
                <ul>
                    <li><a href='<?php echo Yii::app()->createUrl('workstation/admin'); ?>'><span>View Workstations</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('workstation/create'); ?>'><span>Add Workstation</span></a></li>
                </ul>
            </li>
           
            <li class='has-sub'><a href='<?php echo Yii::app()->createUrl('user/admin'); ?>'><span>Manage Users</span></a>
                <ul>
                    <li><a href='<?php echo Yii::app()->createUrl('user/admin'); ?>'><span>View Users</span></a></li>
                    <li><a href='<?php echo Yii::app()->createUrl('user/create'); ?>'><span>Add User</span></a></li>

<?php
switch ($session['role']) {
    case Roles::ROLE_SUPERADMIN:
        ?>
                            <li><a href='<?php echo Yii::app()->createUrl('user/create/&role=1'); ?>'><span>Add Administrator</span></a></li>
                            <li><a href='<?php echo Yii::app()->createUrl('user/create/&role=6'); ?>'><span>Add Agent Administrator</span></a></li>
                            <li><a href='<?php echo Yii::app()->createUrl('user/create/&role=8'); ?>'><span>Add Operator</span></a></li>
                            <li><a href='<?php echo Yii::app()->createUrl('user/create/&role=7'); ?>'><span>Add Agent Operator</span></a></li>
                            <li><a href='<?php echo Yii::app()->createUrl('user/systemaccessrules'); ?>'><span>Set Access Rules</span></a></li>

        <?php
        break;
    case Roles::ROLE_ADMIN:
        ?>
                            <li><a href='<?php echo Yii::app()->createUrl('user/create/&role=1'); ?>'><span>Add Administrator</span></a></li>
                            <li><a href='<?php echo Yii::app()->createUrl('user/create/&role=6'); ?>'><span>Add Agent Administrator</span></a></li>
                            <li><a href='<?php echo Yii::app()->createUrl('user/create/&role=8'); ?>'><span>Add Operator</span></a></li>
                            <li><a href='<?php echo Yii::app()->createUrl('user/systemaccessrules'); ?>'><span>Set Access Rules</span></a></li>

        <?php
        break;

    case Roles::ROLE_AGENT_ADMIN:
        ?>
                            <li><a href='<?php echo Yii::app()->createUrl('user/create/&role=7'); ?>'><span>Add Agent Operator</span></a></li>
                            <li><a href='<?php echo Yii::app()->createUrl('user/systemaccessrules'); ?>'><span>Set Access Rules</span></a></li>
                                <?php
                            break;
                        default:
                            echo "";
                            break;
                    };
                    ?>
                    
                </ul>
            </li>
            <li class=''><a href='#' ><span>Manage Visitor Records</span></a></li>
            <li class=''><a href='#' ><span>Active Directory</span></a></li>

            <li class=''><a href='#'><span>Reports</span></a></li>
        </ul>
    </div>
</div>