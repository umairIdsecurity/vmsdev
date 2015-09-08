
<div class="page-content">
    
    <div id="menu">
        <div class="row items">
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-xs-4 text-center"><a href="<?php echo Yii::app()->createUrl('preregistration/verifications'); ?>">ASIC Sponsor Verifications</a></div>
        </div>
    </div>

   
    
    <div class="row">
        <div class="col-lg-6">
             <h1 class="text-primary title">DECLINE VIC HOLDER</h1>
        </div>
    </div>

    <br><br>

    <div class="row">
        <div class="col-lg-6">
             Do you wish to assign to another ASIC sponsor?
        </div>
    </div>

    <br><br>

    <div class="row">
        <div class="col-lg-3"><a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('preregistration/assignAsicholder'); ?>">Yes</a></div>
        
        <div class="col-lg-2"><a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('preregistration/declineVicholder'); ?>">No</a></div>
    </div>  

  
</div>