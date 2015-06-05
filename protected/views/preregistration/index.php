<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/4/15
 * Time: 3:31 PM
 */

?>

<div class="page-content">
    <h1 class="text-primary title">PREREGISTRATION FOR VISITOR IDENTIFICATION CARD (VIC)</h1>

    <form class="form-select-gate">
        <h3 class="form-title text-center">Where will you be collecting your VIC?</h3>

        <div class="form-group">
            <select name="entry-point" class="form-control input-lg">
                <option>Select gate or entry point</option>
                <option value="1">Entry Point 1</option>
                <option value="2">Entry Point 2</option>
                <option value="3">Entry Point 3</option>
                <option value="4">Entry Point 4</option>
                <option value="5">Entry Point 5</option>
            </select>
        </div>
        <div class="text-center icon-info">
            <a href="#" data-toggle-class data-show-hide=".sms-info" ><span class="glyphicon glyphicon-info-sign"></span>(VIC) What is this?</a>
        </div>
    </form>

    <div class="hidden sms-info">
        <span class="btn-close" data-closet-toggle-class="hidden" data-object=".sms-info">close</span>
        <h3>What is a Visitor Identification Card (VIC)?</h3>
        <p>A VIC is an identification card visitors must wear when they are in a secure zone of a security controlled airport. VICs permit temporary access to non-frequent visitors to an airport. If a person is a frequent visitor to an airport they should consider applying for an Aviation Security Identification Card (ASIC).</p>
    </div>
</div>