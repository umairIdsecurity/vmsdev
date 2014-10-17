<?php
/* @var $this VisitorController */
/* @var $model Visitor */
?>

<h1>Register a Visitor</h1>
<dl class="tabs three-up">
    <dt id="selectCardA" style="display:none;">Select Card Type</dt>
    <dd class="active" id="selectCard"><a href="#step1" id="selectCardB">Select Card Type</a></dd>
    <dt id="findVisitorA">Find or Add New Visitor Record</dt>
    <dd style="display:none;" id="findVisitor"><a href="#step2" id="findVisitorB">Find or Add New Visitor Record</a></dd>
    <dt id="findHostA">Find or Add Host</dt>
    <dd style="display:none;" id="findHost"><a href="#step3" id="findHostB">Find or Add Host</a></dd>
</dl>


<ul class="tabs-content">
    <li class="active" id="stepTab">
        <?php $this->renderPartial('selectCardType', array('model' => $model)); ?>

        <input type="hidden" id="cardtype"/>
    </li>
    <li id="step2Tab">
        <?php $this->renderPartial('findAddVisitorRecord', array('model' => $model)); ?>
    </li>
    <li id="step3Tab">
        <?php $this->renderPartial('findAddHostRecord', array('userModel' => $userModel)); ?>
    </li>
</ul>


<script>
    $(document).ready(function() {
        document.getElementById('Visitor_company').disabled = true;
        $('#Visitor_visitor_type').on('change', function(e) {
            $('#Visitor_company option[value!=""]').remove();
            $('#Visitor_tenant_agent option[value!=""]').remove();
            $('#Visitor_tenant').val("");

            if ($(this).val() == "2") {
                document.getElementById('Visitor_company').disabled = false;
            } else {
                document.getElementById('Visitor_company').disabled = true;
            }
        });

        $("#clicktabA").click(function(e) {
            e.preventDefault();
            showHideTabs('findVisitorB', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard', 'findHostA', 'findHost');
        });

        $("#clicktabB").click(function(e) {
            e.preventDefault();
            showHideTabs('findHostB', 'findHostA', 'findHost', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard');
        });

        $("#clicktabC").click(function(e) {
            e.preventDefault();
            $("#clicktabB").hide();
            $("#submitFormVisitor").click();
            $("#submitFormVisitor").show();
        });

        $("#btnBackTab2").click(function(e) {
            e.preventDefault();
            showHideTabs('selectCardB', 'selectCardA', 'selectCard', 'findVisitorA', 'findVisitor', 'findHostA', 'findHost');
            hidePreviousPage('step2Tab', 'stepTab');
        });

        $("#btnBackTab3").click(function(e) {
            e.preventDefault();
            showHideTabs('findVisitorB', 'findVisitorA', 'findVisitor', 'selectCardA', 'selectCard', 'findHostA', 'findHost');
            hidePreviousPage('step3Tab', 'stepTab2');
        });


        function showHideTabs(showThisId, hideThisId, showThisRow, hideOtherA, showOtherRowA, hideOtherB, showOtherRowB) {
            $("#" + showThisId).click();// findvisitorB dt
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
    });

    function closeAndPopulateField(id) {
        $("#dismissModal").click();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('visitor/getVisitorDetails&id='); ?>' + id,
            dataType: 'json',
            data: id,
            success: function(r) {
                $('#User_company option[value!=""]').remove();

                $.each(r.data, function(index, value) {
                    $("#Visitor_first_name").val(value.first_name);
                    $("#Visitor_last_name").val(value.first_name);

                });

            }
        });
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
                    return false;
                } else {
                    $(".errorMessageEmail").hide();
                    $("#emailIsUnique").val("1");
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
</script>