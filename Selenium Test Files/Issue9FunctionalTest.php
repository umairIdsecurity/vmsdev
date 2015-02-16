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
        $this->setBrowser("*iexplore");
        $this->setBrowserUrl("http://localhost/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
    }

    /* Scenario 1 – Login as admin then view and update organisation settings.
      Expected Behavior
      -	Assert text ’Test Company 1’ in company name field
      -	Assert text ’Organisation settings updated’ in company name field

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administrator
      6.     Click organisation settings
      7. 	Assert Text 'Test Company 1 in email field'
      8.	Type Test Company 1 - update in display name field
      9.     Click save wait for page to reload
      10.   Asser text organisation settings updated
      11.   Assert text last name 'test company 1 - update'
      12.   Click view license details.
      13.   Assert text 'this is a sample license detail'.

     */

    function Scenario1() {
        $this->login("admin@test.com", "12345");
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("link=Organisation Settings");
        $this->assertEquals("Test Company 1", $this->getValue("id=Company_name"));
        $this->type("id=Company_trading_name", "Test Company 1 - Update");
        $this->clickAndWait("id=createBtn");
        $this->assertEquals("Organisation Settings Updated", $this->getText("css=div.flash-success"));
        $this->assertEquals("Test Company 1 - Update", $this->getValue("id=Company_trading_name"));
        $this->click("id=modalBtn");
        $this->assertEquals("This is a sample license detail.", $this->getText("id=modalBody"));
    }

    /* Scenario 2 – Login as admin and check for validation errors
      Expected Behavior
      -	Assert text company name cannot be blank
      - 	Assert text email address is not valid
      - 	Assert text website is not valid URL

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.     Click 'Administration'
      6.     Click organisation settings
      7.     Empty fields
      8.     Click Save
      9.      Assert text company name cannot be blank
      10.    Type 123 in email field
      11.        Click save
      12.        Assert text email address is not valid.
      13.        type 123 in website url field
      14.        Click save
      15.        Assert text website is not valid url.

     */

    function Scenario2() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("link=Organisation Settings");
        $this->type("id=Company_name", "");
        $this->clickAndWait("id=createBtn");
        $this->assertEquals("Company Name cannot be blank.", $this->getText("css=div.errorSummary > ul > li"));
        $this->type("id=Company_email_address", "123");
        $this->clickAndWait("id=createBtn");
        $this->assertEquals("Email Address is not a valid email address.", $this->getText("//form[@id='company-form']/div/ul/li[2]"));
        $this->type("id=Company_website", "123");
        $this->clickAndWait("id=createBtn");
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
        $this->open("http://cvms.identitysecurity.info/index.php?r=company/update/&id=1");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
    }

    /*
      Scenario 4 – Login as super admin and update license details
      Expected Behavior
      -	Assert text 'this is a sample license details update.

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click manage companies
      6.     Click view companies
      7.     Type Test Company 1 in company name and click edit
      8.      Wait for page to load and click license details
      9.      wait for page to load and  type 'this is a sample license details update'
      10.    Click save
      11.    Wait for page to load and type Test Company 1 in company name field
      12.    Click edit
      13.     Click license details and assert text 'this is a sample license details update'

     */

    function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Companies");
        $this->waitForElementPresent("css=td > input[name=\"Company[name]\"]");
        $this->type("css=td > input[name=\"Company[name]\"]", "Test Company 1");
        $this->waitForElementPresent("link=Edit");
        $this->clickAndWait("link=Edit");
        $this->clickAndWait("css=button.yiiBtn");
        $this->click("css=a.redactor_btn_html > span");
        $this->type("id=LicenseDetails_description", "This is a sample license details update");
        $this->clickAndWait("name=yt0");
        $this->type("css=td > input[name=\"Company[name]\"]", "Test Company 1");
        sleep(5);
        $this->clickAndWait("link=Edit");
        $this->clickAndWait("css=button.yiiBtn");
        $this->click("css=a.redactor_btn_html > span");
        $this->assertEquals("This is a sample license details update", $this->getText("id=LicenseDetails_description"));
    }

}

?>