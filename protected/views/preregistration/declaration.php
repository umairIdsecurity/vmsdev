<?php
$session = new CHttpSession;
?>

<div class="page-content">
<?php
    $form=$this->beginWidget('CActiveForm', array(
        'id'=>'declaration-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=> 'declarations'
        )
    ));
?>
        
        <div class="row"><div class="col-sm-12">&nbsp;</div></div>

        <h3 class="text-primary subheading-size">Declarations</h3>

        <div class="form-group">

            <label class="checkbox">
                <h5 class="text-size">I agree by ticking the boxes below:</h5>
            </label>

            <label class="checkbox">
                <input <?php echo (isset($session['declarationCheck1'])&&$session['declarationCheck1']=='checked') ? 'checked':''; ?> id="toggleCheckbox1" name="name1" type="checkbox" value="<?php echo (isset($session['declarationCheck1'])&&$session['declarationCheck1']=='checked') ? '1':'0';?>">
                <span class="checkbox-style"></span><span class="text-size">I have not previously been either refused an ASIC that was suspended or cancelled because of an adverse criminal record, or been issued with a VIC pass at Moorabin Airport for more than a total of 28 days in the previous 12 months (not including a VIC issued by Customs & Border Protection, or VICs issued prior to 21st November 2011).</span>
            </label>


            <label class="checkbox">
                <input <?php echo (isset($session['declarationCheck2'])&&$session['declarationCheck2']=='checked') ? 'checked':''; ?> id="toggleCheckbox2" name="name2" type="checkbox" value="<?php echo (isset($session['declarationCheck2'])&&$session['declarationCheck2']=='checked') ? '1':'0';?>">
                <span class="checkbox-style"></span><span class="text-size">I have read, understood and agree to abide by the information and conditions applicable to the holder of the Visitor Identification Card (VIC).</span>
            </label>
        </div>

        
        <div id="errorDiv" style="display:none;color:red;">
            Mark all Declarations to proceed
        </div>

        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
        <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>


        <div class="row">
            <div class="col-sm-12">
                <div class="">
                    <div class="pull-left">
                        <a href="<?=Yii::app()->createUrl("preregistration/privacyPolicy")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                    </div>
                    <div class="pull-right">
                        <?php (isset($session['declarationCheck1'])&&$session['declarationCheck1']=='checked'&&isset($session['declarationCheck2'])&&$session['declarationCheck2']=='checked') ? $link = Yii::app()->createUrl("preregistration/personalDetails"):$link = 'javascript:;';?>
                        <a id="nextLink" href="<?= $link ?>" class="btn btn-primary btn-next">NEXT <span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                </div>
            </div>
        </div>  


    <?php $this->endWidget(); ?>
</div>

<script>
    $("#toggleCheckbox1").on("click",function(e){
        if(this.checked){
            $(this).val(1);
            if(parseInt($("#toggleCheckbox2").val()) == 1){
                $("#nextLink").attr("href","<?php echo Yii::app()->createUrl('preregistration/personalDetails')?>");
                $("#errorDiv").hide();
            }else{
                $("#errorDiv").show();
            }
        }else{
            $(this).val(0);
            $("#nextLink").attr("href","javascript:;");
            $("#errorDiv").show();
        }
    });

    $("#toggleCheckbox2").on("click",function(e){
        if(this.checked){
            $(this).val(1);
            if(parseInt($("#toggleCheckbox1").val()) == 1){
                $("#nextLink").attr("href","<?php echo Yii::app()->createUrl('preregistration/personalDetails')?>");
                $("#errorDiv").hide();
            }else{
                $("#errorDiv").show();
            }
        }else{
            $(this).val(0);
            $("#nextLink").attr("href","javascript:;");
            $("#errorDiv").show();
        }
    });

    $("#nextLink").on("click",function(e){
        var checkboxVal1 = parseInt($("#toggleCheckbox1").val());
        var checkboxVal2 = parseInt($("#toggleCheckbox2").val());
        if(checkboxVal1 == 0 || checkboxVal2 == 0){
            $("#errorDiv").show();
        }else{
            $("#errorDiv").hide();
        }
    });


</script>