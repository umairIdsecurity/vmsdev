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
            <table id="actionsVisitDetails">
                <tr>
                    <td></td>
                    <td style="padding:25px 10px 10px 20px;">
                        <span class="icons log-current actionsLabel">Log Visit</span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:5px 10px 10px 20px;">
                        <span class="icons pre-visits actionsLabel">Preregister a Visit</span>
                    </td>
                </tr>
            </table>
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

<input type="text" id="currentRoleOfLoggedInUser" value="<?php echo $session['role']; ?>">
<input type="text" id="currentCompanyOfLoggedInUser" value="<?php echo User::model()->getCompany($session['id']); ?>">
<script>
    $(document).ready(function() {

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
                url: '<?php echo Yii::app()->createUrl('visitor/checkEmailIfUnique&id='); ?>' + email,
                dataType: 'json',
                data: email,
                success: function(r) {

                    if (r == 1) {
                        $(".errorMessageEmail").show();
                        $("#emailIsUnique").val("0");
                    } else {
                        $(".errorMessageEmail").hide();
                        $("#emailIsUnique").val("1");
                        sendVisitorForm();
                    }
                }
            });
        }
    }

    function checkHostEmailIfUnique() {
        var email = $(".update_user_email").val();
        if (email == '<?php echo $hostModel->email ?>') {
            sendHostForm();
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('user/checkEmailIfUnique&id='); ?>' + email.trim(),
                dataType: 'json',
                data: email,
                success: function(r) {

                    if (r == 1) {
                        $("#hostEmailIsUnique").val("0");
                        $(".errorMessageEmail1").show();
                        $("#User_email_em_1a").show();
                    } else {
                        $(".errorMessageEmail1").hide();
                        $("#User_email_em_1a").hide();
                        $("#hostEmailIsUnique").val("1");
                        sendHostForm();
                    }
                }
            });
        }
    }

    function checkReasonIfUnique() {

        var visitReason = $("#VisitReason_reason").val();
        if (visitReason == '') {
            $("#visitReasonErrorMessage").show();
            $("#visitReasonErrorMessage").html("Reason cannot be blank.");
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitReason/checkReasonIfUnique&id='); ?>' + visitReason.trim(),
                dataType: 'json',
                data: visitReason,
                success: function(r) {

                    if (r == 1) {
                        $("#visitReasonErrorMessage").show();
                        $("#visitReasonErrorMessage").html("Reason is already registered.");
                    } else {
                        $("#visitReasonErrorMessage").hide();
                        sendReasonForm();
                    }
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


                    var dd = document.getElementById('Visit_reason');
                    for (var i = 0; i < dd.options.length; i++) {
                        if (dd.options[i].text === textToFind) {
                            dd.selectedIndex = i;
                            break;
                        }
                    }
                    $("#addreasonTable").hide();
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
                sendVisitForm("update-visit-form");
            }
        });
    }

    function checkNewHostEmailIfUnique() {
        var email = $(".New_user_email").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/checkEmailIfUnique&id='); ?>' + email.trim(),
            dataType: 'json',
            data: email,
            success: function(r) {

                if (r == 1) {
                    $("#newHostEmailIsUnique").val("0");
                    $(".errorMessageEmail2").show();
                } else {
                    $(".errorMessageEmail2").hide();
                    $("#newHostEmailIsUnique").val("1");
                    sendNewHostForm();
                }
            }
        });

    }
    
    function sendNewHostForm(){
    var hostform = $("#register-newhost-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("user/create")); ?>",
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
                
                sendVisitForm("update-visit-form");
            }
        });
    }

</script>