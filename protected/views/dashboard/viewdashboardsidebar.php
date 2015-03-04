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
            <li class=''><a href='<?php echo Yii::app()->createUrl('visitor/create&action=register'); ?>' id="addvisitorSidebar" class="sidemenu-icon log-current"><span>Log Visit</span></a></li>
            <li class=''>
                <a href='<?php echo Yii::app()->createUrl('visitor/create&action=preregister'); ?>' class="sidemenu-icon pre-visits">
                    <span >Preregister Visit</span>
                </a>
            </li>
            <li class=''><?php
                echo CHtml::ajaxLink("Add Host", CController::createUrl('dashboard/addHost'), array(
                    'update' => '#content',
                        ), array(
                    'class' => 'sidemenu-icon addhost',
                ));
                ?>
            </li>
            <li><a href='<?php echo Yii::app()->createUrl('visitor/addvisitor'); ?>' class="submenu-icon addvisitorprofile"><span>Add Visitor Profile</span></a></li>
                        
            

            <li class=''><a href='<?php echo Yii::app()->createUrl('visit/view'); ?>' id="findrecordSidebar" class="submenu-icon findrecord"><span>Search Visits</span></a></li>
            <li class=''><a href='<?php echo Yii::app()->createUrl('visit/evacuationReport&p=d'); ?>' id="evacuationreportSidebar" class="sidemenu-icon evacuationreport"><span>Evacuation Report</span></a></li>
        </ul>
    </div>
</div>


