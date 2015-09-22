
<div class="page-content">
    
    <div id="menu">
        <div class="row items"  style="background-color:#fff;">
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;border-right: 1px solid #fff;"><a href="<?php echo Yii::app()->createUrl('preregistration/dashboard'); ?>"><span class="glyphicon glyphicon-home"></span></a></div>
            <div class="col-sm-4 col-xs-6 text-center" style="background-color: #eeeeee; height:40px;"><a href="<?php echo Yii::app()->createUrl('preregistration/verifications'); ?>" class="tableFont">ASIC Sponsor Verifications</a></div>
        </div>
    </div>

   
    
    <div class="row">
        <div class="col-sm-12 col-xs-12">
             <h1 class="text-primary title">DECLINE VIC HOLDER</h1>
        </div>
    </div>

    <br><br>

    <div class="row">
        <div class="col-sm-12">
             Do you wish to assign to another ASIC sponsor?
        </div>
    </div>

    <br><br>

    <div class="row">
        <div class="col-sm-3 col-xs-8"><a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('preregistration/assignAsicholder'); ?>">Yes</a></div>
        
        <div class="col-sm-2 col-xs-4"><a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('preregistration/vicholderDeclined'); ?>">No</a></div>
    </div>  

  
</div>