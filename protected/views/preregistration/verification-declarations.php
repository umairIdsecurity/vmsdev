
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
            if($model->hasErrors('declaration1'))
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
            }
        ?>


        <h3 class="text-primary">Declarations</h3>
        <h5>I agree by ticking the boxes below:</h5>

        <div class="form-group">

            <label class="checkbox">
                <?php echo $form->checkBox($model,'declaration1'); ?>
                <span class="checkbox-style"></span>I confirm that the applicant and my details are correct, I have read, understood and agree to ensure that the applicant will abide by the conditions applicable to the use of the Visitors Identification Card. 
            </label>


            <label class="checkbox">
                <?php echo $form->checkBox($model,'declaration2'); ?>
                <span class="checkbox-style"></span>I understand that it is an offence to escort/sponsor someone airside without a valid operational reason for them to acquire access.
            </label>

            <label class="checkbox">
                <?php echo $form->checkBox($model,'declaration3'); ?>
                <span class="checkbox-style"></span>I note that they must be under my direct supervision at all times whilst they are airside.
            </label> 

             <label class="checkbox">
                <?php echo $form->checkBox($model,'declaration4'); ?>
                <span class="checkbox-style"></span>I request that a VIC be issued to the applicant for the areas and reason indicated in the section above.
            </label> 

        </div>

    <div class="row">
        <div class="col-sm-5"></div>
        <div class="col-sm-2">
            <?php
                echo CHtml::tag('button', array(
                    'type'=>'submit',
                    'class' => 'btn btn-primary btn-next'
                ), 'Send to PAPL');
            ?>
        </div>
        <div class="col-sm-5"></div>
    </div>

    <?php $this->endWidget(); ?>
</div>