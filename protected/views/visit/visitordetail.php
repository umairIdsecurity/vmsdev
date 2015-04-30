<?php
/* @var $this VisitorController */
/* @var $model Visitor */
$session = new CHttpSession;
?>
<table id="visitorDetailDiv">
    <tr class="theadVisitorDetail">
        <td style="width:35% !important;">Visitor Detail</td>
        <td style="width:35%!important;">Visitor Information</td>
        <td>Actions</td>
    </tr>
    <tr>
        <td style="padding:5px;text-align: center;">
            <?php
            $this->renderPartial('visitor-detail-card', array('model' => $model,
                'visitorModel' => $visitorModel,
                'hostModel' => $hostModel,
                'patientModel' => $patientModel,
                'cardTypeModel' => $cardTypeModel,
            ));
            ?>

        </td>
        <td>
            <?php
            $this->renderPartial('visitordetail-visitorInformation', array('model' => $model,
                'visitorModel' => $visitorModel,
                'hostModel' => $hostModel,
                'reasonModel' => $reasonModel,
                'patientModel' => $patientModel,
                'newPatient' => $newPatient,
                'newHost' => $newHost,
            ));
            ?>

        </td>
        <td>

            <?php
            $this->renderPartial('visitordetail-actions', array('model' => $model,
                'visitorModel' => $visitorModel,
                'hostModel' => $hostModel,
                'reasonModel' => $reasonModel,
                'patientModel' => $patientModel,
            ));
            ?>
        </td>

    </tr>
</table>
<?php
$this->renderPartial('visithistory', array('model' => $model,
    'visitorModel' => $visitorModel,
    'hostModel' => $hostModel,
    'reasonModel' => $reasonModel,
));
?>
<input type="text" style="display:none;" id="createUrlForEmailUnique" value="<?php echo Yii::app()->createUrl('user/checkEmailIfUnique&id='); ?>"/>
<input type="text" style="display:none;" id="Visitor_tenant" value="<?php echo $visitorModel->tenant; ?>"/>

