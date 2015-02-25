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
            <li class=''><a href='<?php echo Yii::app()->createUrl('visitor/create&action=register'); ?>'><span >Register a Visit</span></a></li>
            <li class=''>

                <a href='<?php echo Yii::app()->createUrl('visitor/create&action=preregister'); ?>'>
                    <span >Preregister a Visit</span>
                </a>
            </li>
            <li><a href='<?php echo Yii::app()->createUrl('visitor/addvisitor'); ?>' ><span>Add Visitor Profile</span></a></li>
       
            <li class=''><?php
                echo CHtml::ajaxLink("Add Host", CController::createUrl('dashboard/addHost'), array(
                    'update' => '#content', 
                        ), array(
                    'class' => 'addhost',
                ));
                ?>
            </li>

            <li class=''><a href='<?php echo Yii::app()->createUrl('visit/view'); ?>'><span >Search Visits</span></a></li>
            <li class=''><a href='<?php echo Yii::app()->createUrl('visit/evacuationReport'); ?>'><span>Evacuation Report</span></a></li>
        </ul>
    </div>
</div>
<script>

    $(document).ready(function() {

        $(".addhost",".addvisitor").click(function(e) {
            e.preventDefault();
        });
    });


</script>
