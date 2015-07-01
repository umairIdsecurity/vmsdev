<?php
$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-visitordetail-actions-cssmenu.js');
$session = new CHttpSession;
$workstationModel = Workstation::model()->findByPk($model->workstation);

$isWorkstationDelete = empty($workstationModel) ? 'true' : 'false';
?>
<div id='actionsCssMenu'>
    <ul>

        <li class='has-sub' id="closevisitLi" style="<?php
        if (in_array($model->visit_status, array(VisitStatus::ACTIVE, VisitStatus::EXPIRED)) && $session['role'] != Roles::ROLE_STAFFMEMBER) {
            echo "display:block;";
        } else {
            echo "display:none;";
        }
        ?>"><span class="close-visit">Close Visit</span>
            <ul>
                <li>
                    <table id="actionsVisitDetails">
                        <tr>
                            <td></td>
                            <td >

                                <div id="closeVisitDiv" class="form">
                                    <?php
                                    $closeVisitForm = $this->beginWidget('CActiveForm', array(
                                        'id' => 'close-visit-form',
                                        'htmlOptions' => array("name" => "close-visit-form", 'enctype' => 'multipart/form-data'),
                                        'enableAjaxValidation' => false,
                                    ));
                                    ?>

                                    <?php
                                    if (in_array($model->card_type, [CardType::VIC_CARD_SAMEDATE, CardType::VIC_CARD_MULTIDAY, CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_MANUAL])) {
                                        $this->renderPartial('closevisit-vic', array(
                                            'model' => $model,
                                            'visitorModel' => $visitorModel,
                                            'hostModel' => $hostModel,
                                            'reasonModel' => $reasonModel,
                                            'closeVisitForm' => $closeVisitForm,
                                            'asic' => $asic
                                        ));
                                    } else {
                                        $this->renderPartial('closevisit', array(
                                            'model' => $model,
                                            'visitorModel' => $visitorModel,
                                            'hostModel' => $hostModel,
                                            'reasonModel' => $reasonModel,
                                            'asic' => $asic
                                        ));
                                    }
                                    ?>

                                    <input type='submit' id="closeVisitSubmit" style="display: none;" />
                                    <input type="submit" id="closeVisitBtn" class="complete" value="Close Visit" />
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
        <?php if (in_array($model->visit_status, [VisitStatus::PREREGISTERED, VisitStatus::SAVED, VisitStatus::CLOSED, VisitStatus::AUTOCLOSED])) { ?>

            <li class='has-sub' id="activateLi"><span class="log-current">Log Visit</span>
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
                                        }else if ($("#Visit_card_type").val() == "9" && $("#pre_issued_card_no").val() == "" ) {
                                            $("#card_number_required").show();
                                        } else {
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
                                        if ($asic) {
                                            $this->renderPartial('activateavisit-vic', array(
                                                'model' => $model,
                                                'visitorModel' => $visitorModel,
                                                'hostModel' => $hostModel,
                                                'reasonModel' => $reasonModel,
                                                'asic' => $asic
                                            ));
                                        } else {
                                            $this->renderPartial('activateavisit', array(
                                                'model' => $model,
                                                'visitorModel' => $visitorModel,
                                                'hostModel' => $hostModel,
                                                'reasonModel' => $reasonModel,
                                            ));
                                        }
                                        ?>
                                    </div>

                                </td>
                            </tr>
                        </table>
                        <?php echo $logform->error($model, 'date_in'); ?>
                        <?php
                        if (in_array($model->visit_status, [VisitStatus::CLOSED])) :
                            ?>
                            <button type="button" id='registerNewVisit' class='greenBtn'>Activate Visit</button>
                        <?php elseif ($model->visit_status == VisitStatus::PREREGISTERED) : ?>
                            <button type="button" id='registerNewVisit' class='greenBtn'>Activate Visit</button>
                            <div style="display:inline;font-size:12px;">
                                <b>or </b>
                                <a id="cancelPreregisteredVisitButton" href="" class="cancelBtnVisitorDetail">Cancel</a>
                            </div>
                        <?php elseif ($model->visit_status == VisitStatus::AUTOCLOSED) : ?>
                            <?php
                            $disabled = '';
                            if (in_array($model->card_type, [CardType::VIC_CARD_EXTENDED, CardType::VIC_CARD_MULTIDAY]) && strtotime(date('d-m-Y')) == strtotime($model->finish_date)) {
                                $disabled = 'disabled';
                            }
                            ?>
                            <input type="submit" style="width: 235px !important;" <?php echo $disabled; ?> value="Preregister Visit" class="complete"/>
                        <?php else:
                            if ($model->card_type == CardType::MANUAL_VISITOR && isset($model->date_check_in) && strtotime($model->date_check_in) < strtotime(date("d-m-Y"))) :
                                ?>
                                <input type="submit" value="Back Date Visit" class="complete"/>
                            <?php else: ?>
                                <button type="button" id="registerNewVisit" class="greenBtn">Activate Visit</button>
                                <div style="display:inline;font-size:12px;">
                                <b>or </b>
                                <?php echo CHtml::link('Cancel', $this->createAbsoluteUrl('visit/view'), array('class' => 'cancelBtnVisitorDetail')); ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
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
    $(document).ready(function () {
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
            //$("#activateLi a").click();
        }

        $('#activate-a-visit-form').bind('submit', function () {
            $(this).find('#Visit_date_check_in').removeAttr('disabled');
        });

        $(document).on('click', '#closeVisitBtn', function(e) {
            e.preventDefault();
            var flag = true;
            var card_option = $('#Visit_card_option').val();
            $('#police_number_required').hide();
            $('#card_lost_declaration_required').hide();

            if (typeof card_option != 'undefined' && card_option == 'Lost/Stolen') {
                var card_lost_declaration_file = $('#Visit_card_lost_declaration_file').val();
                var police_report_no = $('#Visit_police_report_number').val();
                if (card_lost_declaration_file == '') {
                    $('#card_lost_declaration_required').show();
                    return false;
                }

                if (police_report_no == '') {
                    $('#police_number_required').show();
                    return false;
                }

                if (flag == true) {
                    $('#closeVisitSubmit').click();
                }
            } else {
                $('#closeVisitSubmit').click();
            }
        });

        $(document).on('click', '#registerNewVisit', function (e) {

            var imgsrc;
            $("#photoPreview").each(function() {
                imgsrc = this.src;
            });
            var profileImage = '<?php echo $visitorModel->photo;?>';
            var isDefault = imgsrc.search('companylogohere1.png');
            if( isDefault > 0 || profileImage == '' || !profileImage) {
                <?php if ($model->card_type > 4 ) : ?>
                    <?php if($model->card_type != CardType::VIC_CARD_SAMEDATE ) : ?>
                    $("#Visitor_photo_em").attr('style', 'margin-right:84px ; margin-bottom:0px; margin-top:0px ;');
                    $("#editImageBtn.editImageBtn").attr('style', 'margin-top:-5px !important; margin-right:84px ; margin-bottom:0px;');
                    $("#cropImageBtn.editImageBtn").attr('style', 'margin-top:-5px !important; margin-right:84px ; margin-bottom:0px;');
                    return;
                    <?php endif ?>
                <?php else : ?>
                    $("#Visitor_photo_em").attr('style', 'margin-bottom: -17px; margin-right: 0px; margin-top: 13px;');
                    $("#cropImageBtn.editImageBtn").attr('style', 'margin-bottom: 0; margin-right: 0 !important; margin-top: 0 !important;');
                    return;
                <?php endif ?>
            }

            e.preventDefault();
            $this = $(this);
            var flag = true;
            var $btnVic = $('#btnVicConfirm'),
                $btnASIC = $('#btnAsicConfirm');

            var isWorkstationDelete = "<?php echo $isWorkstationDelete; ?>";
            if (isWorkstationDelete == 'true') {
                alert('Workstation of this visit has been deleted, you can\'t activate it.');
                return false;
            }

            var vic_active_visit_checkboxs = $('.vic-active-verification');
            if (vic_active_visit_checkboxs.length == 0) {
                checkIfActiveVisitConflictsWithAnotherVisit("new");
                return false;
            }

            var is_vic_holder_checked = $('#VivHolderDecalarations').is(':checked'),
                is_asic_holder_checked = $('#AsicSponsorDecalarations').is(':checked');

            var declarations_checkboxs = $('.vic-active-declarations');
            var confirmed = isCheckboxsChecked(declarations_checkboxs);

            if (!confirmed && $('#registerNewVisit').html() !== 'Preregister Visit') {
                if (!$('#VivHolderDecalarations').is(':checked') && $('#AsicSponsorDecalarations').is(':checked')) {
                    $('#vicHolderModal').modal('show');
                    $btnVic.on('click', function(e) {
                        var vicChecked = vicCheck();
                        if (vicChecked) {
                            activeVisit();
                        } else {
                            alert('Please select all the declarations.');
                            return false;
                        }
                    });
                } else if (!$('#AsicSponsorDecalarations').is(':checked') && $('#VivHolderDecalarations').is(':checked')){
                    $('#asicSponsorModal').modal('show');
                    $btnASIC.on('click', function(e) {
                        var asicChecked = asicCheck();
                        if (asicChecked) {
                            confirmed = true;
                        } else {
                            alert('Please select all the declarations.');
                            return false;
                        }
                    });
                } else {
                    $('#vicHolderModal').modal('show');
                    $btnVic.on('click', function(e) {
                        var vicChecked = vicCheck();
                        if (vicChecked) {
                            $('#asicSponsorModal').modal('show');
                            $btnASIC.on('click', function(e) {
                                var asicChecked = asicCheck();
                                if (asicChecked) {
                                    confirmed = true;
                                } else {
                                    alert('Please select all the declarations.');
                                    return false;
                                }
                            });
                        } else {
                            alert('Please select all the declarations.');
                            return false;
                        }
                    });
                }
            } else {
                confirmed = true;
            }

            if (confirmed == true) {
                flag = isCheckboxsChecked(vic_active_visit_checkboxs);
                if (flag == true) {
                    var pre_issued_card_no = $("#pre_issued_card_no").val();
                    if (typeof pre_issued_card_no != "undefined") {
                        if (pre_issued_card_no == "") {
                            $("#card_number_required").show();
                            return false;
                        } else {
                            $("#card_number_required").hide();
                        }
                    }
                    activeVisit();
                } else {
                    alert('Please agree VIC verification before active visit.');
                    addWarningLabel(vic_active_visit_checkboxs);
                }
            }

        });

        function isCheckboxsChecked(checkboxs) {
            var flag = true;
            $.each(checkboxs, function(i, checkbox) {
                $(checkbox).next('a').removeClass('label label-warning');
                if (!checkbox.checked) {
                    flag = false;
                    return;
                }
            });
            return flag;
        }

        function addWarningLabel(checkboxs) {
            $.each(checkboxs, function(i, checkbox) {
                if (!checkbox.checked) {
                    checkbox.focus();
                    $(checkbox).next('a').addClass('label label-warning');
                    return false;
                }
            });
        }

        function activeVisit() {
            var status = "<?php echo $model->visit_status; ?>";
            if (status == "<?php echo VisitStatus::SAVED; ?>" || status == "<?php echo VisitStatus::PREREGISTERED; ?>") {
                checkIfActiveVisitConflictsWithAnotherVisit();
            } else {
                checkIfActiveVisitConflictsWithAnotherVisit('new');
            }
        }

        $('#cancelActiveVisitButton').on('click', function (e) {
            e.preventDefault();
            sendCancelVisit();
        });

        $('#cancelPreregisteredVisitButton').on('click', function (e) {
            e.preventDefault();
            sendCancelVisit();
        });

        $(document).on('click', '#preregisterNewVisit', function (e) {
            e.preventDefault();
            checkIfActiveVisitConflictsWithAnotherVisit();
        });


        <?php
        if ($model->time_check_out && $model->card_type == CardType::VIC_CARD_24HOURS && $model->visit_status == VisitStatus::ACTIVE) {
            $ctout = explode(':', $model->time_check_out);
            ?>
        $(".visit_time_in_hours").val(<?= $ctout[0] ?>);
        $(".visit_time_in_minutes").val(<?= $ctout[1] ?>);
        <?php
    } else {
        ?>
        display_ct();
        <?php } ?>


        if ('<?php echo $model->card_type; ?>' == 1) {
            $('.ui-datepicker-trigger[title="Select Proposed Check Out Date"]').hide();
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
            success: function (r) {
                $.each(r.data, function (index, value) {
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
            success: function (r) {
                $.each(r.data, function (index, value) {
                    if (value.isConflicting == 1) {
                        alert("Visit cannot be activated. Please close previous active visit.");
                        $("#Visit_date_check_in").attr("disabled", true);
                    } else if (visitType == 'new') {
                        $("#dateoutDiv #Visit_date_out").attr("disabled", false);
                        duplicateVisit("activate-a-visit-form");
                    }
                    else {
                        if ($.trim($('#pre_issued_card_no').val()) != "") {
                            $('#CardGenerated_enter_card_number').val($('#pre_issued_card_no').val());
                        }
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
    <input type="text" id="CardGenerated_enter_card_number" name="CardGenerated[enter_card_number]" value=""/>
    <?php
    $tenant = User::model()->findByPk($model->tenant);
    $code = '';
    if ($tenant) {
        if ($tenant->company != '') {
            $company = Company::model()->findByPk($tenant->company);
            if ($company) {
                $card_count = $company->card_count ? ($company->card_count + 1) : 1;

                while (strlen($card_count) < 6) {
                    $card_count = '0' . $card_count;
                }
                $code = $company->code . ($card_count);
            }
        }
    }
    ?>
    <input type="text" id="CardGenerated_card_number" name="CardGenerated[card_number]" value="<?php echo $code; ?>">

    <input type="text" id="CardGenerated_print_count" name="CardGenerated[print_count]" value="">
    <input type="submit" value="Create" name="yt0" id="submitCardForm">
    <?php $this->endWidget(); ?>

</div>