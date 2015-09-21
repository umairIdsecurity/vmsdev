<div class="page-content">


        <?php
        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'entry-point-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
            ),
            'htmlOptions'=>array(
                //'class'=>'form-select-gate'
            )
        ));
        ?>

        <div class="row"><div class="col-lg-12">&nbsp;</div></div>
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-5">
                        <h5 class="form-title">Where will you be collecting your VIC?</h5>
                    </div>
                    <div class="col-lg-7" style="margin-top:10px">
                        <a href="#" data-toggle-class data-show-hide=".sms-info" ><span class="glyphicon glyphicon-info-sign"></span>(VIC) What is this?</a>
                    </div>
                </div>    
            </div>
        </div>

        <div class="row"><div class="col-lg-12">&nbsp;</div></div>

        <div class="row">
            <div class="col-lg-12">
                <div class="hidden sms-info">
                    <span class="btn-close" data-closet-toggle-class="hidden" data-object=".sms-info">close</span>
                    <h3>What is a Visitor Identification Card (VIC)?</h3>
                    <p>A VIC is an identification card visitors must wear when they are in a secure zone of a security controlled airport. VICs permit temporary access to non-frequent visitors to an airport. If a person is a frequent visitor to an airport they should consider applying for an Aviation Security Identification Card (ASIC).</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5">&nbsp;</div>
            <div class="col-lg-5">
                <div class="form-group">
                    <?php
                        $ws=Workstation::model()->findAll('is_deleted=0');
                        $list=CHtml::listData($ws,'id','name');
                        echo $form->dropDownList($model,'entrypoint',
                            $list,
                            array(
                                'class'=>'form-control input-lg' ,
                                'empty' => 'Chose your entry point')
                        );
                    ?>
                </div>
                <?php echo $form->error($model,'entrypoint'); ?>
            </div>
        </div>
          
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>

    <div class="row next-prev-btns">
        <div class="col-md-1">
            <!--<a href="" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>-->
        </div>

        <div class="col-md-offset-10 col-sm-offset-10 col-xs-offset-8 col-md-1">
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

