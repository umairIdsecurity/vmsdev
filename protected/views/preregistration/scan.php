<?php
$session = new CHttpSession;
?>
<!-- <div class="page-content"> -->

    <!-- <div class="row"><div class="col-sm-12">&nbsp;</div></div> -->
<style>


td, th {
    border: 1px solid;
    text-align: left;
    padding: 8px;
}


</style>
    
	<div class="privacy-info text-size">
	

</div>
    <div class="privacy-info text-size">
	 <?php
            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'asic-type-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'style' => 'height:100%;position:relative'
                )
            ));
        ?>
		
      <button id="scan" >Click me</button>
    </div>
	 <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?php echo Yii::app()->createUrl("preregistration/asicOnlinePrivacyPolicy"); ?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                </div>
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
<!-- </div> -->

<script>$(document).ready(function () {
	$("#scan").on('click',function(){
		$.ajax({
                type: 'POST',
                url: 'http://192.168.1.6/uploads/UTS/scan.php',
		});
	
	});
	
   
});

</script>