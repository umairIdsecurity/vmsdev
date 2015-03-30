<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-visitordetail-actions-cssmenu.js');
$session = new CHttpSession;
?>
<div id='actionsCssMenu'>
    <ul class="visitStatusLi">
        <li>
            <a style="text-decoration: none; ">Status: <span style="color:#<?php
                if ($model->visit_status == VisitStatus::CLOSED) {
                    echo "ff0000";
                } else if ($model->visit_status == VisitStatus::ACTIVE) {
                    echo "9BD62C";
                } else if ($model->visit_status == VisitStatus::PREREGISTERED) {
                    echo "2F96B4";
                } else if ($model->visit_status == VisitStatus::SAVED) {
                    echo "637280";
                }
                ?> !important; font-weight:bold"><?php echo VisitStatus::$VISIT_STATUS_LIST[$model->visit_status]; ?></span></a>

        </li>
    </ul>

    <input type="text" style="display:none;" value="<?php echo $model->visit_status; ?>" id="visitStatusActions"/>

    <ul>

        <li class='has-sub' id="closevisitLi" style="<?php
        if ($model->visit_status == VisitStatus::ACTIVE && $session['role'] != Roles::ROLE_STAFFMEMBER) {
            echo "display:block;";
        } else {
            echo "display:none;";
        }
        ?>"><a href="#"><span class="close-visit">Close Visit</span></a>
            <ul>
                <li>
                    <table id="actionsVisitDetails" style="margin-top:15px;">
                        <tr>
                            <td></td>
                            <td >

                                <div id="closeVisitDiv">
                                    <?php
                                    $closeVisitForm = $this->beginWidget('CActiveForm', array(
                                        'id' => 'close-visit-form',
                                        'htmlOptions' => array("name" => "close-visit-form"),
                                        'enableAjaxValidation' => false,
                                        'enableClientValidation' => true,
                                        'clientOptions' => array(
                                            'validateOnSubmit' => true,
                                            'afterValidate' => 'js:function(form, data, hasError){
                                                if (!hasError){
                                                    sendCloseVisit("close-visit-form");
                                                }
                                                }'
                                        ),
                                    ));
                                    ?>
                                    <table class="detailsTable" style="font-size:12px;" id="logvisitTable">
                                        <tr>
                                            <td>Check Out Date</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input name="Visit[visit_status]" id="Visit_visit_status" type="text" value="<?php echo VisitStatus::CLOSED; ?>" style="display:none;">
                                                <input name="Visit[time_check_out]" id="Visit_time_check_out" class="timeout" type="text" style="display:none;">
                                                <input type="text" value="<?php echo date("d-m-Y"); ?>" id='Visit_date_check_out' name="Visit[date_check_out]" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Check Out Time</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="time visit_time_in_hours" id='Visit_time_check_out_hours' disabled style="width:70px;">
                                                    <?php for ($i = 1; $i <= 24; $i++): ?>
                                                        <option value="<?= $i; ?>"><?= date("H", strtotime("$i:00")); ?></option>
                                                    <?php endfor; ?>
                                                </select> :
                                                <select class='time visit_time_in_minutes'  id='Visit_time_check_out_minutes' disabled style="width:70px;">
                                                    <?php for ($i = 1; $i <= 60; $i++): ?>
                                                        <option value="<?= $i; ?>"><?php
                                                            if ($i > 0 && $i < 10) {
                                                                echo '0' . $i;
                                                            } else {
                                                                echo $i;
                                                            };
                                                            ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php echo $closeVisitForm->error($model, 'date_in'); ?>
                                    <input type='submit' value='Close' class="complete" id="closeVisitBtn" style="display:none;"/>
                                    <button  class="complete greenBtn" id="closeVisitBtnDummy" style="width:93px !important"/>Close Visit</button>
                                    <div style="display:inline;font-size:12px;"><b>or</b><a id="cancelActiveVisitButton" href="" class="cancelBtnVisitorDetail">Cancel</a></div>
                                    <!-- <button class="neutral greenBtn" id="cancelActiveVisitButton">Cancel</button>-->
                                    <?php $this->endWidget(); ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </li>
            </ul>

        </li>
        <?php if (($model->visit_status == VisitStatus::PREREGISTERED || $model->visit_status == VisitStatus::SAVED || $model->visit_status == VisitStatus::CLOSED)) {
            ?>
            <li class='has-sub' id="preregisterLi"><a href="#"><span class="pre-visits">Preregister Visit</span></a>
                <ul>
                    <li>

                        <table id="actionsVisitDetails">
                            <tr>
                                <td></td>
                                <td >

                                    <div id="logVisitDiv">
                                        <?php
                                        $this->renderPartial('preregisteravisit', array('model' => $model,
                                            'visitorModel' => $visitorModel,
                                            'hostModel' => $hostModel,
                                            'reasonModel' => $reasonModel,
                                        ));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </li>
                </ul>
            </li>
            <li class='has-sub' id="activateLi"><a href="#"><span class="log-current">Log Visit</span></a>
                <ul>
                    <li>
                        <?php
                        $logform = $this->beginWidget('CActiveForm', array(
                            'id' => 'activate-a-visit-form',
                            'htmlOptions' => array("name" => "activate-a-visit-form"),
                            'enableAjaxValidation' => false,
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                                'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                if($("#Visitor_photo").val() == "" && $("#Visit_card_type").val() == "2" ){
                                    alert("Please upload a photo.");
                                }else 
                                {          
                                   checkIfActiveVisitConflictsWithAnotherVisit();
                                } 
                                }
                                }'
                            ),
                        ));
                        ?>
                        <table id="actionsVisitDetails">
                            <tr>
                                <td></td>
                                <td >

                                    <div id="logVisitDiv">
                                        <?php
                                        $this->renderPartial('activateavisit', array('model' => $model,
                                            'visitorModel' => $visitorModel,
                                            'hostModel' => $hostModel,
                                            'reasonModel' => $reasonModel,
                                        ));
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <?php echo $logform->error($model, 'date_in'); ?>
                        <?php if ($model->visit_status == VisitStatus::CLOSED) {
                            ?>
                            <button id='registerNewVisit' class='greenBtn'>Activate</button> 
                        <?php } else { ?>
                            <input type = 'submit' value = 'Activate' class = "complete"/>
                        <?php } ?>
                        <?php $this->endWidget();
                        ?>

                    </li>
                </ul>
            </li>

        <?php } ?>
    </ul>
