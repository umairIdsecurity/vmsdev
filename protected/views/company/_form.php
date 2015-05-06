
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
            <td style="width:160px;"></td>
            <td style="width:240px;">
                <?php
                echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150 , 'placeholder'=>'Company Name'));
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
            <td style="width:160px;"></td>
            <td style="width:240px;">
                <?php
                echo $form->textField($model, 'code', array('size' => 3, 'maxlength' => 3 , 'placeholder'=>'Company Code'));
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
            <td></td>
            <td><?php echo $form->textField($model, 'contact', array('size' => 60, 'maxlength' => 100 , 'placeholder'=> 'First Name')); ?></td>
            <td><?php echo $form->error($model, 'contact'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $form->textField($model, 'billing_address', array('size' => 60, 'maxlength' => 150 , 'placeholder'=> 'Last Name')); ?></td>
            <td><?php echo $form->error($model, 'billing_address'); ?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php
                echo $form->textField($model, 'email_address', array('size' => 50, 'maxlength' => 50 , 'placeholder'=> 'Email Address'));
                if (isset($_GET['viewFrom'])) {
                    echo "<br>" . $form->error($model, 'email_address',array('style'=>'text-transform:none;'));
                }
                ?>
            </td>
            <td><?php
                if (!isset($_GET['viewFrom'])) {
                    echo $form->error($model, 'email_address', array('style'=>'text-transform:none;'));
                }
                ?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php
                echo $form->textField($model, 'office_number', array('placeholder'=> 'Contact Number'));
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
            <td></td>
            <td><?php
                echo $form->textField($model, 'mobile_number' , array('placeholder'=>'Mobile nUmber'));
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


    </table>


    <div class="row buttons " style="<?php if (isset($_GET['viewFrom'])) { ?>
             margin-left:180px;
             <?php
         } else {
             echo "text-align:right;";
         }
         ?>">
             <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('id' => 'createBtn', 'style' => 'height:30px', 'class' => 'complete')); ?>

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
                if (websiteUrl.substr(0, 3) == 'www') {
                    //alert(websiteUrl.substr(0, 3));
                    if (websiteUrl.match(new RegExp('\\.', 'g')).length < 2) {
                        $("#websiteErrorMessage").show();
                    } else {
                        $("#websiteErrorMessage").hide();
                        if (httpString != 'http:/') {
                            $("#Company_website").val("http://" + websiteUrl);
                            $(this).unbind('submit').submit();
                        } else {
                            $(this).unbind('submit').submit();
                        }
                    }
                } else {
                    if (httpString != 'http:/') {
                        $("#Company_website").val("http://" + websiteUrl);
                        $(this).unbind('submit').submit();
                    } else {
                        $(this).unbind('submit').submit();
                    }
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


