<?php
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */
$session = new CHttpSession;
if (isset($_GET['tenant'])) {
    $tenant = $_GET['tenant'];
} else {
    $tenant = '';
}

if ($this->action->id == 'update') {
    $companyid = $_GET['id'];
} else {
    $companyid = '';
}
?>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'company-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <?php
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>
    <?php echo $form->errorSummary($model); ?>
    <input type="hidden" id="Company_tenant" name="Company[tenant]" value="<?php echo $tenant; ?>">
    <table>
        <tr>
            <td style="width:160px;"><?php echo $form->labelEx($model, 'name'); ?></td>
            <td style="width:240px;"><?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150)); ?></td>
            <td><?php echo $form->error($model, 'name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'trading_name'); ?></td>
            <td><?php echo $form->textField($model, 'trading_name', array('size' => 60, 'maxlength' => 150)); ?></td>
            <td><?php echo $form->error($model, 'trading_name'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'Upload Company Logo'); ?></td>
            <td id="uploadRow">
                <input type="hidden" id="Company_logo" name="Company[logo]" >
                <div class="companyLogoDiv" <?php
                if ($model['logo'] == NULL) {
                    echo "style='display:none !important;'";
                }
                ?>>
                    <?php if ($companyid != '') { ?><img id='companyLogo' src="<?php echo Yii::app()->request->baseUrl . "/" . $model->getCompanyLogo($companyid); ?>"/>
                    <?php } else { ?> 
                       <!-- <img id="companyLogo" src="" style="display:none;"/> -->
                    <?php } ?>
                </div>
                <?php require_once(Yii::app()->basePath . '\draganddrop\index.php'); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'contact'); ?></td>
            <td><?php echo $form->textField($model, 'contact', array('size' => 60, 'maxlength' => 100)); ?></td>
            <td><?php echo $form->error($model, 'contact'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'billing_address'); ?></td>
            <td><?php echo $form->textField($model, 'billing_address', array('size' => 60, 'maxlength' => 150)); ?></td>
            <td><?php echo $form->error($model, 'billing_address'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'email_address'); ?></td>
            <td><?php echo $form->textField($model, 'email_address', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'email_address'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'office_number'); ?></td>
            <td><?php echo $form->textField($model, 'office_number'); ?></td>
            <td><?php echo $form->error($model, 'office_number'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'mobile_number'); ?></td>
            <td><?php echo $form->textField($model, 'mobile_number'); ?></td>
            <td><?php echo $form->error($model, 'mobile_number'); ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'website'); ?></td>
            <td><?php echo $form->textField($model, 'website', array('size' => 50, 'maxlength' => 50)); ?></td>
            <td><?php echo $form->error($model, 'website'); ?></td>
        </tr>

    </table>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Update', array('id' => 'createBtn')); ?>
        <?php if (isset($_GET['viewFrom'])) { ?>
            <input class="yiiBtn" type='button' value='Cancel' onclick='closeParent()'></input>
        <?php
        } else {
            if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                ?>
                <button class="yiiBtn" id="modalBtn" style="padding:1.5px 6px;margin-top:-4.1px;" data-target="#viewLicense" data-toggle="modal">View License Details</button> 
                <?php } else { ?>
                <button class="yiiBtn" style="padding:2px 6px;margin-top:-4.1px;" type='button' onclick="gotoLicensePage()">License Details</bitton>
        <?php } } ?>
            </div>

        <?php $this->endWidget(); ?>

        </div><!-- form -->
        <script>
            function closeParent() {
                window.parent.dismissModal();
            }

            function gotoLicensePage() {
                window.location = 'index.php?r=licensedetails/update&id=1';
            }
        </script>

        <div class="modal hide fade" id="viewLicense" style="width:600px;">
            <div class="modal-header">
                <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
                <br>
            </div>
            <div id="modalBody" style="padding:20px;">
                <?php
                foreach (LicenseDetails::model()->getLicenseDetails() as $value) {
                    echo $value;
                }
                ?> 
            </div>

        </div>
        