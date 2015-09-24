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

        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="form-title">Where will you be collecting your VIC?</h5>
                    </div>
                    <div class="col-sm-6" style="margin-top:10px">
                        <a href="#" data-toggle-class data-show-hide=".sms-info" ><span class="glyphicon glyphicon-info-sign"></span>(VIC) What is this?</a>
                    </div>
                </div>    
            </div>
        </div>

        <div class="row"><div class="col-sm-12">&nbsp;</div></div>

        <div class="row">
            <div class="col-sm-12">
                <div class="hidden sms-info">
                    <span class="btn-close" data-closet-toggle-class="hidden" data-object=".sms-info">close</span>
                    <h3 class="responsiveH3">What is a Visitor Identification Card (VIC)?</h3>
                    <p>A VIC is an identification card visitors must wear when they are in a secure zone of a security controlled airport. VICs permit temporary access to non-frequent visitors to an airport. If a person is a frequent visitor to an airport they should consider applying for an Aviation Security Identification Card (ASIC).</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">&nbsp;</div>
            <div class="col-sm-7">
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


        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="pull-right">
                        <?php
                            echo CHtml::tag('button', array(
                                'type'=>'submit',
                                'class' => 'btn btn-primary btn-next'
                            ), 'NEXT <span class="glyphicon glyphicon-chevron-right"></span> ');
                        ?>
                    </div>
                </div>
            </div>
        </div>  

    <?php $this->endWidget(); ?>

</div>

