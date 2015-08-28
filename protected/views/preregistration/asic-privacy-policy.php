<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/6/15
 * Time: 2:31 PM
 */

?>
<div class="page-content">
    <div class="privacy-info">
        <h3 class="text-primary">Perth Airport ASIC Sponsor Privacy Notice</h3>
        <div class="bg-gray-lighter privacy-notice" style="height:360px !important;">
            <div>

                <h4>PRIVACY NOTICE - What does Perth Airport do with your personal information?</h4>
                <p>
                    Information you provide on  the VIC application includes personal information, the collection, use and disclosure of which is governed by the Privacy Act 1998 (Commonwealth).<br><br>
                    Perth Airport uses this information internally for the purposes of its functions under the Aviation Transport Security Act 2004 and Aviation Transport Security Regulations 2005.<br><br>
                    For example, Perth Airport will use this information to process VIC applications, to monitor compliance with the 28 day limit and to keep a register of every VIC issued.<br><br>
                    Perth Airport may also disclose this information to third parties. For example, personal information will be shared with our Authorised Agents (as approved in our Transport Security Program) who issue VICs.<br><br><br><br>
                </p>
            </div>

        </div>

    </div>


    <div class="declarations" style="padding: 10px 0 0 20px;">
        <div class="form-group" id="privacy_notice">


            <label class="checkbox"><input id="toggleCheckbox" name="name1" type="checkbox" value="0"><span class="checkbox-style"></span>I have read and understood Perth's Airport privacy notice on the collection and release of personal information.</label>
            
            <div id="errorDiv" style="display:none;color:red;">
                Please mark Privacy Notice
            </div>

        </div>
    </div>

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/registration")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
        </div>

        <div class="col-md-offset-10 col-sm-offset-10 col-xs-offset-7 col-md-1 col-sm-1 col-xs-1">
            <a id="nextLink" href="javascript:;" class="btn btn-primary btn-next">NEXT <span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
    </div>



</div>

<script>
    $("#toggleCheckbox").on("click",function(e){
        if(this.checked){
            $(this).val(1);
            $("#nextLink").attr("href","<?php echo Yii::app()->createUrl('preregistration/asicRegistration')?>");
            $("#errorDiv").hide();
        }else{
            $(this).val(0);
            $("#nextLink").attr("href","javascript:;");
            $("#errorDiv").show();
        }
    });

    $("#nextLink").on("click",function(e){
        var checkboxVal = parseInt($("#toggleCheckbox").val());
        if(checkboxVal == 0){
            $("#errorDiv").show();
        }else{
            $("#errorDiv").hide();
        }
    });


</script>