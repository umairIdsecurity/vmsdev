<?php
$session = new CHttpSession;
?>
<div id="findAddHostRecordDiv" class="findAddHostRecordDiv form">


    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'registerhostform',
        'action' => Yii::app()->createUrl('/user/create'),
        'htmlOptions' => array("name" => "registerhostform", "style" => "display:block;"),
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
    <input type="text" id="hostEmailIsUnique" value="0"/>
    <div class="visitor-title">Add Host</div>
    <div >
        <table  id="addhost-table" data-ng-app="PwordForm">

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
                    <?php echo "<br>" . $form->error($userModel, 'department'); ?>
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
                    <div style="" id="User_email_em_" class="errorMessage errorMessageEmail1" >Email Address has already been taken.</div>
                </td>
                <td>
                    <?php echo $form->labelEx($userModel, 'contact_number'); ?><br>
                    <?php echo $form->textField($userModel, 'contact_number', array('size' => 50, 'maxlength' => 50)); ?>
                    <?php echo "<br>" . $form->error($userModel, 'contact_number'); ?>
                </td>
            </tr>
            <tr>
                <td>
                        <label for="User_password">Password <span class="required">*</span></label><br>
                        <input type="password" id="User_password" name="User[password]" onChange="checkPasswordMatch();">			
                        <?php echo "<br>" . $form->error($userModel, 'password'); ?>
                    </td>

                    <td>
                        <label for="User_repeatpassword">Repeat Password <span class="required">*</span></label><br>
                        <input type="password" id="User_repeatpassword" name="User[repeatpassword]" onChange="checkPasswordMatch();"/>			
                        <div style='font-size:10px;color:red;font-size:0.9em;display:none;margin-bottom:-20px;' id="passwordErrorMessage">New Password does not match with <br>Repeat New Password. </div>
                        <?php echo "<br>" . $form->error($userModel, 'repeatpassword'); ?>
                    </td>
            </tr>
            <tr style="display:none;">

                <td id="hostTenantRow"><?php echo $form->labelEx($userModel, 'tenant'); ?><br>
                    <input type="text" id="User_tenant" name="User[tenant]" value="<?php echo $session['tenant']; ?>"/>
                    <?php echo "<br>" . $form->error($userModel, 'tenant'); ?>
                </td>
                <td id="hostTenantAgentRow"><?php echo $form->labelEx($userModel, 'tenant_agent'); ?><br>
                    <input type="text" id="User_tenant_agent" name="User[tenant_agent]" value="<?php echo $session['tenant_agent']; ?>"/>
                    <?php echo "<br>" . $form->error($userModel, 'tenant_agent'); ?>
                </td>
                <td id="hostCompanyRow">
                    <?php echo $form->labelEx($userModel, 'company'); ?><br>
                    <input type="text" id="User_company" name="User[company]" value="<?php echo $session['company']; ?>"/>
                    <?php echo "<br>" . $form->error($userModel, 'company'); ?>
                </td>

                <td >
                    <input name="User[role]" id="User_role" value="<?php echo Roles::ROLE_STAFFMEMBER ?>"/>
                    <input name="User[user_type]" id="User_user_type" value="<?php echo UserType::USERTYPE_INTERNAL; ?>"/>             
                </td>
            </tr>


        </table>

    </div>
    <div >
        <input type="button" id="clicktabC" value="Add" style="display:none;"/>

        <input type="submit" value="Add" name="yt0" id="submitFormUser" />
    </div>
    <?php $this->endWidget(); ?>

</div>

<script>
    $(document).ready(function() {
        $("#User_repeatpassword").keyup(checkPasswordMatch);
        $("#User_password").keyup(checkPasswordMatch);
    
    });
    function sendHostForm() {

        var hostform = $("#registerhostform").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("user/create")); ?>",
            data: hostform,
            success: function(data) {
                window.location = "index.php?r=dashboard/viewmyvisitors";
            },
            error: function() {
                window.location = "index.php?r=dashboard/viewmyvisitors";
            },
        });
    }
    
    function checkPasswordMatch() {
        var password = $("#User_password").val();
        var confirmPassword = $("#User_repeatpassword").val();

        if (password != confirmPassword)
            $("#passwordErrorMessage").show();
        else
            $("#passwordErrorMessage").hide();
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
                    $(".errorMessageEmail1").show();
                } else {
                    $(".errorMessageEmail1").hide();
                    sendHostForm();

                }
            }
        });
    }

</script>