</div>
<input type="hidden" value="<?php echo $session['previousVisitAction']; ?>" id="previousVisitAction"/>
<input type="hidden" value="<?php echo $model->visit_status; ?>" id="visitStatus"/>
<script>
    $(document).ready(function() {
        if ($("#visitStatus").val() == 5) {

            if ($("#previousVisitAction").val() == 'Preregister') {
                $("#preregisterLi ul").show();
                $("#activateLi ul").hide();
            } else {
                $("#activateLi ul").show();
                $("#preregisterLi ul").hide();
            }
        } else {
            $("#logvisitLi a").click();

            if ($("#visitStatusActions").val() != 2) {
                $("#preregisterLi a").click();
            }
            $("#activateLi a").click();
        }

        $('#activate-a-visit-form').bind('submit', function() {
            $(this).find('#Visit_date_check_in').removeAttr('disabled');
        });

        $('#registerNewVisit').on('click', function(e) {
            e.preventDefault();
            checkIfActiveVisitConflictsWithAnotherVisit("new");
        });

        $('#closeVisitBtnDummy').on('click', function(e) {
            e.preventDefault();
            $("#closeVisitBtn").click();
        });

        $('#cancelActiveVisitButton').on('click', function(e) {
            e.preventDefault();
            sendCancelVisit();
        });

        $('#preregisterNewVisit').on('click', function(e) {
            e.preventDefault();
            if ($("#Visit_date_in").val() == '') {
                $("#preregisterdateinError").show();
            } else {
                checkIfPreregisteredVisitConflictsWithAnotherVisit("new");
            }
        });

        display_ct();
        if ('<?php echo $model->card_type; ?>' == 1) {
            $('.ui-datepicker-trigger[title="Select Proposed Date Out"]').hide();
        }


    });

    function display_c() {
        var refresh = 1000; // Refresh rate in milli seconds
        mytime = setTimeout('display_ct()', refresh)
    }

    function display_ct() {

        var x = new Date();
        var currenttime = x.getHours() + ":" + x.getMinutes() + ":" + x.getSeconds();

        $(".visit_time_in_hours").val(x.getHours());
        $(".visit_time_in_minutes").val(x.getMinutes());
        $("#Visit_time_out").val(currenttime);
        $("#Visit_time_check_out").val(currenttime);
        tt = display_c();
    }

    function checkIfPreregisteredVisitConflictsWithAnotherVisit(visitType) {
        visitType = (typeof visitType === "undefined") ? "defaultValue" : visitType;
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visit/isDateConflictingWithAnotherVisit&date_in='); ?>' + $("#Visit_date_in").val() + '&date_out=' + $("#Visit_date_out").val() + '&visitorId=<?php echo $model->visitor; ?>&visitStatus=<?php echo VisitStatus::PREREGISTERED; ?>',
            dataType: 'json',
            success: function(r) {
                $.each(r.data, function(index, value) {
                    if (value.isConflicting == 1) {
                        alert("A visit has already been preregistered in the same day.");
                    } else if (visitType == 'new') {
                        $("#dateoutDiv #Visit_date_out").attr("disabled", false);
                        $("#Visit_date_out").attr("disabled", false);
                        $("#Visit_date_in").attr("disabled", false);
                        duplicateVisit("update-log-visit-form");
                        $("#Visit_date_out").attr("disabled", true);
                        $("#Visit_date_in").attr("disabled", true);
                    }
                    else {
                        $("#Visit_date_out").attr("disabled", false);
                        $("#Visit_date_in").attr("disabled", false);
                        sendVisitForm("update-log-visit-form");
                        $("#Visit_date_out").attr("disabled", true);
                        $("#Visit_date_in").attr("disabled", true);
                        $("#dateoutDiv #Visit_date_out").val($("#Visit_date_out").val());
                        $("#dateoutDiv").hide();
                    }
                });
            }
        });
    }

    function checkIfActiveVisitConflictsWithAnotherVisit(visitType) {
        visitType = (typeof visitType === "undefined") ? "defaultValue" : visitType;
        $("#Visit_date_check_in").attr("disabled", false);
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visit/isDateConflictingWithAnotherVisit&date_in='); ?>' + $("#Visit_date_check_in").val() + '&date_out=' + $("#Visit_date_out").val() + '&visitorId=<?php echo $model->visitor; ?>&visitStatus=<?php echo VisitStatus::ACTIVE; ?>',
            dataType: 'json',
            success: function(r) {
                $.each(r.data, function(index, value) {
                    if (value.isConflicting == 1) {
                        alert("Visit cannot be activated. Please close previous active visit.");
                        $("#Visit_date_check_in").attr("disabled", true);
                    } else if (visitType == 'new') {
                        $("#dateoutDiv #Visit_date_out").attr("disabled", false);

                        duplicateVisit("activate-a-visit-form");
                    }
                    else {

                        $("#dateoutDiv #Visit_date_out").attr("disabled", false);
                        sendActivateVisitForm("activate-a-visit-form");
                    }
                });
            }
        });

    }
