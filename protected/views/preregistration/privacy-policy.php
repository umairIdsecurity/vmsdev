<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/6/15
 * Time: 2:31 PM
 */

?>
<div class="page-content">
    <h3 class="text-primary">Requirements</h3>
    <div class="privacy-info">
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

        <h3 class="text-primary">Important Information regarding the Visitor Identification Card - Perth Airport Privacy Policy</h3>
        <div class="bg-gray-lighter privacy-notice" style="height:360px !important;">
            <div>

                <h4>PRIVACY NOTICE - What does Perth Airport do with your personal information?</h4>
                <p>Information you provide on the VIC application includes personal information, the collection, use and disclosure of which is governed by the Privacy Act 1998 (Commonwealth). <br><br>
                    Perth Airport uses this information internally for the purposes of its functions under the Aviation Transport Security Act 2004 and Aviation Transport Security Regulations 2005. <br><br>
                    For example, Perth Airport will use this information to process VIC applications, to monitor compliance with the 28 day limit and to keep a register of every VIC issued. <br><br>
                    Perth Airport may also disclose this information to third parties. For example, personal information will be shared with our Authorised Agents (as approved in our Transport Security Program) who issue VICs. <br><br>
                </p>
            </div>

        </div>

    </div>

    <br>

    <div class="declarations" style="">
        <div class="form-group" id="privacy_notice">


            <label class="checkbox"><input id="toggleCheckbox" name="name1" type="checkbox" value="0"><span class="checkbox-style"></span>I consent to Perth Airport using and disclosing my personal information in accordance with Perth Airport’s privacy notice.<!-- I have read, understood and agree to abide by the information and conditions applicable to the holder of the Visitor Identification Card (VIC). --></label>
            
            <div id="errorDiv" style="display:none;color:red;">
                Please mark Privacy Notice
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <div class="pull-left">
                    <a href="<?=Yii::app()->createUrl("preregistration")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
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