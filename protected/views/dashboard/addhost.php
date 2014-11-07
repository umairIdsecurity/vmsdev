<?php
$session = new CHttpSession;
?>
<div id="findAddHostRecordDiv" class="findAddHostRecordDiv form">


    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register-host-form',
        'action' => Yii::app()->createUrl('/user/create'),
        'htmlOptions' => array("name" => "register-host-form", "style" => "display:block;"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                                sendHostForm();
                                }
                        }'
        ),
    ));
    ?>
    <?php echo $form->errorSummary($userModel); ?>
    <input type="text" id="hostEmailIsUnique" value="0"/>
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
                    <input name="User[password]" id="User_password" value="0"/>
                    <input name="User[repeatpassword]" id="User_repeat_password" value="0"/>
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

    });
    function sendHostForm() {

        var hostform = $("#register-host-form").serialize();
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
</script>