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
           <!-- <li class=''><a href='<?php echo Yii::app()->createUrl('dashboard/addHost'); ?>' id="addhostSidebar"><span class="addhost">Add Host</span></a></li>!-->
            <li class=''><?php
                echo CHtml::ajaxLink("Add Host", CController::createUrl('dashboard/addHost'), array(
                    'update' => '#content',
                        ), array(
                    'class' => 'addhost',
                ));
                ?>
            </li>
            <li class=''><a href='<?php echo Yii::app()->createUrl('visitor/create'); ?>' id="addvisitorSidebar"><span>Add Visitor Record</span></a></li>
            <li class=''><a href='<?php echo Yii::app()->createUrl('visit/view'); ?>' id="findrecordSidebar"><span>Find Record</span></a></li>
            <li class=''><a href='<?php echo Yii::app()->createUrl('visit/evacuationReport'); ?>' id="evacuationreportSidebar"><span>Evacuation Report</span></a></li>
        </ul>
    </div>
</div>


<script>

    $(document).ready(function() {

        $(".addhost").click(function(e) {
            e.preventDefault();
            //  var contentPanelId = jQuery(this).attr("id");
            //  var url ;

            // var url = jQuery(this).attr("href");
            //  $("#content").html('<iframe id="contentIframe" onLoad="autoResize();" width="100%" height="100%" frameborder="0" scrolling="no" src="index.php?r=dashboard/content&page='+contentPanelId+'"></iframe>');
            // window.location ='index.php?r=dashboard/content&page='+contentPanelId;
        });
    });

    function autoResize() {
        var newheight;

        if (document.getElementById) {
            newheight = document.getElementById('contentIframe').contentWindow.document.body.scrollHeight;
        }
        document.getElementById('contentIframe').height = (newheight - 60) + "px";
    }

</script>