</script>

<div style='display:none;'>
    <?php
    $cancelForm = $this->beginWidget('CActiveForm', array(
        'id' => 'cancel-visit-form',
        'htmlOptions' => array("name" => "cancel-visit-form"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                    
                                    sendCancelVisit(); 
                                    
                                }
                                }'
        ),
    ));
    ?>
    <input type="text" name="Visit[visit_status]" id='Visit_visit_status' value='<?php echo VisitStatus::SAVED; ?>'/>
    <input type="text" name="Visit[date_in]" id='Visit_date_in' value=''/>
    <input type="text" name="Visit[time_in]" id='Visit_time_in' value=''/>
    <input type="text" name="Visit[date_out]" id='Visit_date_out' value=''/>
    <input type="text" name="Visit[time_out]" id='Visit_time_out' value=''/>
    <input type="text" name="Visit[date_check_in]" id='Visit_date_check_in' value=''/>
    <input type="text" name="Visit[time_check_in]" id='Visit_time_check_in' value=''/>
    <input type="text" name="Visit[date_check_out]" id='Visit_date_check_out' value=''/>
    <input type="text" name="Visit[time_check_out]" id='Visit_time_check_out' value=''/>
    <?php echo "<br>" . $cancelForm->error($model, 'visit_status'); ?>
    <input type='submit' value='Update' class='submitBtn complete' id='cancelFormBtn'>

    <?php $this->endWidget(); ?>

    <?php
    $cardForm = $this->beginWidget('CActiveForm', array(
        'id' => 'update-card-form',
        //'action' => Yii::app()->createUrl('/cardGenerated/create&id=' . $model->visitor . '&visitId='.$model->id.''),
        'action' => Yii::app()->createUrl('/cardGenerated/create&visitId=' . $model->id),
        'htmlOptions' => array("name" => "update-card-form"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form, data, hasError){
                                if (!hasError){
                                }
                                }'
        ),
    ));
    ?>
    <input type="text" id="CardGenerated_visitor_id" name="CardGenerated[visitor_id]" value="<?php echo $model->visitor; ?>">
    <input type="text" id="CardGenerated_created_by" name="CardGenerated[created_by]" value="<?php echo Yii::app()->user->id; ?>">
    <input type="text" id="CardGenerated_tenant" name="CardGenerated[tenant]" value="<?php echo $model->tenant; ?>">
    <input type="text" id="CardGenerated_tenant_agent" name="CardGenerated[tenant_agent]" value="<?php echo $model->tenant_agent;
    ?>">
    <input type="text" id="CardGenerated_card_number" name="CardGenerated[card_number]" value="<?php
    $tenant = User::model()->findByPk($model->tenant);
    if (Company::model()->findByPk($tenant->company)->card_count != '') {
        $card_count = (Company::model()->findByPk($tenant->company)->card_count)+1;
    } else {
        $card_count = 1;
    }

    if ($tenant->company != '') {
        $inc = 6 - (strlen(($card_count)));
        $int_code = '';
        for ($x = 1; $x <= $inc; $x++) {

            $int_code .= "0";
        }
    }
    echo Company::model()->findByPk($tenant->company)->code . $int_code . ($card_count);
    ?>">

    <input type="text" id="CardGenerated_print_count" name="CardGenerated[print_count]" value="">
    <input type="submit" value="Create" name="yt0" id="submitCardForm">
<?php $this->endWidget(); ?>

</div>