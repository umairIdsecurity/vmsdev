<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue8FunctionalTest
 *
 * @author Jeremiah
 */
class Issue8FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*iexplore");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 – Login as admin and update company logo
      Expected Behavior
      -	Assert image is Company-icon.png
      -        Assert text organisation settings saved

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.        Click organisation settings
      7.      Click browse computer
      8.      Select image in vms/test files/images/company-icon.png
      9.      Click save
      10.    Assert text ‘organisations settings successfully updated’
      11.    Assert image src /vms/uploads/company_logo/4e5607a6-1411146634.jpg

     */

    function Scenario1() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Organisation Settings");
        $this->waitForPageToLoad("30000");
        $this->type("//input[@type='file']", "C:\\xampp\\htdocs\\vms\\Selenium Test Files\\images\\Company-Icon.png");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Organisation Settings Updated", $this->getText("css=div.flash-success"));
    }

    /* Scenario 2 – Login as super admin and add company with logo
      Expected Behavior
      -	Assert image is Company-icon.png


      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.     Click administration
      6.	Click manage companies
      7.     Click add company
      8.    Fill up fields; use test company logo in company name field
      9.    Click browse computer and select image located in vms/test files/images/company-icon.png
      10.    Click save
      11.    Assert Company successfully added!
      12.    Click manage companies
      13.	 Click view companies
      14.	type test company logo in name filter then click edit
      15.	Assert Image is company-icon.png

     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Companies");
        $this->click("link=Add Company");
        $this->waitForPageToLoad("30000");
        $this->waitForElementPresent("id=Company_name");
        $this->type("id=Company_name", "Test Company 4");
        $this->type("id=Company_code", "TCD");
        $this->type("id=Company_trading_name", "Test Company 4");
        $this->type("id=Company_contact", "Test Person");
        $this->type("id=Company_billing_address", "123 street");
        $this->type("id=Company_email_address", "testcompany4@test.com");
        $this->type("id=Company_office_number", "12345");
        $this->type("id=Company_mobile_number", "12345");
        $this->type("id=Company_logo", "2");
        $this->type("//input[@type='file']", "C:\\xampp\\htdocs\\vms\\Selenium Test Files\\images\\Company-Icon.png");
        $this->type("id=Company_website", "http://testcompany4.com");
        $this->waitForElementPresent("id=createBtn");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->waitForElementPresent("css=td > input[name=\"Company[name]\"]");
        $this->type("css=td > input[name=\"Company[name]\"]", "Test Company 4");
        $this->type("name=Company[trading_name]", "Test Company 4");
        sleep(1);

        $this->assertEquals("Test Company 4", $this->getText("css=tr.odd > td"));
        $this->assertEquals("Test Company 4", $this->getText("//div[@id='company-grid']/table/tbody/tr/td[2]"));
    }

    
}

?>