
<?php
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */


$session = new CHttpSession;

$tenant = '';
$tenantAgent = '';
if (isset($_GET['tenant'])) {
    $tenant = $_GET['tenant'];
} elseif ($session['role'] != Roles::ROLE_SUPERADMIN) {
    $tenant = $session['tenant'];
}

if (isset($_GET['tenant_agent'])) {
    $tenantAgent = $_GET['tenant_agent'];
} elseif ($session['role'] != Roles::ROLE_SUPERADMIN) {
    $tenantAgent = $session['tenant_agent'];
}

$dataId = '';
if ($this->action->id == 'update') {
    $dataId = $_GET['id'];
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

    if (isset($_GET['viewFrom'])) {
        $isViewedFromModal = $_GET['viewFrom'];
    } else {
        echo $form->errorSummary($model);
    }
    ?>
    <input type="hidden" id="user_role" name="user_role" value="<?php echo $session['role']  ?>">
    <?php if ($this->action->id != 'update') {
        ?>
        <input type="hidden" id="Company_tenant" name="Company[tenant]" value="<?php echo $tenant; ?>">
        <input type="hidden" id="Company_tenant_agent" name="Company[tenant_agent]" value="<?php echo $tenantAgent; ?>">

    <?php } else {
        ?>
        <input type="hidden" id="Company_tenant_" name="Company[tenant_]" value="<?php echo $model['tenant']; ?>">
        <input type="hidden" id="Company_tenant_agent_" name="Company[tenant_agent_]" value="<?php echo $model['tenant_agent']; ?>">

    <?php
    }
    ?>
    <table>
        <tr>
            <td style="width:160px;">&nbsp;</td>
            <td style="width:240px;">
                <?php
                echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150 , 'placeholder' => 'Company Name' ));
                if (isset($_GET['viewFrom'])) {
                    echo "<br>" . $form->error($model, 'name');
                }
                ?>
            </td>
            <td><?php
                if (!isset($_GET['viewFrom'])) {
                    echo $form->error($model, 'name');
                }
                ?></td>

        </tr>

        <!--WangFu Modified-->
        <?php if ($session['role'] != Roles::ROLE_ADMIN) {?>
            <tr>
                <td style="width:160px;"><?php echo $form->labelEx($model, 'code'); ?></td>
                <td style="width:240px;">
                    <?php
                    echo $form->textField($model, 'code', array('size' => 3, 'maxlength' => 3));
                    if (isset($_GET['viewFrom'])) {
                        echo "<br>" . $form->error($model, 'code');
                    }
                    ?></td>
                <td><?php
                    if (!isset($_GET['viewFrom'])) {
                        echo "<br>" . $form->error($model, 'code');
                    }
                    ?></td>

            </tr>
        <?php } ?>


        <tr>
            <td style="width:160px;">&nbsp;</td>
            <td> <a class="btn btn-default" href="#" role="button" id="userDetails">+</a> Add Company Contact</td>
        </tr>

        <tr id="user_details_field">
            <td style="width:160px;">&nbsp;</td>
            <td><?php echo $form->textArea($model, 'user_details', array('size' => 50, 'placeholder'=>'User Details')); ?>

                <?php echo "<br>" . $form->error($model, 'user_details'); ?>
            </td>
        </tr>


        <tr>
            <td style="width:160px;">&nbsp;</td>
            <td><?php echo $form->textField($model, 'user_first_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>

                <?php echo "<br>" . $form->error($model, 'user_first_name'); ?>
            </td>
        </tr>

        <tr>
            <td style="width:160px;">&nbsp;</td>
            <td><?php echo $form->textField($model, 'user_last_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>

                <?php echo "<br>" . $form->error($model, 'user_last_name'); ?>
            </td>
        </tr>

        <tr>
            <td style="width:160px;">&nbsp;</td>
            <td><?php echo $form->textField($model, 'user_email', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email')); ?>

                <?php echo "<br>" . $form->error($model, 'user_email'); ?>
            </td>
        </tr>

        <tr>
            <td style="width:160px;">&nbsp;</td>
            <td><?php echo $form->textField($model, 'user_contact_number', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Contact Number')); ?>

                <?php echo "<br>" . $form->error($model, 'user_contact_number'); ?>
            </td>
        </tr>

    </table>


    <div class="row buttons " style="<?php if (isset($_GET['viewFrom'])) { ?>
        margin-left:180px;
    <?php
    } else {
        echo "text-align:right;";
    }
    ?>">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'createBtn', 'style' => 'height:30px;', 'class' => 'complete')); ?>
        <?php if (isset($_GET['viewFrom'])) { ?>

        <?php
        } else {
        if ($session['role'] != Roles::ROLE_SUPERADMIN) {
            ?>
            <button class="yiiBtn" id="modalBtn" style="padding:1.5px 6px;margin-top:-4.1px;height:30.1px;" data-target="#viewLicense" data-toggle="modal">View License Details</button>
        <?php } else { ?>
        <button class="yiiBtn actionForward" style="padding:2px 6px;margin-top:-4.1px;height:30.1px;" type='button' onclick="gotoLicensePage()">License Details</button>
            <?php
            }
            }
            ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<input type="hidden" id="viewFrom" value="<?php
if (isset($_GET['viewFrom'])) {
    echo "1";
} else {
    echo "0";
}
?>"/>
<script>

    function closeParent() {
        window.parent.dismissModal();
    }

    function gotoLicensePage() {
        window.location = 'index.php?r=licenseDetails/update&id=1';
    }


    $(document).ready(function() {

        $( "#user_details_field" ).hide();
        $("#userDetails").click(function(e) {
            e.preventDefault();
            $( "#user_details_field" ).toggle("slow");
        });

    });


</script>

<div class="modal hide fade" id="viewLicense" style="width:600px;">
    <div class="modal-header">
        <a data-dismiss="modal" class="close" id="dismissModal" >×</a>
        <br>
    </div>
    <div id="modalBody" style="padding:20px;">
        <?php
        echo LicenseDetails::model()->getLicenseDetails();
        ?>
    </div>

</div>


