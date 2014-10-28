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
        <td style="padding:5px;">
            <img src="<?php echo Yii::app()->request->baseUrl . '/images/cardprint.png'; ?>"/><br>
            &nbsp <input type="button" class="printCardBtn" value="Print Card" />
        </td>
        <td>
            <?php
            $this->renderPartial('visitordetail-visitorInformation', array('model' => $model,
                'visitorModel' => $visitorModel,
                'hostModel' => $hostModel,
                'reasonModel' => $reasonModel,
            ));
            ?>

        </td>
        <td>
            <table id="actionsVisitDetails">
                <tr>
                    <td></td>
                    <td style="padding:25px 10px 10px 20px;">
                        <span class="actionsLabel">Log Visit</span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td style="padding:5px 10px 10px 20px;">
                        <span class="actionsLabel">Preregister a Visit</span>
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
        var email = $("#User_email").val();
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
                    } else {
                        $(".errorMessageEmail1").hide();
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
</script>