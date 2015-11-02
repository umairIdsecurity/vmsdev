<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/6/15
 * Time: 2:31 PM
 */

?>
<div class="page-content">

    <!-- <div class="row"><div class="col-sm-12">&nbsp;</div></div> -->

    <div class="privacy-info">
        <h3 class="text-primary subheading-size">Airport ASIC Sponsor Privacy Notice</h3>

        <div class="row"><div class="col-sm-12">&nbsp;</div></div>

        <div class="bg-gray-lighter privacy-notice" style="height:360px !important;">
            <div>

                <h4 style="font-size: 14px; font-weight:bold">PRIVACY NOTICE - What does the Airport do with your personal information?</h4>
                <p class="text-size">
                    Information you provide on  the VIC application includes personal information, the collection, use and disclosure of which is governed by the Privacy Act 1998 (Commonwealth).<br><br>
                    The Airport uses this information internally for the purposes of its functions under the Aviation Transport Security Act 2004 and Aviation Transport Security Regulations 2005.<br><br>
                    For example, the Airport will use this information to process VIC applications, to monitor compliance with the 28 day limit and to keep a register of every VIC issued.<br><br>
                    The Airport may also disclose this information to third parties. For example, personal information will be shared with our Authorised Agents (as approved in our Transport Security Program) who issue VICs.<br><br><br><br>
                </p>
            </div>

        </div>

    </div>

    <br>
    
    <div class="declarations" style="">
        <div class="form-group" id="privacy_notice">


            <label class="checkbox text-size"><input id="toggleCheckbox" name="name1" type="checkbox" value="0"><span class="checkbox-style"></span><span class=" text-size" style="line-height:21px">I have read and understood the Airport privacy notice on the collection and release of personal information.</span></label>
            
            <div id="errorDiv" style="display:none;color:red;">
                Please mark Privacy Notice
            </div>

        </div>
    </div>

    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
    <div class="row"><div class="col-sm-12">&nbsp;</div></div><div class="row"><div class="col-sm-12">&nbsp;</div></div>
   

    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?php echo Yii::app()->createUrl("preregistration/registration")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                </div>
                <div class="pull-right">
                    <a id="nextLink" href="javascript:;" class="btn btn-primary btn-next">NEXT <span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            </div>
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