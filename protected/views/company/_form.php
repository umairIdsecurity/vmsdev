
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
    <input type="hidden" id="Company_tenant" name="Company[tenant]" value="<?php echo $tenant; ?>">
    <input type="hidden" id="Company_tenant_agent" name="Company[tenant_agent]" value="<?php echo $tenantAgent; ?>">
    <table>
        <tr>
            <td style="width:160px;"><?php echo $form->labelEx($model, 'name'); ?></td>
            <td style="width:240px;">
                <?php
                echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150));
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
        <tr>
            <td><?php echo $form->labelEx($model, 'trading_name'); ?></td>
            <td><?php echo $form->textField($model, 'trading_name', array('size' => 60, 'maxlength' => 150)); ?></td>
            <td><?php echo $form->error($model, 'trading_name'); ?></td>
        </tr>
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
        <tr>
            <td><?php echo $form->labelEx($model, 'Upload Company Logo'); ?></td>
            <td id="uploadRow" >
                <input type="hidden" id="Company_logo" name="Company[logo]" 
                <?php
                if ($this->action->id == 'update') {
                    echo "disabled";
                }
                ?> value="<?php echo $model['logo']; ?>">
                <div class="photoDiv companyPhotoDiv" <?php
                if ($model['logo'] == NULL) {
                    echo "style='display:none !important;'";
                }
                ?>>
                    <?php if ($dataId != '') { ?><img id='companyLogo' src="<?php echo Yii::app()->request->baseUrl . "/" . $model->getCompanyLogo($dataId); ?>"/>
                    <?php } else { ?> 
                        <img id='companyLogo' src="<?php
                        if (isset($_POST['Company']['logo'])) {
                            echo Yii::app()->request->baseUrl . "/" . $model->getPhotoRelativePath($_POST['Company']['logo']);
                        }
                        ?>

                             " />
                         <?php } ?>
                </div>
                <?php require_once(Yii::app()->basePath . '/draganddrop/index.php'); ?>
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
            <td><?php
                echo $form->textField($model, 'email_address', array('size' => 50, 'maxlength' => 50));
                if (isset($_GET['viewFrom'])) {
                    echo "<br>" . $form->error($model, 'email_address');
                }
                ?>
            </td>
            <td><?php
                if (!isset($_GET['viewFrom'])) {
                    echo $form->error($model, 'email_address');
                }
                ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'office_number'); ?></td>
            <td><?php
                echo $form->textField($model, 'office_number');
                if (isset($_GET['viewFrom'])) {
                    echo "<br>" . $form->error($model, 'office_number');
                }
                ?></td>
            <td><?php
                if (!isset($_GET['viewFrom'])) {
                    echo $form->error($model, 'office_number');
                }
                ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'mobile_number'); ?></td>
            <td><?php
                echo $form->textField($model, 'mobile_number');
                if (isset($_GET['viewFrom'])) {
                    echo "<br>" . $form->error($model, 'mobile_number');
                }
                ?></td>
            <td><?php
                if (!isset($_GET['viewFrom'])) {
                    echo "<br>" . $form->error($model, 'mobile_number');
                }
                ?></td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'website'); ?></td>
            <td><?php
                echo $form->textField($model, 'website', array('size' => 50, 'maxlength' => 50));
                if (isset($_GET['viewFrom'])) {
                    echo "<br>" . $form->error($model, 'website');
                }
                ?></td>
            <td><?php
                if (!isset($_GET['viewFrom'])) {
                    echo "<br>" . $form->error($model, 'website');
                }
                ?></td>
        </tr>

    </table>


    <div class="row buttons " style="<?php if (isset($_GET['viewFrom'])) { ?>
             margin-left:400px;
         <?php
         } else {
             echo "text-align:right;";
         }
         ?>">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Add' : 'Save', array('id' => 'createBtn', 'style' => 'height:30px;','class'=>'complete')); ?>
        <?php if (isset($_GET['viewFrom'])) { ?>
            <input class="neutral yiiBtn" type='button' value='Cancel' onclick='closeParent()' style="height:30px;"></input>
            <?php
        } else {
            if ($session['role'] != Roles::ROLE_SUPERADMIN) {
                ?>
                <button class="yiiBtn" id="modalBtn" style="padding:1.5px 6px;margin-top:-4.1px;height:30.1px;" data-target="#viewLicense" data-toggle="modal">View License Details</button> 
                <?php } else { ?>
                <button class="yiiBtn actionForward" style="padding:2px 6px;margin-top:-4.1px;height:30.1px;" type='button' onclick="gotoLicensePage()">License Details</bitton>
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

    $(document).ready(function() {
        $("#company-form").submit(function(event) {
            event.preventDefault();

            var websiteUrl = $("#Company_website").val();
            
            if (websiteUrl != '')
            {
                var httpString = websiteUrl.substr(0, 6);
                if (httpString != 'http:/') {
                    $("#Company_website").val("http://" + websiteUrl);
                    $(this).unbind('submit').submit();
                } else {
                    $(this).unbind('submit').submit();
                }
            } else {
                $(this).unbind('submit').submit()
            }


        });
        $("#createBtn").click(function(e) {
            if ($("#viewFrom").val() == '1') {
                if ($("#Company_logo").val() != '') {
                    //alert("has logo");
                    window.parent.document.getElementById('companyModalIframe').style.height = "1015px";
                } else {
                    // alert("no logo");
                    window.parent.document.getElementById('companyModalIframe').style.height = "850px";
                }

            }
        });


    });

    function closeParent() {
        window.parent.dismissModal();
    }

    function gotoLicensePage() {
        window.location = 'index.php?r=licenseDetails/update&id=1';
    }



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


