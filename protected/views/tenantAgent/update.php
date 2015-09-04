<h1 style="margin-left: 70px">Edit Tenant Agent</h1>
<?php
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */

$session = new CHttpSession;
$currentRoleinUrl = '';
if (isset($_GET['role'])) {
    $currentRoleinUrl = $_GET['role'];
}

$currentlyEditedUserId = '';
if (isset($_GET['id'])) {
    $currentlyEditedUserId = $_GET['id'];
}

$currentLoggedUserId = $session['id'];

?>

<style type="text/css">
    .required{ padding-left:5px;}
    .errorMessage{
         margin-bottom: 9px;
        margin-top: -5px;
    }
</style>
<div class="form">

    <?php
        $form = $this->beginWidget('CActiveForm', array(
        'id' => 'tenant-agent-edit-form',
            'enableAjaxValidation'=>true,
            'enableClientValidation' => false,
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
        //echo $form->errorSummary($model);
    }
    ?>


    <?php echo $form->errorSummary($model); ?>
    <table>
        <tr>
            <td style="vertical-align: top; float:left; width:300px;">
                <?php echo $form->hiddenField($model, 'role',array('value'=> $session['role'])); ?>
                <div class="password-border">
                    <table>
                        <tbody>
                        <tr>
                            <td><strong>Tenant Agent</strong></td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td><?php 
            
                                echo  $form->dropDownList($model, 'tenant_name',  CHtml::listData($allTenant, 'id0.id', 'id0.name'), array('options' => array($TenantModel->tenant_id=>array('selected'=>true))) );
                            ?>
                                <span class="required">*</span>

                                <?php echo "<br>" . $form->error($model, 'tenant_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->textField($model, 'tenant_agent_name', array('value'=>$TenantModel->id0['name'], 'size' => 50, 'maxlength' => 50,'placeholder'=>'Tenant Agent')); ?>
                                <span class="required">*</span>

                                <?php echo "<br>" . $form->error($model, 'tenant_agent_name'); ?>
                            </td>
                        </tr>
                       
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>



    <div class="row buttons " style="<?php if (isset($_GET['viewFrom'])) { ?>
        margin-left:173px;
    <?php
    } else {
        echo "text-align:right;";
    }
    ?>">
        <?php echo CHtml::SubmitButton('Save', array('id' => 'createBtn', 'style' => 'height:30px;margin-right:30px;', 'class' => 'complete')); ?>
        <?php if (isset($_GET['viewFrom'])) { ?>

        <?php
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

