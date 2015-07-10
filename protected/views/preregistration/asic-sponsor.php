<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/24/15
 * Time: 2:59 AM
 */
?>
<style type="text/css">
    #search_asic_error{
        display: none;
    }
    #asic_search_result{
        display: none;
    }

    #loader{
        display: none;
    }
    .loader {
        margin: 60px auto;
        font-size: 10px;
        position: relative;
        text-indent: -9999em;
        border-top: 1.1em solid rgba(153, 153, 153, 0.20);
        border-right: 1.1em solid rgba(153, 153, 153, 0.20);
        border-bottom: 1.1em solid rgba(153, 153, 153, 0.20);
        border-left: 1.1em solid #428bca;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation: load8 1.1s infinite linear;
        animation: load8 1.1s infinite linear;
    }
    .loader,
    .loader:after {
        border-radius: 50%;
        width: 10em;
        height: 10em;
    }
    @-webkit-keyframes load8 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes load8 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    #asic-notification{
        display: none;
    }
    .bg-info{
        padding: 7px;
    }

</style>
<div class="page-content">
    <h1 class="text-primary title">ADD / FIND ASIC SPONSOR</h1>

    <?php

    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'add-asic-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true
        ),
        'htmlOptions'=>array(
        'class'=> 'declarations'
    )
    ));
    ?>

    <div class="form-create-login">

        <div class="row form-group">

            <div class="col-md-8">
                <?php  echo CHtml::textField('search_asic_box' , '',
                    array(
                        'class'=>'form-control input-lg',
                        'placeholder'=>'First Name or email'
                    )
                );
                ?>
                <div id="search_asic_error" class="errorMessage">Please type something on search box</div>
                <?php
                echo CHtml::hiddenField('base_url',Yii::app()->getBaseUrl(true));
                ?>
            </div>
            <div class="col-md-4">
                <?php
                echo CHtml::tag('button', array(
                    'id'=>'search_asic_btn',
                    'type'=>'button',
                    'class' => 'btn btn-primary btn-next btn-lg'
                ), 'Search ASIC');
                ?>
            </div>

        </div>
        <div class="loader" id="loader">Loading...</div>

        <p id="asic-notification" class="bg-info">No Record Found</p>
        <table class="table table-striped" id="asic_search_result">
            <thead>
            <tr>
                <th></th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Company</th>
            </tr>
            </thead>
            <tbody id="showresults">
            </tbody>
        </table>

        <div class="form-group">
            <?php echo $form->textField($model, 'first_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'First Name' , 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'first_name'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model, 'last_name', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Last Name' , 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'last_name'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model, 'asic_no', array('size' => 10, 'maxlength' => 50, 'placeholder' => 'ASIC no.', 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'asic_no'); ?>
        </div>

        <div class="row form-group">
            <div class="col-md-6">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'       => $model,
                    'attribute'   => 'asic_expiry',
                    'options'     => array(
                        'dateFormat' => 'dd-mm-yy',
                    ),
                    'htmlOptions' => array(
                        'size'        => '0',
                        'maxlength'   => '10',
                        'placeholder' => 'Expiry',
                        'class' => 'form-control input-lg'
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'asic_expiry'); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->textField($model, 'contact_number', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Mobile Number', 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'contact_number'); ?>

        </div>

        <div class="form-group">
            <?php echo $form->textField($model, 'email', array('size' => 50, 'maxlength' => 50, 'placeholder' => 'Email', 'class'=>'form-control input-lg')); ?>
            <?php echo $form->error($model, 'email'); ?>

        </div>
        <div class="form-group">
            <label class="checkbox">
                <?php echo $form->checkBox($model,'is_asic_verification'); ?>
                <span class="checkbox-style"></span>
                <p class="text-success">
                    Request ASIC Sponsor Verification
                </p>
            </label>
            <?php echo $form->error($model,'is_asic_verification'); ?>
        </div>

    </div>

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/visitReason")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
        </div>

        <div class="col-md-offset-10 col-sm-offset-10 col-xs-offset-9 col-md-1 col-sm-1 col-xs-1">
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

<script type="text/javascript">

    $(document).ready(function() {

        $('#search_asic_box').on('input', function() {
            $("#search_asic_error").hide();
            $("#asic_search_result").hide();
            $("#asic-notification").hide();
        });

        $('#search_asic_btn').click(function(event) {
            event.preventDefault();

            var search = $("#search_asic_box").val();
            var base_url = $("#base_url").val();

            if (search.length > 0) {
                $("#loader").show();
                var search_value = 'search_value=' + search;

                $.ajax({
                    url: base_url + '/index.php/preregistration/ajaxAsicSearch',
                    type: 'POST',
                    data: search_value,
                    success: function(data) {

                        if(data == 'No Record'){
                            $("#asic-notification").show();
                        }
                        else{
                            $("#asic_search_result").show();
                            $('#showresults').html(data);
                        }

                        $("#loader").hide();
                    }

                });

            }
            else{
                $("#search_asic_error").show();
            }

        });

    });

</script>