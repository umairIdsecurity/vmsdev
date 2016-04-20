
<div class="page-content">

    <div id="menu">
        <div class="row items">
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/visitHistory'); ?>">Visit History</a></div>
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/verifications'); ?>">Verifications</a></div>
        </div>
    </div>

    <h1 class="text-primary title">VERIFY VIC HOLDER</h1>
    <?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'verify-declaration-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=> 'declarations'
        )
    ));
    ?>

    <br>


        <?php   
/*            if($model->hasErrors('declaration1'))
            {
               echo $form->error($model,'declaration1'); 
            }
            elseif($model->hasErrors('declaration2')) {
                echo $form->error($model,'declaration2'); 
            }
            elseif($model->hasErrors('declaration3')) {
                echo $form->error($model,'declaration3'); 
            }
            else{
                echo $form->error($model,'declaration4'); 
            }*/
        ?>


        <h3 class="text-primary">Declarations</h3>
        <h5>I agree by ticking the boxes below:</h5>

        <div class="form-group">

            <label class="checkbox">
                <?php //echo $form->checkBox($model,'declaration1'); ?>
                <input id="toggleCheckbox1" name="name1" type="checkbox" value="0">
                <span class="checkbox-style"></span>I confirm that the applicant and my details are correct, I have read, understood and agree to ensure that the applicant will abide by the conditions applicable to the use of the Visitors Identification Card. 
            </label>


            <label class="checkbox">
                <?php //echo $form->checkBox($model,'declaration2'); ?>
                <input id="toggleCheckbox2" name="name1" type="checkbox" value="0">
                <span class="checkbox-style"></span>I understand that it is an offence to escort/sponsor someone airside without a valid operational reason for them to acquire access.
            </label>

            <label class="checkbox">
                <?php //echo $form->checkBox($model,'declaration3'); ?>
                <input id="toggleCheckbox3" name="name3" type="checkbox" value="0">
                <span class="checkbox-style"></span>I note that they must be under my direct supervision at all times whilst they are airside.
            </label> 

             <label class="checkbox">
                <?php //echo $form->checkBox($model,'declaration4'); ?>
                <input id="toggleCheckbox4" name="name4" type="checkbox" value="0">
                <span class="checkbox-style"></span>I request that a VIC be issued to the applicant for the areas and reason indicated in the section above.
            </label> 

        </div>

        <br>

        <div id="errorDiv" style="display:none;color:red;">
            Mark all Declarations to proceed
        </div>

    <div class="row">
        <div class="col-sm-5"></div>
        <div class="col-sm-2">
            <?php
                /*echo CHtml::tag('button', array(
                    'type'=>'submit',
                    'class' => 'btn btn-primary btn-next'
                ), 'Send to PAPL');*/
            ?>
            <a id="sendTo" href="javascript:;" class="btn btn-primary btn-next">Send to Airport <span class="glyphicon glyphicon-chevron-right"></span></a>
                    
        </div>
        <div class="col-sm-5"></div>
    </div>

    <?php $this->endWidget(); ?>
</div>

<script>
    $("#toggleCheckbox1").on("click",function(e){
        if(this.checked){
            $(this).val(1);
            if((parseInt($("#toggleCheckbox2").val()) == 1) && (parseInt($("#toggleCheckbox3").val()) == 1) && (parseInt($("#toggleCheckbox4").val()) == 1)){
                $("#sendTo").attr("href","<?php echo Yii::app()->createUrl('preregistration/verifyDeclarations')?>");
                $("#errorDiv").hide();
            }else{
                $("#errorDiv").show();
            }
        }else{
            $(this).val(0);
            $("#sendTo").attr("href","javascript:;");
            $("#errorDiv").show();
        }
    });

    $("#toggleCheckbox2").on("click",function(e){
        if(this.checked){
            $(this).val(1);
            if((parseInt($("#toggleCheckbox1").val()) == 1) && (parseInt($("#toggleCheckbox3").val()) == 1) && (parseInt($("#toggleCheckbox4").val()) == 1)){
                $("#sendTo").attr("href","<?php echo Yii::app()->createUrl('preregistration/verifyDeclarations')?>");
                $("#errorDiv").hide();
            }else{
                $("#errorDiv").show();
            }
        }else{
            $(this).val(0);
            $("#sendTo").attr("href","javascript:;");
            $("#errorDiv").show();
        }
    });

    $("#toggleCheckbox3").on("click",function(e){
        if(this.checked){
            $(this).val(1);
            if((parseInt($("#toggleCheckbox1").val()) == 1) && (parseInt($("#toggleCheckbox2").val()) == 1) && (parseInt($("#toggleCheckbox4").val()) == 1)){
                $("#sendTo").attr("href","<?php echo Yii::app()->createUrl('preregistration/verifyDeclarations')?>");
                $("#errorDiv").hide();
            }else{
                $("#errorDiv").show();
            }
        }else{
            $(this).val(0);
            $("#sendTo").attr("href","javascript:;");
            $("#errorDiv").show();
        }
    });

    $("#toggleCheckbox4").on("click",function(e){
        if(this.checked){
            $(this).val(1);
            if((parseInt($("#toggleCheckbox1").val()) == 1) && (parseInt($("#toggleCheckbox2").val()) == 1) && (parseInt($("#toggleCheckbox3").val()) == 1)){
                $("#sendTo").attr("href","<?php echo Yii::app()->createUrl('preregistration/verifyDeclarations')?>");
                $("#errorDiv").hide();
            }else{
                $("#errorDiv").show();
            }
        }else{
            $(this).val(0);
            $("#sendTo").attr("href","javascript:;");
            $("#errorDiv").show();
        }
    });

    $("#sendTo").on("click",function(e){
        var checkboxVal1 = parseInt($("#toggleCheckbox1").val());
        var checkboxVal2 = parseInt($("#toggleCheckbox2").val());
        var checkboxVal3 = parseInt($("#toggleCheckbox3").val());
        var checkboxVal4 = parseInt($("#toggleCheckbox4").val());
        
        if(checkboxVal1 == 0 || checkboxVal2 == 0 || checkboxVal3 == 0 || checkboxVal4 == 0){
            $("#errorDiv").show();
        }else{
            $("#errorDiv").hide();
        }
    });


</script>