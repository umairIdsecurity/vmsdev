<div id="findAddHostRecordDiv" class="findAddHostRecordDiv form">
    <div>
        <label><b>Search Name:</b></label> 
        <input type="text" id="search-host" name="search-host" class="search-text"/> 
        <button class="host-findBtn" onclick="findHostRecord()" id="host-findBtn" style="display:none;" data-target="#findHostRecordModal" data-toggle="modal">Find Record</button>
        <button class="host-findBtn" id="dummy-host-findBtn">Find Host</button>

        <div class="errorMessage" id="searchTextHostErrorMessage" style="display:none;">Search Name cannot be blank.</div>
    </div>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register-host-form',
        'action'=>Yii::app()->createUrl('/user/create'),
        'htmlOptions' => array("name" => "register-host-form"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                                checkHostEmailIfUnique();
                                }
                        }'
        ),
    ));
    ?>


    <?php echo $form->errorSummary($userModel); ?>
    <div class="visitor-title">Add Host</div>
    <div>
        <table  id="addhost-table">
            
            <tr>
                <td>
                    <?php echo $form->labelEx($userModel, 'first_name'); ?><br>
                    <?php echo $form->textField($userModel, 'first_name', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'first_name'); ?>
                </td>
                <td>
                    <?php echo $form->labelEx($userModel, 'last_name'); ?><br>
                    <?php echo $form->textField($userModel, 'last_name', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'last_name'); ?>
                </td>
                <td>

                    <?php echo $form->labelEx($userModel, 'department'); ?><br>
                    <?php echo $form->textField($userModel, 'department', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'deprtment'); ?>
                </td>
            </tr>

            <tr>
                <td>
                    <?php echo $form->labelEx($userModel, 'staff_id'); ?><br>
                    <?php echo $form->textField($userModel, 'staff_id', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'staff_id'); ?>
                </td>
                
                <td>
                    <?php echo $form->labelEx($userModel, 'email'); ?><br>
                    <?php echo $form->textField($userModel, 'email', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'email'); ?>
                    <div style="" id="User_email_em_" class="errorMessage errorMessageEmail" >Email Address has already been taken.</div>
                </td>
                <td>
                    <?php echo $form->labelEx($userModel, 'contact_number'); ?><br>
                    <?php echo $form->textField($userModel, 'contact_number', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'contact_number'); ?>
                </td>
            </tr>
            <tr>
                
                <td id="visitorTenantRow"><?php echo $form->labelEx($userModel, 'tenant'); ?><br>

                    <select id="User_tenant" onchange="populateTenantAgentAndCompanyField()" name="User[tenant]"  >
                        <option value='' selected>Select Admin</option>
                        <?php
                        $allAdminNames = User::model()->findAllAdmin();
                        foreach ($allAdminNames as $key => $value) {
                            ?>
                            <option value="<?php echo $value->tenant; ?>"><?php echo $value->first_name . " " . $value->last_name; ?></option>
                            <?php
                        }
                        ?>
                    </select><?php echo "<br>" . $form->error($userModel, 'tenant'); ?>
                </td>
                <td id="visitorTenantAgentRow"><?php echo $form->labelEx($userModel, 'tenant_agent'); ?><br>

                    <select id="User_tenant_agent" name="User[tenant_agent]" onchange="populateCompanyWithSameTenantAndTenantAgent()" >
                        <?php
                        echo "<option value='' selected>Select Tenant Agent</option>";
                        ?>
                    </select><?php echo "<br>" . $form->error($userModel, 'tenant_agent'); ?>
                </td>
                <td id="hostCompanyRow">

                    <?php echo $form->labelEx($userModel, 'company'); ?><br>
                    <select id="User_company" name="User[company]" >
                        <option value=''>Select Company</option>
                    </select>

                    <?php echo "<br>" . $form->error($userModel, 'company'); ?>
                </td>
            </tr>
            

        </table>

    </div>
    <input type="button" class="visitor-backBtn" id="btnBackTab3" value="Back"/>
    <input type="button" id="clicktabC" value="Save and Continue"/>

    <input type="submit" value="Save and Continue" name="yt0" id="submitFormUser" style="display:none;"/>
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

    function findUserRecord() {
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

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'findUserRecordModal')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal" id="dismissModal">&times;</a>
    <h4>Search Results for : <span id='search'></span></h4>
</div>

<div class="modal-body">

</div>

<?php $this->endWidget(); ?>