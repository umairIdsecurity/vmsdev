<?php

$cs = Yii::app()->clientScript;
//$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/combodate.js');
//$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/moment.min.js');

$session = new CHttpSession;

$dataId = '';

if ($this->action->id == 'update') {
    $dataId = $_GET['id'];
}

$countryList = CHtml::listData(Country::model()->findAll(), 'id', 'name');
// set default country is Australia = 13

?>

<style>

    #addCompanyLink {
        width: 124px;
        height: 23px;
        padding-right: 0px;
        margin-right: 0px;
        padding-bottom: 0px;
        display: block;
    }

    .form-label {
        display: block;
        width: 200px;
        float: left;
        margin-left: 15px;
    }

    .ajax-upload-dragdrop {
        float:left !important;
        margin-top: -30px;
        background: url('<?php echo Yii::app()->controller->assetsBase; ?>/images/portrait_box.png') no-repeat center top;
        background-size:137px;
        height: 104px;
        width: 120px !important;
        padding: 87px 5px 12px 72px;
        margin-left: 20px !important;
        border:none;
    }

    .uploadnotetext {
        margin-top: 110px;
        margin-left: -80px;

    }

    #content h1 {
        color: #2f96b4;
        font-size: 18px;
        font-weight: bold;
        margin-left: 50px;
    }

    .required {
        padding-left: 10px;
    }

    .date_of_birth_class{
        width: 71.5px !important;
    }

</style>


<div data-ng-app="PwordForm">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id'                     => 'asic-applicant-form',
        'htmlOptions'            => array("name" => "registerform"),
        'enableAjaxValidation'   => true,
        'enableClientValidation' => true,
        'clientOptions'          => array(
            'validateOnSubmit' => true,
            'afterValidate'    => 'js:function(form, data, hasError){
                if (hasError) {
                    var currentYear = new Date().getFullYear();
                    var selectedYear = $(".year").val();

                    if (currentYear - selectedYear < 18) {
                        $("#Visitor_identification_type_em_").hide();
                        $("#Visitor_identification_document_no_em_").hide();
                        $("#Visitor_identification_document_expiry_em_").hide();

                        //remove item
                        delete data.Visitor_identification_document_expiry;
                        delete data.Visitor_identification_document_no;
                        delete data.Visitor_identification_type;
                    }

                }
                    hasError = false;
                   return afterValidate(form, data, hasError);
            }'
        ),
    ));
    ?>

    <input type="hidden" id="emailIsUnique" value="0"/>
  

    <div>

        <table id="addvisitor-table">
           
            <tr>
                <td>
                    
                    <table style="float:left;width:300px;">
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 15, 'placeholder' => 'First Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'first_name'); ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 15, 'placeholder' => 'Last Name')); ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'last_name'); ?>
                            </td>
                        </tr>
						<tr>
						  <?php echo $form->textField($model, 'given_name2', array('maxlength' => 50, 'placeholder' => 'Given Name(optional)' , 'class'=>'form-control input-sm')); ?>
						<?php echo $form->error($model, 'given_name2'); ?>
						</tr>
                        <tr>
                            <td class="birthdayDropdown">
                               <span>Date of Birth</span> <br/>
                                <?php $this->widget('EDatePicker', array(
                                    'model'=>$model,
                                    'attribute'=>'date_of_birth',
                                    'mode'=>'date_of_birth',
                                    'htmlOptions'=>[]
                                ));
                                ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'date_of_birth'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="37%">
                                 <?php echo $form->textField($model, "email", array("placeholder"=>"Email Address")) ?>
                                <span class="required">*</span>
                                <?php echo "<br>" . $form->error($model, 'email', array('style' => 'text-transform:none;')); ?>
                                <div style="" class="errorMessageEmail">A profile already exists for this email address.
                                </div>

                            </td>
                        </tr>
                        
                          
                            
                           
                        </table>
                        <div style="float:right; margin-right: 35px"><input type="submit" value="Save" name="yt0" id="submitFormVisitor" class="complete" style="margin-top: 15px;"/></div>
                    

                </td>
            </tr>
        </table>
        <input type="hidden" name="Visitor[visitor_status]" value=""
               style='display:none;' />
    </div>
    <?php $this->endWidget(); ?>
</div>

<input type="hidden" id="currentAction" value="<?php echo $this->action->id; ?>">
<input type="hidden" id="currentRoleOfLoggedInUser" value="">
<input type="hidden" id="currentlyEditedVisitorId" value="">

<script>

</script>




