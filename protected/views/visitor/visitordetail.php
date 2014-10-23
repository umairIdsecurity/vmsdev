<?php
/* @var $this VisitorController */
/* @var $model Visitor */
$session = new CHttpSession;
?>
<table id="visitorDetailDiv">
    <tr>
        <th>Visitor Detail</th>
        <th style="width:35%!important;">Visitor Information</th>
        <th>Actions</th>
    </tr>
    <tr>
        <td></td>
        <td>
           <?php $this->renderPartial('visitordetail-visitorInformation', array('model' => $model)); ?> 
        </td>
        <td>
        </td>
        
    </tr>
</table>

<input type="text" id="currentRoleOfLoggedInUser" value="<?php echo $session['role']; ?>">
<input type="text" id="currentCompanyOfLoggedInUser" value="<?php echo User::model()->getCompany($session['id']); ?>">
<script>
    $(document).ready(function() {
        document.getElementById('Visitor_company').disabled = true;

        if ($("#currentRoleOfLoggedInUser").val() != 5) { //not superadmin
            $("#Visitor_company").val($("#currentCompanyOfLoggedInUser").val());
            $("#Visitor_tenant").val('<?php echo $session['tenant']; ?>');
            $("#User_tenant").val('<?php echo $session['tenant']; ?>');
            $("#Visitor_tenant_agent").val('<?php echo $session['tenant_agent']; ?>');
            $("#User_tenant_agent").val('<?php echo $session['tenant_agent']; ?>');
        }
        $('#Visitor_visitor_type').on('change', function(e) {
            $('#Visitor_company option[value!=""]').remove();
            $('#Visitor_tenant_agent option[value!=""]').remove();
            $('#Visitor_tenant').val("");
            if ($(this).val() == "2") {
                $("#register-host-patient-form").hide();
                $("#register-host-form").show();
                document.getElementById('Visitor_company').disabled = false;
            } else {
                $("#register-host-patient-form").show();
                $("#register-host-form").hide();
                document.getElementById('Visitor_company').disabled = true;
            }

        });
        $("#clicktabA").click(function(e) {
            e.preventDefault();
            showHideTabs('findVisitorB', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard', 'findHostA', 'findHost');
        });

        $("#clicktabB").click(function(e) {
            e.preventDefault();
            if ($("#Visit_reason").val() == '' || $("#Visit_reason").val() == 'Other') {
                $(".visitorReason").show();
            } else
            {
                $(".visitorReason").hide();
                showHideTabs('findHostB', 'findHostA', 'findHost', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard');
            }
        });

        $("#clicktabB1").click(function(e) {
            e.preventDefault();
            var visit_reason = $("#Visit_reason_search").val();

            if (($("#selectedVisitorInSearchTable").val() == '' && $("#search-visitor").val() != '') || $("#selectedVisitorInSearchTable").val() == '') {
                $("#searchTextErrorMessage").html("Please select a visitor.");
                $("#searchTextErrorMessage").show();
            }
            else if (visit_reason == '' || visit_reason == 'undefined' || visit_reason == 'Other')
            {
                $("#search-visitor-reason-error").show();
            }
            else {
                $("#searchTextErrorMessage").hide();
                $("#search-visitor-reason-error").hide();
                showHideTabs('findHostB', 'findHostA', 'findHost', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard');
            }
        });

        $("#clicktabB2").click(function(e) {
            e.preventDefault();

            //checks if host is from search and verifys that a user has been selected
            if (($("#selectedHostInSearchTable").val() == '' && $("#search-host").val() != '') || $("#selectedHostInSearchTable").val() == '') {
                $("#searchTextHostErrorMessage").html("Please select a host.");
                $("#searchTextHostErrorMessage").show();
            } else if ($("#selectedVisitorInSearchTable").val() != '0') { // if visitor is from search
                populateVisitFormFields();
                $("#searchTextHostErrorMessage").hide();
            }
            else {
                $("#searchTextHostErrorMessage").hide();
                $("#clicktabB").hide();
                $("#submitFormVisitor").click();
                $("#submitFormVisitor").show();
            }
        });

        $("#clicktabC").click(function(e) {
            e.preventDefault();
            if ($("#selectedVisitorInSearchTable").val() != '0') { // if visitor is from search
                $("#submitFormUser").click();
                $("#submitFormUser").show();
                $("#clicktabC").hide();
            } else
            {
                $("#clicktabB").hide();
                $("#submitFormVisitor").click();
                $("#submitFormVisitor").show();
            }
        });

        $("#dummy-submitFormPatientName").click(function(e) {
            e.preventDefault();
            if ($("#selectedVisitorInSearchTable").val() != '0') { //if visitor is from search
                $("#submitFormPatientName").click();
                $("#submitFormPatientName").show();
                $("#dummy-submitFormPatientName").hide();
            }
            else
            {
                $("#clicktabB").hide();
                $("#submitFormVisitor").click();
                $("#submitFormVisitor").show();
            }
        });

        $(".btnBackTab2").click(function(e) {
            e.preventDefault();
            showHideTabs('selectCardB', 'selectCardA', 'selectCard', 'findVisitorA', 'findVisitor', 'findHostA', 'findHost');
            hidePreviousPage('step2Tab', 'stepTab');
        });
        $(".btnBackTab3").click(function(e) {
            e.preventDefault();
            showHideTabs('findVisitorB', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard', 'findHostA', 'findHost');
            hidePreviousPage('step3Tab', 'stepTab2');
        });
        function showHideTabs(showThisId, hideThisId, showThisRow, hideOtherA, showOtherRowA, hideOtherB, showOtherRowB) {
            $("#" + showThisId).click(); // findvisitorB dt
            $("#" + showThisId).show(); //findvisitorB dt
            $("#" + showThisRow).show(); //findVisitor dd
            $("#" + hideThisId).hide(); //findvisitor a dt

            $("#" + hideOtherA).show(); //selectcardtype dd
            $("#" + showOtherRowA).hide(); //selectcardtype dd

            $("#" + hideOtherB).show(); //selectcardtype dd
            $("#" + showOtherRowB).hide(); //selectcardtype dd
        }

        function hidePreviousPage(hideThisLiId, showThisLiId) {
            $("#" + hideThisLiId).hide();
            $("#" + showThisLiId).show();
        }
    }
    );

    function closeAndPopulateField(id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/getVisitorDetails&id='); ?>' + id,
            dataType: 'json',
            data: id,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#searchVisitorTableDiv h4").html("Selected Visitor Record : " + value.first_name + ' ' + value.last_name);
                });
            }
        });

        $("#visitor_fields_for_Search").show();
        $("#selectedVisitorInSearchTable").val(id);
        $("#visitorId").val(id);
    }

    function populateFieldHost(id) {
        if ($("#Visitor_visitor_type").val() != 1) {

            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/getHostDetails&id='); ?>' + id,
                dataType: 'json',
                data: id,
                success: function(r) {
                    $.each(r.data, function(index, value) {
                        $("#searchHostTableDiv h4").html("Selected Host Record : " + value.first_name + " " + value.last_name);

                    });
                }
            });
        } else {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('visitor/GetPatientDetails&id='); ?>' + id,
                dataType: 'json',
                data: id,
                success: function(r) {
                    $.each(r.data, function(index, value) {
                        $("#searchHostTableDiv h4").html("Selected Patient Record : " + value.name);

                    });
                }
            });
        }
        $("#selectedHostInSearchTable").val(id);
        $("#hostId").val(id);
    }

    function checkEmailIfUnique() {
        var email = $("#Visitor_email").val();
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
                    getLastVisitorId();
                }
            }
        });
    }

    function checkHostEmailIfUnique() {
        var email = $("#User_email").val();
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

    function checkPatientIfUnique() {
        var patientname = $("#Patient_name").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('patient/checkPatientIfUnique&id='); ?>' + patientname.trim(),
            dataType: 'json',
            data: patientname,
            success: function(r) {

                if (r == 1) {
                    $("#patientIsUnique").val("0");
                    $("#Patient_name_error").show();
                } else {
                    $("#Patient_name_error").hide();
                    $("#patientIsUnique").val("1");
                    sendPatientForm();
                }
            }
        });
    }

    function populateTenantAgentAndCompanyField()
    {
        $('#Visitor_company option[value!=""]').remove();
        $('#Visitor_tenant_agent option[value!=""]').remove();
        var visitor_type = $("#Visitor_visitor_type").val();
        var tenant = $("#Visitor_tenant").val();
        if (visitor_type == "1") {
            getTenantAgentWithSameTenant(tenant, '');
            document.getElementById('Visitor_company').disabled = true;
        } else {
            getTenantAgentWithSameTenant(tenant);
            getCompanyWithSameTenant(tenant);
        }
    }

    function populateHostTenantAgentAndCompanyField()
    {
        $('#User_company option[value!=""]').remove();
        $('#User_tenant_agent option[value!=""]').remove();
        var tenant = $("#User_tenant").val();

        getHostTenantAgentWithSameTenant(tenant);
        getHostCompanyWithSameTenant(tenant);

    }

    function getTenantAgentWithSameTenant(tenant, selected) {
        $('#Visitor_tenant_agent').empty();
        $('#Visitor_tenant_agent').append('<option value="">Select Tenant Agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $('#Visitor_tenant_agent').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                $("#Visitor_tenant_agent").val(selected);
            }
        });
    }

    function getHostTenantAgentWithSameTenant(tenant) {
        $('#User_tenant_agent').empty();
        $('#User_tenant_agent').append('<option value="">Select Tenant Agent</option>');
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetTenantAgentWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $('#User_tenant_agent').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function getCompanyWithSameTenant(tenant) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Visitor_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function getHostCompanyWithSameTenant(tenant) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('company/GetCompanyWithSameTenant&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#User_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function populateCompanyWithSameTenantAndTenantAgent() {
        $('#Visitor_company option[value!=""]').remove();
        getCompanyWithSameTenantAndTenantAgent($("#Visitor_tenant").val(), $("#Visitor_tenant_agent").val());
    }

    function populateHostCompanyWithSameTenantAndTenantAgent() {
        $('#User_company option[value!=""]').remove();
        getHostCompanyWithSameTenantAndTenantAgent($("#User_tenant").val(), $("#User_tenant_agent").val());
    }

    function getCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenantAndTenantAgent&id='); ?>' + tenant + '&tenantagent=' + tenant_agent,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Visitor_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Visitor_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function getHostCompanyWithSameTenantAndTenantAgent(tenant, tenant_agent) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetCompanyWithSameTenantAndTenantAgent&id='); ?>' + tenant + '&tenantagent=' + tenant_agent,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#User_company option[value=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#User_company').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
    }

    function showHideHostPatientName(visitor_type) {
        if (visitor_type.value == 1) {
            $("#register-host-patient-form").show();
            $("#register-host-form").hide();
        } else {
            $("#register-host-patient-form").hide();
            $("#register-host-form").show();
        }

        $("#Visitor_visitor_type").val(visitor_type.value);
        $("#Visitor_visitor_type_search").val(visitor_type.value);
        $("#Visit_visitor_type").val(visitor_type.value);
    }

    function getLastVisitorId() {
        var id = $("#Visitor_email").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/GetIdOfUser&id='); ?>' + id,
            dataType: 'json',
            data: id,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#visitorId").val(value.id);
                    $("#Visit_visitor").val(value.id);
                });
                return true;
            }
        });
        return true;
    }

    function getLastHostId() {
        var id = $("#User_email").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/GetIdOfUser&id='); ?>' + id.trim(),
            dataType: 'json',
            data: id,
            success: function(r) {
                $.each(r.data, function(index, value) {
                    $("#hostId").val(value.id);
                    $("#Visit_host").val(value.id);
                });
            }
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
                    $("#hostId").val(value.id);
                    $("#Visit_patient").val(value.id);
                });

            }
        });
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
                        $("#patientIsUnique").val("0");
                        $("#visitReasonErrorMessage").show();
                        $("#visitReasonErrorMessage").html("Reason is already registered.");
                    } else {
                        $("#visitReasonErrorMessage").hide();
                        $("#patientIsUnique").val("1");
                        sendReasonForm();
                    }
                }
            });
        }
    }

</script>