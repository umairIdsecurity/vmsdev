
<?php
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */

//print_r($model->attributes);exit;

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
        'enableClientValidation' => true,
        'clientOptions'=>array(
                'validateOnSubmit'=>true,
                )
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
    <input type="hidden" id="user_role" name="user_role" value="<?php echo $session['role'];  ?>" />

    <table>
        <tr>
            <td style="width:160px;">Tenant Name</td>
            <td style="width:240px;">
                <?php
                echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150 , 'placeholder' => 'Tenant Name' ));
                if (isset($_GET['viewFrom'])) {
                    echo "<br>" . $form->error($model, 'name');
                }
                ?>
                <?php
                if (!isset($_GET['viewFrom'])) {
                    echo $form->error($model, 'name');
                }
                ?>
            </td>


        </tr>

        <!--WangFu Modified-->
        <?php if ($session['role'] != Roles::ROLE_ADMIN) {?>
            <tr>
                <td style="width:160px;">Tenant Code</td>
                <td style="width:240px;">
                    <?php
                    echo $form->textField($model, 'code', array('size' => 3, 'maxlength' => 3, 'placeholder' => 'Tenant Code'));
                    if (isset($_GET['viewFrom'])) {
                        echo "<br>" . $form->error($model, 'code');
                    }
                    ?>
                    <?php
                    if (!isset($_GET['viewFrom'])) {
                        echo "<br>" . $form->error($model, 'code');
                    }
                    ?></td>
            </tr>
        <?php } ?>


        <!--<tr class="user_fields">
            <td style="width:160px;">&nbsp;</td>
            <td><?php //echo $form->textField($model, 'user_first_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'First Name')); ?>

                <?php //echo "<br>" . $form->error($model, 'user_first_name'); ?>
            </td>
        </tr>

        <tr class="user_fields">
            <td style="width:160px;">&nbsp;</td>
            <td><?php //echo $form->textField($model, 'user_last_name', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Last Name')); ?>

                <?php //echo "<br>" . $form->error($model, 'user_last_name'); ?>
            </td>
        </tr>-->

        <tr class="user_fields">
            <td style="width:160px;">Email Address</td>
            <td><?php echo $form->textField($model, 'email_address', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Email')); ?>

                <?php echo "<br>" . $form->error($model, 'email_address'); ?>
            </td>
        </tr>

        <tr class="user_fields">
            <td style="width:160px;">Contact number</td>
            <td><?php echo $form->textField($model, 'mobile_number', array('size' => 50, 'maxlength' => 50,'placeholder'=>'Contact Number')); ?>

                <?php echo "<br>" . $form->error($model, 'mobile_number'); ?>
            </td>
        </tr>

</div>

</table>


<div class="row buttons " style="<?php if (isset($_GET['viewFrom'])) { ?>
    margin-left:173px;
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


<div class="page-header">
    <h1>Organisation contacts</h1>
</div>
<?php if (isset($contacts) && !empty($contacts)): ?>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>User</th>
            <th>Email</th>
            <th>Number</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($contacts as $contact): ?>
            <tr>
                <td><?php echo $contact->getFullName($contact->id); ?></td>
                <td><?php echo $contact->email; ?></td>
                <td><?php echo $contact->contact_number; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

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

        var default_field = $("#is_user_field").attr('value');

        if(default_field==""){
            $( ".user_fields" ).hide();
        }
        else{
            $( ".user_fields" ).show();
        }



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


