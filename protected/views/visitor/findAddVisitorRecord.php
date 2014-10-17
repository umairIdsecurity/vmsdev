<div id="findAddVisitorRecordDiv" class="findAddVisitorRecordDiv form">
    <div>
        <label><b>Search Name:</b></label> 
        <input type="text" id="search-visitor" name="search-visitor" class="search-text"/> 
        <button class="visitor-findBtn" onclick="findVisitorRecord()" id="visitor-findBtn" style="display:none;" data-target="#findVisitorRecordModal" data-toggle="modal">Find Record</button>
        <button class="visitor-findBtn" id="dummy-visitor-findBtn">Find Record</button>

        <div class="errorMessage" id="searchTextErrorMessage" style="display:none;">Search Name cannot be blank.</div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register-form',
        'htmlOptions' => array("name" => "register-form"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                             checkEmailIfUnique();
                             if($("#emailIsUnique").val() == 1){
                             $.ajax({
                                        "type":"POST",
                                        "url":"' . CHtml::normalizeUrl(array("visitor/create")) . '",
                                        "data":form.serialize(),
                                        "success":function(data){$("#clicktabB").click();},
                                        
                                        });
}
                               } else{
                            $("#clicktabA").click();    
                            }
                        }'
        ),
    ));
    ?>


    <?php echo $form->errorSummary($model); ?>
    <input type="text" id="emailIsUnique"/>
    <div class="visitor-title">Add New Visitor Record</div>
    <div>
        <table  id="addvisitor-table">
            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'visitor_type'); ?><br>
                    <?php echo $form->dropDownList($model, 'visitor_type', VisitorType::$VISITOR_TYPE_LIST); ?>
                    <?php echo "<br>" . $form->error($model, 'visitor_type'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'first_name'); ?><br>
                    <?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($model, 'first_name'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'last_name'); ?><br>
                    <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($model, 'last_name'); ?>
                </td>
                <td id="visitorCompanyRow">

                    <?php echo $form->labelEx($model, 'company'); ?><br>
                    <select id="Visitor_company" name="Visitor[company]" >
                        <option value=''>Select Company</option>
                    </select>

                    <?php echo "<br>" . $form->error($model, 'company'); ?>
                </td>
            </tr>

            <tr>
                <td>
                    <?php echo $form->labelEx($model, 'position'); ?><br>
                    <?php echo $form->textField($model, 'position', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($model, 'position'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'contact_number'); ?><br>
                    <?php echo $form->textField($model, 'contact_number', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($model, 'contact_number'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($model, 'email'); ?><br>
                    <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($model, 'email'); ?>
                    <div style="" id="Visitor_email_em_" class="errorMessage errorMessageEmail" >Email Address has already been taken.</div>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="Visit_reason">Reason</label><br>
                    <select id="Visit_reason" name="Visitor[reason]">
                        <option value='' selected>Select Reason</option>
                        <?php
                        $reason = VisitReason::model()->findAllReason();
                        foreach ($reason as $key => $value) {
                            ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->reason; ?></option>
                            <?php
                        }
                        ?>
                        <option value="Other">Other</option>
                    </select>
                </td>
                <td id="visitorTenantRow"><?php echo $form->labelEx($model, 'tenant'); ?><br>

                    <select id="Visitor_tenant" onchange="populateTenantAgentAndCompanyField()" name="Visitor[tenant]"  >
                        <option value='' selected>Select Admin</option>
                        <?php
                        $allAdminNames = User::model()->findAllAdmin();
                        foreach ($allAdminNames as $key => $value) {
                            ?>
                            <option value="<?php echo $value->tenant; ?>"><?php echo $value->first_name . " " . $value->last_name; ?></option>
                            <?php
                        }
                        ?>
                    </select><?php echo "<br>" . $form->error($model, 'tenant'); ?>
                </td>
                <td id="visitorTenantAgentRow"><?php echo $form->labelEx($model, 'tenant_agent'); ?><br>

                    <select id="Visitor_tenant_agent" name="Visitor[tenant_agent]" onchange="populateCompanyWithSameTenantAndTenantAgent()" >
                        <?php
                        echo "<option value='' selected>Select Tenant Agent</option>";
                        ?>
                    </select><?php echo "<br>" . $form->error($model, 'tenant_agent'); ?>
                </td>
            </tr>

        </table>

    </div>
    <input type="button" class="visitor-backBtn" id="btnBackTab2" value="Back"/>
    <input type="button" id="clicktabB" value="Save and Continue"/>

    <input type="submit" value="Save and Continue" name="yt0" id="submitFormVisitor" style="display:none;"/>
    <?php $this->endWidget(); ?>

</div>

<script>
    $(document).ready(function() {
        $("#dummy-visitor-findBtn").click(function(e) {
            e.preventDefault();
            var searchText = $("#search-visitor").val();
            if (searchText != '') {
                $("#searchTextErrorMessage").hide();
                $("#visitor-findBtn").click();
            } else {
                $("#searchTextErrorMessage").show();
            }
        });
    });

    function findVisitorRecord() {
        //append searched text in modal
        var searchText = $("#search-visitor").val();
        var span = document.getElementById('search');
        while (span.firstChild) {
            span.removeChild(span.firstChild);
        }
        span.appendChild(document.createTextNode(searchText));

        //change modal url to pass user searched text
        var url = 'index.php?r=visitor/findvisitor&id=' + searchText;
        $(".modal-body").html('<iframe width="100%" height="400px" frameborder="0" scrolling="no" src="' + url + '"></iframe>');
    }
</script>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'findVisitorRecordModal')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal" id="dismissModal">&times;</a>
    <h4>Search Results for : <span id='search'></span></h4>
</div>

<div class="modal-body">

</div>

<?php $this->endWidget(); ?>