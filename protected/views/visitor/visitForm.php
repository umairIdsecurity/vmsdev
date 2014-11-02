<?php
/* @var $this VisitController */
/* @var $visitModel Visit */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register-visit-form',
        'action' => Yii::app()->createUrl('/visit/create'),
        'htmlOptions' => array("name" => "register-visit-form"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
                        if(!hasError){
                            sendVisitForm();
                                } else {
                                sendVisitForm();
                                }
                                
                        }'
        ),
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($visitModel); ?>

    <div class="row">
        <?php echo $form->labelEx($visitModel, 'visitor'); ?>
        <?php echo $form->textField($visitModel, 'visitor', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($visitModel, 'visitor'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($visitModel, 'visitor_type'); ?>
        <?php echo $form->textField($visitModel, 'visitor_type', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($visitModel, 'visitor_type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($visitModel, 'reason'); ?>
        <?php echo $form->textField($visitModel, 'reason', array('size' => 20, 'maxlength' => 20, 'id' => 'visitReasonFormField')); ?>
        <?php echo $form->error($visitModel, 'reason'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($visitModel, 'visitor_status'); ?>
        <?php echo $form->textField($visitModel, 'visitor_status', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($visitModel, 'visitor_status'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($visitModel, 'host'); ?>
        <?php echo $form->textField($visitModel, 'host', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($visitModel, 'host'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($visitModel, 'patient'); ?>
        <?php echo $form->textField($visitModel, 'patient', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->error($visitModel, 'patient'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($visitModel, 'card_type'); ?>
        <?php echo $form->textField($visitModel, 'card_type'); ?>
        <?php echo $form->error($visitModel, 'card_type'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($visitModel, 'visit_status'); ?>
        <input name="Visit[visit_status]" id="Visit_visit_status" type="text" value="2">
        <?php echo $form->error($visitModel, 'visit_status'); ?>
    </div>

    <div class="row buttons">
        <input type="submit" id="submitVisitForm" value="Add">
        <input type="button" value="Save and Continue" id="populateVisitFormFields" >
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<script>
    $(document).ready(function() {
        
    });
    function populateVisitFormFields() {
        $("#Visit_visitor").val($("#visitorId").val());
        $("#Visit_visitor_type").val($("#Visitor_visitor_type").val());
        $("#visitReasonFormField").val($("#Visit_reason").val());
        $("#Visit_visitor_status").val("1");

        if ($("#Visitor_visitor_type").val() == 1) { //if type is patient
            $("#Visit_host").val("");
            $("#Visit_patient").val($("#hostId").val());
            $("#submitVisitForm").click();
        } else {
            $("#Visit_patient").val("");
            $("#Visit_host").val($("#hostId").val());
            $("#submitVisitForm").click();
        }

    }

    function sendVisitForm() {
        var visitForm = $("#register-visit-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visit/create")); ?>",
            data: visitForm,
            success: function(data) {
                window.location = "index.php?r=visitor/admin";
            },
        });
    }
</script>