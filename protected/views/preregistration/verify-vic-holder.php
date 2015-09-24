
<div class="page-content">
    
    <div id="menu">
        <div class="row items" style="background-color:#fff;">
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;border-right: 1px solid #fff;"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;"><a href="<?php echo Yii::app()->createUrl('preregistration/verifications'); ?>" class="tableFont">ASIC Sponsor Verifications</a></div>
        </div>
    </div>

   
    
    <div class="row">
        <div class="col-sm-6">
             <h1 class="text-primary title">VERIFY VIC HOLDER</h1>
             <hr>
        </div>

    </div>
    

    <div class="row">
        <div class="col-sm-6">

            <div class="row">
                <div class="col-sm-9 col-xs-12">
                    <div class="row">
                        <div class="col-sm-3 col-xs-2">Name: </div>
                        <div class="col-sm-6 col-xs-10"><?= $visitor->first_name." ".$visitor->last_name ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-2">Email: </div>
                        <div class="col-sm-6 col-xs-10"><?= $visitor->email ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-2">Ph: </div>
                        <div class="col-sm-6 col-xs-10"><?= $visitor->contact_number ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 col-xs-2">DOB: </div>
                        <div class="col-sm-6 col-xs-10"><?= $visitor->date_of_birth ?></div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <?php
                        $preImg = '';
                        if(isset($visitor->photo) && ($visitor->photo != null)) 
                        {
                            $photo = Photo::model()->findByPk($visitor->photo);
                            $preImg = "data:image;base64,".$photo->db_image;
                        }else{
                            $preImg = Yii::app()->theme->baseUrl.'/images/user.png';
                        }  
                    ?>    
                    <img src="<?=$preImg ?>" alt="<?= Yii::app()->theme->baseUrl.'/images/user.png'; ?>" id="preview" width="100" height="120">
                </div>
            </div>

            <hr>

        </div>
    </div>


    <div class="row">
        <div class="col-sm-6">

            <div class="row">
                <div class="col-sm-9 col-xs-12">
                    <div class="row">
                        <div class="col-sm-5 col-xs-4">Company Name: </div>
                        <div class="col-sm-7 col-xs-8"><?= $company->name ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 col-xs-4">Company Contact: </div>
                        <div class="col-sm-7 col-xs-8"><?= $company->contact ?></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5 col-xs-4">Office Number: </div>
                        <div class="col-sm-7 col-xs-8"><?= $company->office_number ?></div>
                    </div>
                </div>
            </div>

            <hr>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">

            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-5 col-xs-5">Date of Visit: <?= $visit->date_check_in ?></div>
                        <div class="col-sm-2 col-xs-2">&nbsp;</div>
                        <div class="col-sm-5 col-xs-5">Date Out: <?= $visit->date_check_out ?></div>
                    </div>
                </div>
            </div>

            <hr>

        </div>
    </div>

    <div class="row">
        <!-- <div class="col-sm-1 col-xs-1"></div> -->

        <div class="col-sm-5 col-xs-8"><a class="btn btn-success" href="<?php echo Yii::app()->createUrl('preregistration/verificationDeclarations'); ?>">Verif</a></div>
        
        <div class="col-sm-1 col-xs-2"><a class="btn btn-danger" href="<?php echo Yii::app()->createUrl('preregistration/declineVicholder'); ?>">Decline</a></div>

        <!-- <div class="col-sm-1 col-xs-1"></div> -->
    </div>        

    <br>

    <div class="row">
        <div class="col-sm-1 col-xs-1">&nbsp;</div>

        <div class="col-sm-4 col-xs-8"><a class="btn btn-default" href="<?php echo Yii::app()->createUrl('preregistration/assignAsicholder'); ?>">Assign to another ASIC holder</a></div>
        
        <div class="col-sm-1 col-xs-2"></div>
    </div>

    <br>

    <div class="row">
        <div class="col-sm-5 col-xs-9"></div>
        <div class="col-sm-2 col-xs-3"><a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>">Next</a></div>
    </div>

</div>