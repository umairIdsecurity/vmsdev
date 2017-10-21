<?php
    $session = new CHttpSession;
    //this is because to ensure the CAVMS-1144 and CAVMS-1092
    $tenant = '';
    if(isset(Yii::app()->user->tenant) && (Yii::app()->user->tenant != "")){
        $tenant = Yii::app()->user->tenant;
    }
    else
    {
        $tenant = (isset($session['tenant']) && ($session['tenant'] != "")) ? $session['tenant'] : '';
    }

?>

<!-- <div class="page-content"> -->
        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
        
        <?php
            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'app-type-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'style' => 'height:100%;position:relative'
                )
            ));
        ?>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="pull-left">
                        <h5 class="text-size text-sizeWhere">Please select one of the below options</h5>
                    </div>
                    <div class="pull-left" style="margin-top: 7px; margin-left: 10px;">
                        <!--<a class="text-size make-underline" href="#" data-toggle-class data-show-hide=".sms-info" ><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;(VIC) What is this?</a>-->
                    </div>
                </div>    
            </div>
        </div>

        <div class="row"><div class="col-sm-12">&nbsp;</div></div>

        <div class="row">
            <div class="col-sm-12">
                <div class="hidden sms-info">
                  <!--  <span class="btn-close" data-closet-toggle-class="hidden" data-object=".sms-info">close</span>
                    <h3 class="heading-size">What is a Visitor Identification Card (VIC)?</h3>
                    <p class="text-size">A VIC is an identification card visitors must wear when they are in a secure zone of a security controlled airport. VICs permit temporary access to non-frequent visitors to an airport. If a person is a frequent visitor to an airport they should consider applying for an Aviation Security Identification Card (ASIC).</p>-->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 fixedMargin">
                
                <?php
                   // $ws=Workstation::model()->findAll('is_deleted=0 and tenant = '.($tenant==null?"-1":$tenant));
                   // $list=CHtml::listData($ws,'id','name');
                    /*echo $form->dropDownList($model,'entrypoint',
                        $list,
                        array(
                            'class'=>'form-control input-sm' ,
                            'empty' => 'Chose your entry point')
                    );*/
					$radiolabels=array('1'=>'ASIC Online Application', 
					'2'=>'Preregister for a VIC');
					echo $form->radioButtonList($model, 'apptype',array(
					'1'=>'ASIC Online Application', 
					'2'=>'Preregister for a VIC',
					),array('class' => 'password_requirement form-label','separator'=>'</br></br>'));
					echo $form->error($model,'apptype');
                ?>
				
                
             
            </div>
        </div>
		 
		 <div class="row"><div class="col-sm-12">&nbsp;</div></div>
		 <div class="row"><div class="col-sm-4 fixedMargin"><?php echo $form->error($model,'apptype'); ?></div></div>
	 

        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
  


        <div class="row">
            <div class="col-sm-12">
                <?php if(!isset(Yii::app()->params['on_premises_airport_code'])){ ?>
                <div class="pull-left">
                    <a href="<?=Yii::app()->createUrl("preregistration/index",array('tenant' => '177'))?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                </div>
                <?php } ?>
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

    <?php $this->endWidget(); ?>

<!-- </div> -->

