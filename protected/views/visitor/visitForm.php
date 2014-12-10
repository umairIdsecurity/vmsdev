<?php
/* @var $this VisitController */
/* @var $visitModel Visit */
/* @var $form CActiveForm */
$session = new CHttpSession;
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register-visit-form',
        'action' => Yii::app()->createUrl('/visit/create'),
        'htmlOptions' => array("name" => "register-visit-form"),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
//        'clientOptions' => array(
//            'validateOnSubmit' => true,
//            'afterValidate' => 'js:function(form,data,hasError){
//                        if(!hasError){
//                            sendVisitForm();
//                                } else {
//                                sendVisitForm();
//                                }
//                                
//                        }'
//        ),
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
        <input name="Visit[visitor_type]" id="Visit_visitor_type" type="text" value="1">
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
        <?php echo $form->labelEx($visitModel, 'workstation'); ?>
        <?php echo $form->textField($visitModel, 'workstation'); ?>
        <?php echo $form->error($visitModel, 'workstation'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($visitModel, 'visit_status'); ?>
        <input name="Visit[visit_status]" id="Visit_visit_status" type="text" value="<?php
        if (isset($_GET['action'])) {
            echo "2";
        } else {
            echo "1";
        };
        ?>">
               <?php echo $form->error($visitModel, 'visit_status'); ?>
    </div>
    <?php if (!isset($_GET['action'])) { ?>
        <div class="row">
            <?php echo $form->labelEx($visitModel, 'date_in'); ?>
            <input name="Visit[date_in]" id="Visit_date_in" type="text" value="<?php echo date("d-m-Y"); ?>">
            <?php echo $form->error($visitModel, 'date_in'); ?>
        </div>
        <?php
        date_default_timezone_set('Asia/Manila');
        $time = date('H:i:s');
        ?>
        <div class="row">
            <?php echo $form->labelEx($visitModel, 'time_in'); ?>
            <input name="Visit[time_in]" id="Visit_time_in" type="text" value="<?php echo $time; ?>">
            <?php echo $form->error($visitModel, 'time_in'); ?>
        </div>

    <?php } ?>

    <div class="row buttons">
        <input type="submit" id="submitVisitForm" value="Add">
        <input type="button" value="Save and Continue" id="populateVisitFormFields" >
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<input type="text" style="display:none;" id="visitSessionRole" value="<?php echo $session['role'];?>">
<script>
    $(document).ready(function() {

    });
    function populateVisitFormFields() {
        $("#Visit_visitor").val($("#visitorId").val());
        $("#Visit_visitor_type").val($("#Visitor_visitor_type").val());
        $("#visitReasonFormField").val($("#Visit_reason").val());
        $("#Visit_visitor_status").val("1");
        if($("#visitSessionRole").val() == 7 || $("#visitSessionRole").val() == 8){
            $("#Visit_workstation").val($("#workstation").val());
        }
       

        if ($("#Visitor_visitor_type").val() == 1) { //if type is patient
            $("#Visit_host").val("");
            $("#Visit_patient").val($("#hostId").val());
            $("#submitVisitForm").delay(1000).click();
        } else {
            $("#Visit_patient").val("");
            $("#Visit_host").val($("#hostId").val());
            $("#submitVisitForm").delay(1000).click();
        }
    }

    function sendVisitForm() {
        var visitForm = $("#register-visit-form").serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo CHtml::normalizeUrl(array("visit/create")); ?>",
            data: visitForm,
            success: function(data) {
                //window.location = "index.php?r=visitor/admin";
              //  window.location = "index.php?r=visit/detail&id="+data.id;
            },
        });
    }
</script>
