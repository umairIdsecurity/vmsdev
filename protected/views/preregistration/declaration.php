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


        <h3 class="text-primary">Declarations</h3>

        <h5>I agree by ticking the boxes below:</h5>

        <div class="form-group">

            <label class="checkbox">
                <input id="toggleCheckbox1" name="name1" type="checkbox" value="0">
                <span class="checkbox-style"></span>I have not previously been either refused an ASIC that was suspended or cancelled because of an adverse criminal record, or been issued with a VIC pass at Perth Airport for more than a total of 28 days in the previous 12 months (not including a VIC issued by Customs & Border Protection, or VICs issued prior to 21st November 2011).
            </label>


            <label class="checkbox">
                <input id="toggleCheckbox2" name="name2" type="checkbox" value="0">
                <span class="checkbox-style"></span>I have read, understood and agree to abide by the information and conditions applicable to the holder of the Visitor Identification Card (VIC).
            </label>
        </div>

        
        <div id="errorDiv" style="display:none;color:red;">
            Mark all Declarations to proceed
        </div>

        <br>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <div class="pull-left">
                        <a href="<?=Yii::app()->createUrl("preregistration/privacyPolicy")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                    </div>
                    <div class="pull-right">
                        <a id="nextLink" href="javascript:;" class="btn btn-primary btn-next">NEXT <span class="glyphicon glyphicon-chevron-right"></span></a>
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