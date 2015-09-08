
<div class="page-content">
    
    <div id="menu">
        <div class="row items">
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/verifications'); ?>">ASIC Sponsor Verifications</a></div>
        </div>
    </div>

   
    
    <div class="row">
        <div class="col-lg-6">
             <h1 class="text-primary title">VERIFY VIC HOLDER</h1>
             <hr>
        </div>

    </div>
    

    <div class="row">
        <div class="col-lg-6">

            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-3">Name: </div>
                        <div class="col-lg-6"><?= $visitor->first_name." ".$visitor->last_name ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">Email: </div>
                        <div class="col-lg-6"><?= $visitor->email ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">Ph: </div>
                        <div class="col-lg-6"><?= $visitor->contact_number ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">DOB: </div>
                        <div class="col-lg-6"><?= $visitor->date_of_birth ?></div>
                    </div>
                </div>

                <div class="col-lg-3">
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
        <div class="col-lg-6">

            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-5">Company Name: </div>
                        <div class="col-lg-7"><?= $company->name ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">Company Contact: </div>
                        <div class="col-lg-7"><?= $company->contact ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">Office Number: </div>
                        <div class="col-lg-7"><?= $company->office_number ?></div>
                    </div>
                </div>
            </div>

            <hr>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">

            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-5">Date of Visit: <?= $visit->date_in ?></div>
                        <div class="col-lg-2"></div>
                        <div class="col-lg-5">Date Out: <?= $visit->date_out ?></div>
                    </div>
                </div>
            </div>

            <hr>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-1"></div>

        <div class="col-lg-2"><a class="btn btn-success" href="<?php echo Yii::app()->createUrl('preregistration/verificationDeclarations'); ?>">Verif</a></div>
        
        <div class="col-lg-2"><a class="btn btn-danger" href="<?php echo Yii::app()->createUrl('preregistration/declineVicholder'); ?>">Decline</a></div>

        <div class="col-lg-1"></div>
    </div>        

    <br>

    <div class="row">
        <div class="col-lg-1"></div>

        <div class="col-lg-4"><a class="btn btn-default" href="<?php echo Yii::app()->createUrl('preregistration/assignAsicholder'); ?>">Assign to another ASIC holder</a></div>
        
        <div class="col-lg-1"></div>
    </div>

    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-2"></div>
        <div class="col-lg-2"><a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>">Next</a></div>
    </div>

</div>