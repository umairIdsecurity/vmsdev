<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 6/8/15
 * Time: 6:00 PM
 */

?>
<div class="page-content">
    <h1 class="text-primary title">CREATE LOGIN</h1>
    <div class="bg-gray-lighter form-info">Please select your account type.</div>
    <form class="form-create-login">
        <div class="form-group">
            <div class="radio">
                <label>
                    <input type="radio" name="options" value="option1" checked>
                    <span class="radio-style"></span>
                    VIC applicant
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="options"  value="option2">
                    <span class="radio-style"></span>
                    Company preregistering multiple VIC applicants
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="options" value="option3">
                    <span class="radio-style"></span>
                    ASIC sponsor
                </label>
            </div>
        </div>
        <div class="form-group">
            <span class="glyphicon glyphicon-user"></span>
            <input type="email"
                   name="identity"
                   class="form-control input-lg"
                   data-validate-input
                   placeholder="Username or email address" >
        </div>
        <div class="form-group">
            <span class="glyphicon glyphicon-user"></span>
            <input type="email"
                   name="identity-c"
                   class="form-control input-lg"
                   data-validate-input
                   placeholder="Repeat username or email address" >
        </div>
        <div class="form-group">
            <span class="glyphicon glyphicon-asterisk"></span>
            <input type="password"
                   name="password"
                   class="form-control input-lg"
                   data-validate-input
                   placeholder="Password" >
        </div>
        <div class="form-group">
            <span class="glyphicon glyphicon-asterisk"></span>
            <input type="password"
                   name="password-c"
                   class="form-control input-lg"
                   data-validate-input
                   placeholder="Repeat password" >
        </div>
    </form>
</div>