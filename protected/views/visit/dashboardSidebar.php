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

<div id="sidebar2">
    <div class="sidebarTitle" style="">Main Menu</div><br><div id='cssmenu' class="dashboardMenu">
        <ul>
            <li class=''>
                <a href='<?php echo Yii::app()->createUrl('dashboard/viewmyvisitors'); ?>'>
                    <span class="icons pre-visits">Preregistered Visitors</span>
                </a>
            </li>
            <li class=''><a href='<?php echo Yii::app()->createUrl('dashboard/addHost'); ?>' ><span class="addhost">Add Host</span></a></li>

            <li class=''><a href='<?php echo Yii::app()->createUrl('visitor/create'); ?>'><span class="addvisitor">Add Visitor Record</span></a></li>
            <li class=''><a href='<?php echo Yii::app()->createUrl('visit/view'); ?>'><span class="icons findrecord">Find Record</span></a></li>
            <li class=''><a href='#'><span>Evacutation Report</span></a></li>
        </ul>
    </div>
</div>
