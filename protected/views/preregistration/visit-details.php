<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 7/22/15
 * Time: 7:10 PM
 */


?>

<div class="page-content">
    <h1 class="text-primary title">LOG VISIT DETAILS</h1>
    <div class="bg-gray-lighter form-info">Please select the time of your visit.</div>


    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'visit-details-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions' =>
            array(
                'class' => 'form-log-visit',
            ),

        )); ?>


    <div class="row">
        <div class="col-sm-4 text-center">
            <a href="#"><img src="<?=Yii::app()->theme->baseUrl?>/images/vic24h.png" alt="Vic24h"></a>
        </div>
        <div class="col-sm-8">

            <div class="form-group">
                <label class="col-sm-4 text-primary control-label">DATE OF VISIT</label>
                <div class="col-sm-7">
                    <span class="glyphicon glyphicon-calendar"></span>
                    <?php echo $form->textField($model,'date_in',
                        array(
                            'placeholder' => 'DD-MM-YYYY',
                            'class'=>'form-control input-lg from_date',
                            //'data-date-picker-start'=>"",
                            'data-date-format'=>'dd-mm-yyyy',
                            'value'=>''
                        )); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 text-primary control-label">END DATE OF VISIT</label>
                <div class="col-sm-7">
                    <span class="glyphicon glyphicon-calendar"></span>
                    <?php
                    echo $form->textField($model,'date_out',
                        array(
                            'placeholder' => 'DD-MM-YYYY',
                            'class'=>'form-control input-lg to_date',
                            //'data-date-picker-end'=>"",
                            'data-date-format'=>'dd-mm-yyyy',
                            'value'=>'',
                            'disabled'=>'disabled'
                        ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 text-primary control-label">TIME IN</label>
                <div class="row col-sm-7">

                    <div class="col-xs-6">
                    <?php
                    echo $form->dropDownList($model,'time_in', $model->visitClockTime , array('class'=>'form-control input-lg') )
                    ?>

                    </div>
                    <div class="col-xs-4">
                        <?php
                            echo $form->dropDownList($model,'ampm', $model->oClock,array('class'=>'form-control input-lg'));
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-1"></div>
    </div>



    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/confirmDetails")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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

<script type="text/javascript">

    /*function getTime(t1,t2){
    //function getTime(){
        var t1 = '08:00', t2 = '08:00';
        var m = (t1.substring(0,t1.indexOf(':'))-0) * 60 +
            (t1.substring(t1.indexOf(':')+1,t1.length)-0) +
            (t2.substring(0,t2.indexOf(':'))-0) * 60 +
            (t2.substring(t2.indexOf(':')+1,t2.length)-0);
        var h = Math.floor(m / 60);
        //document.write(h + ':' + (m - (h * 60)));

        var min = m - (h * 60);

        if( min == 0 ){
            var time = h + ':' + '00';
        }
        else{
            var time = h + ':' + (m - (h * 60));
        }

        return time;
    }

    //alert(getTime());

    alert(50+'10');
    $('#time_in').on('change', function() {


        //var t1 = $(this).val(), t2 = '12:00';
        //var time = getTime(t1,t2);
        //alert($(this).val());
        //alert(time);
    });*/

</script>