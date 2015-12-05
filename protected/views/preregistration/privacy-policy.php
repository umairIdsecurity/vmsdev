<?php
$session = new CHttpSession;
?>
<!-- <div class="page-content"> -->

    <!-- <div class="row"><div class="col-sm-12">&nbsp;</div></div> -->

    <h3 class="text-primary subheading-size">Requirements</h3>
    <div class="privacy-info text-size">
        To proceed you will need to provide details of the following:
        <br><br>
        <ol>
            <li>
                A valid Driver Licence, Passport or Proof of Age Card
            </li>
            
            <br>

            <li>
                An Email or Mobile Number of your escorting ASIC Sponsor (if known) 
            </li>

            <br>

            <li>
                Details of your reason for visiting including company contact information
            </li>
        </ol>
    </div>
    <div class="privacy-info">

        <h3 class="text-primary subheading-size">Important Information regarding the Visitor Identification Card - Airport Privacy Policy</h3>
        <div class="bg-gray-lighter privacy-notice" style="height:360px !important;">
            <div>

                <h4 style="font-size: 14px; font-weight:bold">PRIVACY NOTICE - What does the Airport do with your personal information?</h4>
                <p class="text-size">Information you provide on the VIC application includes personal information, the collection, use and disclosure of which is governed by the Privacy Act 1998 (Commonwealth). <br><br>
                    <?=Company::model()->getCurrentTenantName() ?> uses this information internally for the purposes of its functions under the Aviation Transport Security Act 2004 and Aviation Transport Security Regulations 2005. <br><br>
                    For example, the Airport will use this information to process VIC applications, to monitor compliance with the 28 day limit and to keep a register of every VIC issued. <br><br>
                    <?=Company::model()->getCurrentTenantName() ?> may also disclose this information to third parties. For example, personal information will be shared with our Authorised Agents (as approved in our Transport Security Program) who issue VICs. <br><br>
                </p>
            </div>

        </div>

    </div>

    <br>

    <div class="declarations" style="">
        <div class="form-group" id="privacy_notice">


            <label class="checkbox text-size"><input <?php echo (isset($session['privacyPolicy'])&&$session['privacyPolicy']=='checked') ? "checked":""; ?> id="toggleCheckbox" name="name1" type="checkbox" value="<?php echo (isset($session['privacyPolicy'])&&$session['privacyPolicy']=='checked') ? '1':'0';?>"><span class="checkbox-style"></span><span class=" text-size" style="line-height:21px">I consent to Moorabin Airport using and disclosing my personal information in accordance with the Airport’s privacy notice.</span></label>
            
            <div id="errorDiv" style="display:none;color:red;">
                Please mark Privacy Notice
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="">
                <div class="pull-left">
                    <a href="<?php echo Yii::app()->createUrl("preregistration/entryPoint"); ?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
                </div>
                <div class="pull-right">
                    <?php (isset($session['privacyPolicy'])&&$session['privacyPolicy']=='checked') ? $link = Yii::app()->createUrl("preregistration/declaration"):$link = 'javascript:;';?>
                    <a id="nextLink" href="<?= $link ?>" class="btn btn-primary btn-next">NEXT <span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            </div>
        </div>
    </div>  
    
<!-- </div> -->

<script>
    $("#toggleCheckbox").on("click",function(e){
        if(this.checked){
            $(this).val(1);
            $("#nextLink").attr("href","<?php echo Yii::app()->createUrl('preregistration/declaration')?>");
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