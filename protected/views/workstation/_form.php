<?php
/* @var $this WorkstationsController */
/* @var $model Workstations */
/* @var $form CActiveForm */
$session = new CHttpSession;
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'workstations-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <table>
        <tr>
            <td><?php echo $form->labelEx($model, 'name'); ?></td>
            <td><?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'location'); ?></td>
            <td><?php echo $form->textField($model, 'location', array('size' => 60, 'maxlength' => 100)); ?></td>
            <td><?php echo $form->error($model, 'location'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'contact_name'); ?></td>
            <td><?php echo $form->textField($model, 'contact_name', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'contact_name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'contact_number'); ?></td>
            <td><?php echo $form->textField($model, 'contact_number'); ?></td>
            <td><?php echo $form->error($model, 'contact_number'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'contact_email_address'); ?></td>
            <td><?php echo $form->textField($model, 'contact_email_address', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'contact_email_address'); ?></td>
        </tr>
        <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) { ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'tenant'); ?></td>
                <td><select  onchange="getTenantAgent()"  id="Workstation_tenant" name="Workstation[tenant]">
                        <option disabled value='' selected>Select Tenant</option>
                        <?php
                        $criteria = new CDbCriteria;
                        $criteria->select = 'id,tenant,first_name,last_name';
                        $criteria->addCondition('role = 1');

                        $opts = User::model()->findAll($criteria);
                        foreach ($opts as $key => $value) {
                            ?>
                            <option <?php
                            if ($model['tenant'] == $value->id) {
                                echo " selected ";
                            }
                            ?> value="<?php echo $value->tenant; ?>"><?php echo $value->first_name . " " . $value->last_name; ?></option>
                                <?php
                            }
                            ?>

                    </select></td>
                <td><?php echo $form->error($model, 'tenant'); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'tenant_agent'); ?></td>
                <td><select id="Workstation_tenant_agent" name="Workstation[tenant_agent]">
                        <?php
                        if ($this->action->Id != 'create') {
                            $criteria = new CDbCriteria;
                            $criteria->select = 'id,first_name,last_name';
                            $criteria->addCondition('id = "'.$model['tenant_agent'].'"');

                            $opts = User::model()->findAll($criteria);
                            foreach ($opts as $key => $value) {
                                ?>
                                <option <?php
                                if ($model['tenant_agent'] == $value->id) {
                                    echo " selected ";
                                }
                                ?> value="<?php echo $value->id; ?>"><?php echo $value->first_name . " " . $value->last_name; ?></option>
                                    <?php
                                }
                            } else {
                                ?>
                            <option disabled value='' selected>Select Tenant Agent</option>
    <?php } ?>
                    </select></td>
                <td><?php echo $form->error($model, 'tenant_agent'); ?></td>
            </tr>
<?php } else { ?>
            <input type="hidden" id="Workstation_tenant" name="Workstation[tenant]" value="<?php echo $session['tenant']; ?>">
            <input type="hidden" id="Workstation_tenant_agent" name="Workstation[tenant_agent]" value="<?php echo $session['tenant_agent'] ?>">

        <?php } ?>
<?php if ($this->action->id != 'update') { ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'password'); ?></td>
                <td><input type="password" id="Workstation_password" name="Workstation[password]" ></td>
                <td><?php echo $form->error($model, 'password'); ?></td>
            </tr>
<?php } ?>
        <input type="hidden" id="Workstation_created_by" name="Workstation[created_by]" value="<?php echo $session['id']; ?>">
    </table>


    <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->


<script>
    function getTenantAgent() {
        var tenant = $("#Workstation_tenant").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/GetTenantAjax&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Workstation_tenant_agent option[value!=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Workstation_tenant_agent').append('<option value="' + value.id + '">' + value.name + '</option>');

                });
            }
        });
    }
</script>