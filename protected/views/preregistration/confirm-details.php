<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/17/15
 * Time: 10:43 AM
 */

$cs = Yii::app()->clientScript;
$cs->registerScriptFile(Yii::app()->controller->assetsBase . '/js/script-birthday.js');

$countryList = CHtml::listData(Country::model()->findAll(array(
    "order" => "name asc",
    "group" => "name"
)), 'id', 'name');
?>

<div class="page-content">
    <h1 class="text-primary title">CONFIRM DETAILS</h1>
    <div class="bg-gray-lighter form-info">Please confirm if the details below are correct and edit where necessary.</div>
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'confirm-details-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'afterValidate'    => 'js:function(form, data, hasError){ return afterValidate(form, data, hasError); }'
        ),
        'htmlOptions'=>array(
            'class'=> 'form-comfirm-detail'
        )
    ));
    ?>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'First Name' , 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Last Name' , 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'last_name'); ?>
                </div>

                <div class="row form-group">
                    <span class="text-primary col-xs-12">DATE OF BIRTH</span>

                    <input type="hidden" id="dateofBirthBreakdownValueYear"
                           value="<?php echo date("Y", strtotime($model->date_of_birth)); ?>">
                    <input type="hidden" id="dateofBirthBreakdownValueMonth"
                           value="<?php echo date("n", strtotime($model->date_of_birth)); ?>">
                    <input type="hidden" id="dateofBirthBreakdownValueDay"
                           value="<?php echo date("j", strtotime($model->date_of_birth)); ?>">

                    <div class="col-xs-4">
                        <select id="fromDay" name="Registration[birthdayDay]" class='daySelect form-control input-lg'></select>
                    </div>
                    <div class="col-xs-4">
                        <select id="fromMonth" name="Registration[birthdayMonth]" class='monthSelect form-control input-lg'></select>
                    </div>
                    <div class="col-xs-4">
                        <select id="fromYear" name="Registration[birthdayYear]" class='yearSelect form-control input-lg'></select>
                    </div>


                    <?php echo $form->error($model, 'date_of_birth'); ?>

                </div>
                <div class="form-group">
                    <?php echo $form->dropDownList($model, 'identification_type', Visitor::$IDENTIFICATION_TYPE_LIST, array('prompt' => 'Identification Type' , 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'identification_type'); ?>

                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'identification_document_no', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Document No.', 'class'=>'form-control input-lg')); ?>
                    <?php echo "<br>" . $form->error($model, 'identification_document_no'); ?>
                </div>
                <div class="form-group">
                    <?php
                    echo $form->dropDownList($model, 'identification_country_issued', $countryList, array('empty' => 'Country of Issue', 'class'=>'form-control input-lg' , 'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'identification_country_issued'); ?>

                </div>
                <div class="row form-group">
                    <span class="text-primary col-xs-12">EXPIRY</span>
                    <div class="col-md-6">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model'       => $model,
                            'attribute'   => 'identification_document_expiry',
                            'options'     => array(
                                'dateFormat' => 'dd-mm-yy',
                            ),
                            'htmlOptions' => array(
                                'size'        => '0',
                                'maxlength'   => '10',
                                'placeholder' => 'Expiry',
                                /*'style'       => 'width: 80px;',*/
                                'class' => 'form-control input-lg'
                            ),
                        ));
                        ?>
                        <?php echo $form->error($model, 'identification_document_expiry'); ?>
                    </div>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="row form-group">
                    <div class="col-xs-5">
                        <?php echo $form->textField($model, 'contact_unit', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Unit / flat no.', 'class'=>'form-control input-lg')); ?>
                        <?php echo $form->error($model, 'contact_unit'); ?>

                    </div>
                    <div class="col-xs-7">
                        <?php echo $form->textField($model, 'contact_street_no', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street No.', 'class'=>'form-control input-lg')); ?>
                        <?php echo $form->error($model, 'contact_street_no'); ?>
                    </div>

                </div>
                <div class="row form-group form-group-custom">
                    <div class="col-xs-7">
                        <?php echo $form->textField($model, 'contact_street_name', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Street Name', 'class'=>'form-control input-lg')); ?>
                        <?php echo "<br>" . $form->error($model, 'contact_street_name'); ?>
                    </div>
                    <div class="col-xs-5">
                        <?php echo $form->dropDownList($model, 'contact_street_type', Visitor::$STREET_TYPES, array('empty' => 'Type', 'class'=>'form-control input-lg')); ?>
                        <?php echo $form->error($model, 'contact_street_type'); ?>
                    </div>
                </div>
                <div class="form-group form-group-custom">
                    <?php echo $form->textField($model, 'contact_suburb', array('size' => 15, 'maxlength' => 50, 'placeholder' => 'Suburb' , 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'contact_suburb'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'contact_postcode', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'Postcode', 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'contact_postcode'); ?>
                </div>
                <div class="form-group form-group-custom">
                    <?php echo $form->dropDownList($model, 'contact_state', Visitor::$AUSTRALIAN_STATES, array('empty' => 'State', 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'contact_state'); ?>

                </div>
                <div class="form-group form-group-custom">

                    <?php
                    echo $form->dropDownList($model, 'contact_country', $countryList,
                        array('prompt' => 'Country', 'class'=>'form-control input-lg',
                            'options' => array(Visitor::AUSTRALIA_ID => array('selected' => 'selected'))));
                    ?>
                    <?php echo $form->error($model, 'contact_country'); ?>

                </div>
                <div class="form-group">
                    <?php echo $form->textField($model, 'contact_number', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Mobile Number', 'class'=>'form-control input-lg')); ?>
                    <?php echo $form->error($model, 'contact_number'); ?>

                </div>
            </div>
        </div>

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/registration")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
        </div>

        <div class="col-md-offset-10 col-sm-offset-10 col-xs-offset-7 col-md-1 col-sm-1 col-xs-1">
            <?php
            echo CHtml::tag('button', array(
                'type'=>'submit',
                'class' => 'btn btn-primary btn-next'
            ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
            ?>

        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>



<script>

    function afterValidate(form, data, hasError) {
        var dt = new Date();
        if(dt.getFullYear()< $("#fromYear").val()) {
            $("#Registration_date_of_birth_em_").show();
            $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
            return false;
        }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1)< $("#fromMonth").val()) {
            $("#Registration_date_of_birth_em_").show();
            $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
            return false;
        }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1) == $("#fromMonth").val() && dt.getDate() <= $("#fromDay").val() ) {
            $("#Registration_date_of_birth_em_").show();
            $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
            return false;
        }

    }

    $(document).ready(function () {

        $('#fromDay').on('change', function () {
            var dt = new Date();

            if(dt.getFullYear()< $("#fromYear").val()) {
                $("#Registration_date_of_birth_em_").show();
                $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1)< $("#fromMonth").val()) {
                $("#Registration_date_of_birth_em_").show();
                $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1) == $("#fromMonth").val() && dt.getDate() <= $("#fromDay").val() ) {
                $("#Registration_date_of_birth_em_").show();
                $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else{
                $("#Registration_date_of_birth_em_").hide();
            }
        });

        $('#fromMonth').on('change', function () {

            var dt = new Date();

            if(dt.getFullYear()< $("#fromYear").val()) {
                $("#Registration_date_of_birth_em_").show();
                $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1)< $("#fromMonth").val()) {
                $("#Registration_date_of_birth_em_").show();
                $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1) == $("#fromMonth").val() && dt.getDate() <= $("#fromDay").val() ) {
                $("#Registration_date_of_birth_em_").show();
                $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else{
                $("#Registration_date_of_birth_em_").hide();
            }

        });


        $('#fromYear').on('change', function () {
            var dt = new Date();

            if(dt.getFullYear()< $("#fromYear").val()) {
                $("#Registration_date_of_birth_em_").show();
                $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1)< $("#fromMonth").val()) {
                $("#Registration_date_of_birth_em_").show();
                $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else if(dt.getFullYear() == $("#fromYear").val() &&(dt.getMonth()+1) == $("#fromMonth").val() && dt.getDate() <= $("#fromDay").val() ) {
                $("#Registration_date_of_birth_em_").show();
                $("#Registration_date_of_birth_em_").html('Please update your Date of Birth');
                return false;
            }else{
                $("#Registration_date_of_birth_em_").hide();
            }
        });


    });



</script>