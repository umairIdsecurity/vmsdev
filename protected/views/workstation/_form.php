
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
        <?php if ($session['role'] == Roles::ROLE_SUPERADMIN) { ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'tenant'); ?></td>
                <td><select  onchange="getTenantAgent()"  id="Workstation_tenant" name="Workstation[tenant]">
                        <option disabled value='' selected>Please select a tenant</option>
                        <?php
                        $companyList = User::model()->findAllCompanyTenant();
                        foreach ($companyList as $key => $value) {
                            ?>
                            <option <?php
                    if ($model['tenant'] == $value['tenant']) {
                        echo " selected ";
                    }
                            ?> value="<?php echo $value['tenant']; ?>"><?php echo $value['name']; ?></option>
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

                            $companyList = User::model()->findAllTenantAgent($model['tenant']);
                            foreach ($companyList as $key => $value) {
                                ?>

                                <option disabled value='' selected>Please select a tenant agent</option>
                                <option <?php
                    if ($model['tenant_agent'] == $value['tenant_agent']) {
                        echo " selected ";
                    }
                                ?> value="<?php echo $value['tenant_agent']; ?>"><?php echo $value['name']; ?></option>
                                    <?php
                                }
                            } else {
                                ?>
                            <option disabled value='' selected>Please select a tenant agent</option>
                        <?php } ?>
                    </select></td>
                <td><?php echo $form->error($model, 'tenant_agent'); ?></td>
            </tr>
        <?php } else { ?>
            <input type="hidden" id="Workstation_tenant" name="Workstation[tenant]" value="<?php echo $session['tenant']; ?>">
            <?php if($session['role'] == Roles::ROLE_ADMIN) {?>
            <tr>
                <td><?php echo $form->labelEx($model, 'tenant_agent'); ?></td>
                <td><select id="Workstation_tenant_agent" name="Workstation[tenant_agent]">
                        <?php
                        if ($this->action->Id != 'create') {

                            $companyList = User::model()->findAllTenantAgent($model['tenant']);
                            foreach ($companyList as $key => $value) {
                                ?>

                                <option disabled value='' selected>Please select a tenant agent</option>
                                <option <?php
                    if ($model['tenant_agent'] == $value['tenant_agent']) {
                        echo " selected ";
                    }
                                ?> value="<?php echo $value['tenant_agent']; ?>"><?php echo $value['name']; ?></option>
                                    <?php
                                }
                            } else {
                                ?>
                            <option disabled value='' selected>Please select a tenant agent</option>
                        <?php } ?>
                    </select></td>
                <td><?php echo $form->error($model, 'tenant_agent'); ?></td>
            </tr>
            <?php } else {?>
            <input type="hidden" id="Workstation_tenant_agent" name="Workstation[tenant_agent]" value="<?php echo $session['tenant_agent']; ?>">
           
            <?php } ?>
        <?php } ?>
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
            <td><?php echo $form->error($model, 'contact_email_address',array('style'=>'text-transform:none;')); ?></td>
        </tr>
        <?php
        if(!empty($_GET['id']) && Yii::app()->urlManager->parseUrl(Yii::app()->request) == 'workstation/update'){
            ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'card_type'); ?></td>

                <td>
                    <?php

                    $criteria = new CDbCriteria();
                    $criteria->addInCondition("module", array(1,2));
                    echo  $form->checkBoxList(
                        $model,'card_type',
                        CHtml::listData(
                            CardType::model()->findAll($criteria),'id', 'name'),
                                array('separator'=>' ',
                                    'labelOptions'=>array('style'=>'display:inline')
                                )

                    );
                    ?>
                <td>
                <td><?php echo $form->error($model, 'card_type'); ?></td>
            </tr>

        <?php
        }
        ?>


        <input type="hidden" id="Workstation_created_by" name="Workstation[created_by]" value="<?php echo $session['id']; ?>">
    </table>


    <div class="row buttons buttonsAlignToRight">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->


<script>
    $(document).ready(function() {
        if('<?php echo $session['role']; ?>' == 1){
            getTenantAgent();
        }
        
    });
    function getTenantAgent() {
        var tenant = $("#Workstation_tenant").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('user/GetTenantAgentAjax&id='); ?>' + tenant,
            dataType: 'json',
            data: tenant,
            success: function(r) {
                $('#Workstation_tenant_agent option[value!=""]').remove();
                $.each(r.data, function(index, value) {
                    $('#Workstation_tenant_agent').append('<option value="' + value.tenant_agent + '">' + value.name + '</option>');

                });
            }
        });
    }
</script>