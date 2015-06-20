<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/6/15
 * Time: 2:31 PM
 */

?>
<div class="page-content">
    <h1 class="text-primary title">PREREGISTRATION FOR VISITOR IDENTIFICATION CARD (VIC)</h1>
    <div class="privacy-info">
        To proceed with this registration you must:
        <ol>
            <li>
                Have a valid Driver's Licence or Passport with you
            </li>
            <li>
                Have the name and contact email or mobile number of your escorting ASIC sponsor
            </li>
            <li>
                Give details of your reason for visiting, including company contact information
            </li>
            <li>
                Approve the declarations by checking the tick boxes
            </li>
        </ol>
    </div>
    <div class="privacy-info">
        <h3 class="text-primary">Important information regarding the Visitor Information Card (VIC):</h3>
        <div class="bg-gray-lighter privacy-notice">
            <div>
                <p>Please read this information carefully and complete all the sections. Failure to do so may result in processing delays.</p>
                <h3 class="text-danger">PRIVACY NOTICE - What does Perth Airport do with your personal information?</h3>
                <p>Information you provide on the VIC application includes personal information, the collection, use and disclosure of which is governed by the Privacy Act 1998 (Commonwealth).
                    Perth Airport uses this information internally for the purposes of its functions under the Aviation Transport Security Act 2004 and Aviation Transport Security Regulations 2005.
                    For example, Perth Airport will use this information to process VIC applications, to monitor compliance with the 28 day limit and to keep a register of every VIC issued.
                    Perth Airport may also disclose this information to third parties. For example, personal information will be shared with our Authorised Agents (as approved in our Transport Security Program) who issue VICs.
                </p>
            </div>

        </div>
    </div>

    <div class="row next-prev-btns">
        <div class="col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration")?>" class="btn btn-large btn-primary btn-prev"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
        </div>

        <div class="col-md-offset-10 col-sm-offset-10 col-xs-offset-7 col-md-1 col-sm-1 col-xs-1">
            <a href="<?=Yii::app()->createUrl("preregistration/declaration")?>" class="btn btn-primary btn-next">NEXT <span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
    </div>

</div>