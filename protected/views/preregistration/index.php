<?php
    $session = new CHttpSession;
?>

<style type="text/css">
    .highlight{
        box-shadow: 0px 3px 9px rgba(0, 0, 0, 0.5);    
    }
</style>

<!-- <div class="page-content"> -->
        <div class="row"><div class="col-sm-12">&nbsp;</div></div>
        
        <?php
            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'tenantselection-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'style' => 'height:100%;position:relative'
                )
            ));
        ?>
        
        <!--<div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="pull-left">
                        <h5 class="text-size text-sizeWhere">Where will you be collecting your VIC?</h5>
                    </div>
                    <div class="pull-left" style="margin-top: 7px; margin-left: 10px;">
                        <a class="text-size make-underline" href="#" data-toggle-class data-show-hide=".sms-info" ><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;(VIC) What is this?</a>
                    </div>
                </div>    
            </div>
        </div>-->

        <div class="row"><div class="col-sm-12">&nbsp;</div></div>

        <div class="row">
            <div class="col-sm-12">
                <div class="hidden sms-info">
                    <span class="btn-close" data-closet-toggle-class="hidden" data-object=".sms-info">close</span>
                    <h3 class="heading-size">What is a Visitor Identification Card (VIC)?</h3>
                    <p class="text-size">A VIC is an identification card visitors must wear when they are in a secure zone of a security controlled airport. VICs permit temporary access to non-frequent visitors to an airport. If a person is a frequent visitor to an airport they should consider applying for an Aviation Security Identification Card (ASIC).</p>
                </div>
            </div>
        </div>

        <div class="row">
<!--            <div class="col-sm-4 fixedMargin">-->
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <?php
                                    $tenantsAndImages = Company::model()->findAllTenantsAndImages();
                                    echo $form->dropDownList($model,'tenant',
                                        CHtml::listData($tenantsAndImages, 'id', 'name'),
                                    array(
                                        'class'=>'form-control input-sm',
                                        'empty' => 'Choose an Airport')
                                );?>
                            </div>
                            <?php echo $form->error($model,'tenant'); ?>
                        </div>
                        <div class="col-sm-offset-1 col-sm-6">
                            <div class="logo-grid All">
                                <div class="filter">
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid All"><strong>ALL | </strong></span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid A">A</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid B">B</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid C">C</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid D">D</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid E">E</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid F">F</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid G">G</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid H">H</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid I">I</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid J">J</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid K">K</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid L">L</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid M">M</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid N">N</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid O">O</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid P">P</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid R">R</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid S">S</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid T">T</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid U">U</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid V">V</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid W">W</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid X">X</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid Y">Y</span>
                                    <span data-object=".logo-grid" data-closet-update-class="logo-grid Z">Z</span>
                                </div>
                                <div class="logos">
                                    <?php
                                    foreach($tenantsAndImages as $tenantAndImage)
                                    {
                                        $letter= strtoupper(substr($tenantAndImage['name'],0,1));
                                        $id = $tenantAndImage['id'];
                                        ?>
                                        <label  data-group="<?php echo $letter;?>" style="width:100px" >
                                                <input type="radio" name="airport" id="airport-radio-button" value="<?php echo $id;?>" >
                                                <figure>
                                                    <img src="<?php echo $tenantAndImage['db_image'];?>" >
                                                </figure>
                                        </label>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>


<!--            </div>-->
        </div>


        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>    


        <div class="row">
            <div class="col-sm-12">
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
    <script>
        $(document).ready(function() {
             $('input[type=radio][name=airport]').on('change',function(){
                $(this).closest('label').addClass('highlight').siblings().removeClass('highlight');
                var airportCode = $('input[type=radio][name=airport]:checked').val();
                $('#TenantSelection_tenant').val(airportCode);

            });

        });
    </script>

<!-- </div> -->