<input type="text" id="currentRoleOfLoggedInUser" value="<?php echo $session['role']; ?>">
<input type="text" id="currentCompanyOfLoggedInUser" value="<?php echo User::model()->getCompany($session['id']); ?>">
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            cache: false,
            isLocal: false

        });
    });
    function ifSelectedIsOtherShowAddReasonDiv(reason) {
        if (reason.value == 'Other') {
            $("#addreasonTable").show();

        } else {
            $("#addreasonTable").hide();
        }
    }

    function checkEmailIfUnique() {

        var email = $("#Visitor_email").val();
        if (email == '<?php echo $visitorModel->email ?>') {
            sendVisitorForm();
        } else {

            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/checkEmailIfUnique&id='); ?>' + email.trim(),
                dataType: 'json',
                data: email,
                success: function(r) {
                    $.each(r.data, function(index, value) {
                        if (value.isTaken == 1) {
                            $(".errorMessageEmail").show();
                            $("#emailIsUnique").val("0");
                        } else {
                            $(".errorMessageEmail").hide();
                            $("#emailIsUnique").val("1");
                            sendVisitorForm();
                        }
                    });

                }
            });
        }
    }

    function checkHostEmailIfUnique() {

        var email = $(".update_user_email").val();
        if (email == '<?php echo $hostModel->email ?>') {
            sendHostForm();
        } else {

            var tenant;
            if ($("#currentRoleOfLoggedInUser").val() == 5) { //check if superadmin
                tenant = $("#User_tenant").val();
            } else {
                tenant = '<?php echo $session['tenant']; ?>';
            }
            var url = $("#createUrlForEmailUnique").val() + email.trim() + '&tenant=' + tenant;
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: email,
                success: function(r) {
                    $.each(r.data, function(index, value) {
                        if (value.isTaken == 1) {
                            $("#hostEmailIsUnique").val("0");
                            $(".errorMessageEmail1").show();
                            $("#User_email_em_1a").show();
                        } else {
                            $(".errorMessageEmail1").hide();
                            $("#User_email_em_1a").hide();
                            $("#hostEmailIsUnique").val("1");
                            sendHostForm();
                        }
                    });

                }
            });
        }
    }

    function checkReasonIfUnique() {

        var visitReason = $("#VisitReason_reason").val();
        if (visitReason == '') {
            $("#visitReasonErrorMessage").show();
            $("#visitReasonErrorMessage").html("Please select a reason");
        } else {

            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitReason/checkReasonIfUnique&id='); ?>' + visitReason.trim(),
                dataType: 'json',
                data: visitReason,
                crossDomain: false,
                cache: false,
                success: function(r) {
                    $.each(r.data, function(index, value) {
                        if (value.isTaken == 1) {
                            $("#visitReasonErrorMessage").show();
                            $("#visitReasonErrorMessage").html("Reason is already registered.");
                        } else {
                            $("#visitReasonErrorMessage").hide();
                            sendReasonForm();
                        }
                    });
                }
            });
        }
    }

    function sendVisitorForm() {

        var form = $("#update-visitor-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("/visitor/update&id=" . $visitorModel->id . "&view=1")); ?>",
            data: form,
            success: function(data) {
                $(".success-update-contact-details").show();
            },
        });

    }

    function sendReasonForm() {
        var reasonForm = $("#add-reason-form").serialize();

        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visitReason/create&register=1")); ?>",
            data: reasonForm,
            success: function(data) {
                addReasonInDropdown();

            },
        });

    }

    function addReasonInDropdown() {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitReason/GetAllReason'); ?>',
            dataType: 'json',
            success: function(r) {
                $('#Visit_reason option[value!="Other"]').remove();

                $.each(r.data, function(index, value) {
                    $('#Visit_reason').append('<option value="' + value.id + '">' + value.name + '</option>');
                    var textToFind = $("#VisitReason_reason").val();

                    textToFind = textToFind.toLowerCase().replace(/^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g, function(letter) {
                        return letter.toUpperCase();
                    });
                    var dd = document.getElementById('Visit_reason');
                    for (var i = 0; i < dd.options.length; i++) {
                        if (dd.options[i].text === textToFind) {
                            dd.selectedIndex = i;
                            break;
                        }
                    }
                    $("#addreasonTable").hide();
                    $(".success-add-reason").show();
                });


            }
        });
    }

    function sendHostForm() {

        var hostform = $("#update-host-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("user/update&id=" . $hostModel->id)); ?>",
            data: hostform,
            success: function(data) {
            },
        });
    }

    function sendUpdateReasonForm() {

        var reasonForm = $("#update-reason-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visit/update&id=" . $model->id)); ?>",
            data: reasonForm,
            success: function(data) {
                $(".success-update-reason").show();
                $(".success-add-reason").hide();
            },
        });
    }

    function sendVisitForm(formId) {
        var visitForm = $("#" + formId).serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visit/update&id=" . $model->id)); ?>",
            data: visitForm,
            success: function(data) {
                if (formId == 'update-host-visit-form') {
                    $(".success-update-host-details").show();
                } else if (formId == 'update-log-visit-form') {
                    $(".success-update-preregister").show();
                    if ($("#currentRoleOfLoggedInUser").val() == 5 ) {
                        window.location = 'index.php?r=dashboard';
                    } else if ($("#currentRoleOfLoggedInUser").val() == 1 || $("#currentRoleOfLoggedInUser").val() == 6 || $("#currentRoleOfLoggedInUser").val() == 8 || $("#currentRoleOfLoggedInUser").val() == 7) {
                        window.location = 'index.php?r=dashboard/admindashboard';
                    } else if ($("#currentRoleOfLoggedInUser").val() == 9) {
                        window.location = 'index.php?r=dashboard/viewmyvisitors';
                    }

                }
                else
                {
                    $(".success-update-visitor-type").show();
                    window.location = 'index.php?r=visit/detail&id=<?php echo $_GET['id']; ?>';
                }
            },
        });
    }

    function sendPatientForm() {
        var patientForm = $("#update-patient-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("patient/update&id=" . $model->patient)); ?>",
            data: patientForm,
            success: function(data) {
                $(".success-update-patient").show();
            },
        });
    }

    function sendNewPatientForm() {
        var patientForm = $("#register-host-patient-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("patient/create")); ?>",
            data: patientForm,
            success: function(data) {
                getLastPatientId();
            },
        });
    }

    function getLastPatientId() {
        var id = $("#Patient_name").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('patient/GetIdOfUser&id='); ?>' + id.trim(),
            dataType: 'json',
            data: id,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#Visit_patient").val(value.id);
                });
                $(".success-add-patient").show();
                sendVisitForm("update-visit-form");
            }
        });
    }

    function checkNewHostEmailIfUnique() {
        var email = $(".New_user_email").val();
        var tenant;
        if ($("#currentRoleOfLoggedInUser").val() == 5) { //check if superadmin
            tenant = $("#User_tenant").val();
        } else {
            tenant = '<?php echo $session['tenant']; ?>';
        }
        var url = $("#createUrlForEmailUnique").val() + email.trim() + '&tenant=' + tenant;
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: email,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    if (value.isTaken == 1) {
                        $("#newHostEmailIsUnique").val("0");
                        $(".errorMessageEmail2").show();
                    } else {
                        $(".errorMessageEmail2").hide();
                        $("#newHostEmailIsUnique").val("1");
                        sendNewHostForm();
                    }
                });

            }
        });

    }

    function sendNewHostForm() {
        var hostform = $("#register-newhost-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("user/create&view=1")); ?>",
            data: hostform,
            success: function(data) {
                getLastHostId();
            },
        });
    }

    function getLastHostId() {
        var id = $(".New_user_email").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/GetIdOfUser&id='); ?>' + id.trim(),
            dataType: 'json',
            data: id,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#Visit_host").val(value.id);
                });
                $(".success-add-host").show();
                sendVisitForm("update-visit-form");
            }
        });
    }

    function sendActivateVisitForm(formId) {
        var visitForm = $("#" + formId).serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visit/update&id=" . $model->id)); ?>",
            data: visitForm,
            success: function(data) {
                $("#preregisterLi").hide();
                $("#activateLi").hide();
                $("#closevisitLi").show();
                $("#printCardBtn").attr('disabled', false);
                $("#printCardBtn").show();
                $("#printCardBtn").removeClass("disabledButton");
                $(".visitStatusLi li a span").html("Active");
                $(".visitStatusLi li a span").css('color', '#9BD62C !important');

                sendCardForm();
                
                //alert("Visit is now activated. You can now print the visitor badge.");
                //window.location = "<?php //echo CHtml::normalizeUrl(array("visit/detail&id=" . $model->id)); ?>";
            },
        });
    }

    function sendCardForm(visitId) {
        var cardForm = $("#update-card-form").serialize();
        visitId = (typeof visitId === "undefined") ? "defaultValue" : visitId;
        if (visitId != "defaultValue") {
            var id = visitId;
        } else {
            var id = '<?php echo $model->id; ?>';
        }
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("cardGenerated/create&visitId=")) ?>" + id,
            data: cardForm,
            success: function(data) {
                //if (visitId != "defaultValue") {
                    window.location = "index.php?r=visit/detail&id=" + id;
                //}
            }
        });
    }

    function sendCloseVisit(formId) {
        var visitForm = $("#" + formId).serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visit/update&id=" . $model->id)); ?>",
            data: visitForm,
            success: function(data) {
                window.location = "index.php?r=visit/detail&id=<?php echo $_GET['id']; ?>";
            },
        });
    }

    function sendCancelVisit() {
        var visitForm = $("#cancel-visit-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visit/update&id=" . $model->id)); ?>",
            data: visitForm,
            success: function(data) {
                window.location = "index.php?r=visit/detail&id=<?php echo $_GET['id']; ?>";
            },
        });
    }

    function duplicateVisit(formId) {
        var visitForm = $("#" + formId).serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visit/duplicateVisit&id=" . $model->id)); ?>",
            data: visitForm,
            success: function(data) {
                sendCardForm(data);
                
              //  window.location = "index.php?r=visit/detail&id=" + data;
                //  alert(data);
            },
        });
    }

</script>
