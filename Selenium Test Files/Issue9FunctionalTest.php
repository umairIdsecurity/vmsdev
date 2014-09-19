<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue9FunctionalTest
 *
 * @author Jeremiah
 */
class Issue9FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://localhost/");
    }

    function testAll() {
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
    }

    /* Scenario 1 – Login as admin and view and update organization settings .
      Expected Behavior
      -	Assert text  ’Test company 1’ in company name field
      -	Assert text  ’Organization settings updated’ in company name field

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administrator
      6.        Click organization settings
      6.        Assert Text 'Test company 1 in email field'
      7.        Type Test company 1 - update in display name field
      8.       Click save wait for page to reload
      9.         Asser text organization settings updated
      10.       assert text lastname 'test company 1 - update'
      11.        Click view license details.
      12.        Assert text 'this is a sample license detail'.
     */

    function Scenario1() {
        $this->login("admin@test.com", "12345");
        $this->click("link=Organization Settings");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Test Company 1", $this->getValue("id=Company_name"));
        $this->type("id=Company_trading_name", "Test Company 1 - Update");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Organization Settings Updated", $this->getText("css=div.flash-success"));
        $this->assertEquals("Test Company 1 - Update", $this->getValue("id=Company_trading_name")); 
        $this->click("id=modalBtn");
        $this->assertEquals("This is a sample license detail.", $this->getText("id=modalBody"));
    }

    /* Scenario 2 – Login as admin and check for validation errors
      Expected Behavior
      -	Assert text  company name cannot be blank
      - Assert text email address is not valid
      - Assert text website is not valid URL

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      7.        Click 'Adminsitration'
      8.      Click organization settings
      9.        Empty fields
      10.       Click Save
      11.        Assert text company name cannot be blank
      12.        type 123 in email field
      13.        Click save
      14.        Assert text email addess is not valid.
      12.        type 123 in website url field
      13.        Click save
      14.        Assert text website is not valid url.
     */

    function Scenario2() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Organization Settings");
        $this->waitForPageToLoad("30000");
        $this->type("id=Company_name", "");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Company Name cannot be blank.", $this->getText("css=div.errorSummary > ul > li"));
        $this->type("id=Company_email_address", "123");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Email Address is not a valid email address.", $this->getText("//form[@id='company-form']/div/ul/li[2]"));
        $this->type("id=Company_website", "123");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Website is not a valid URL.", $this->getText("//form[@id='company-form']/div/ul/li[3]"));
    }

    /*
      Scenario 3 – Login as admin and check access control
      Expected Behavior
      -	Assert text you are not authorized to perform this action.

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Go to http://localhost/vms/index.php?r=company/update/&id=2
      6.        Assert Text you are not authorized this action.
     */

    function Scenario3() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->open("http://localhost/vms/index.php?r=company/update/&id=2");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
    }

    
}

?>