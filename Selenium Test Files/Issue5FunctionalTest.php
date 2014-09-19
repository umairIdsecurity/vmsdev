<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue3FunctionalTest
 *
 * @author Jeremiah
 */
class Issue5FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://localhost/");
    }

    function testAll() {
        //$this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
    }

    /* Scenario 1 – Login as super admin and add new company
      Expected Behavior
      -	Assert text  ’Test Company3’ in company name and display name  in search company and display name field

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Manage companies’
      7.        Click 'add company'
      8.	Fill up fields, use Test company 3 for company name
      9.	Click save
      10.	Wait for page to redirect in manage companies
      11.	Type Test company 3 in company name filter
      12.	Assert text Test company 3 in company name row
      13.	Assert text Test company 3 in company display name row
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Companies");
        $this->click("link=Add Company");
        $this->waitForPageToLoad("30000");
        $this->addinAdministrationCompany("Test Company 3", "testcompany");
        $this->assertTrue($this->isElementPresent("css=div.flash-success"));
        $this->click("link=Manage Companies");
        $this->click("link=View Companies");
        sleep(1);
        $this->type("css=td > input[name=\"Company[name]\"]", "Test Company 3");
        $this->type("xpath=(//input[@name='Company[trading_name]'])[2]", "Test Company 3");
        sleep(1);

        $this->assertEquals("Test Company 3", $this->getText("css=tr.odd > td"));
        $this->assertEquals("Test Company 3", $this->getText("//div[@id='company-grid']/table/tbody/tr/td[2]"));
    }

    /* Scenario 2 – Login as super admin and update a company
      Expected Behavior
      -	Assert text  ’Test Company 3 - update’ in display name  in search display name field

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Manage companies’
      7.        Click 'view companies'
      8.	Wait for page to redirect in manage companies
      9.	Type Test company 3 in company name adn display namefilter
      10.	Assert text Test company 3 in company name row
      11.	Assert text Test company 3 in company display name row
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Companies");
        $this->click("link=View Companies");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"Company[name]\"]", "Test Company 3");
        $this->type("xpath=(//input[@name='Company[trading_name]'])[2]", "Test Company 3");
        sleep(1);
        $this->click("link=Edit");
        $this->waitForPageToLoad("30000");
        $this->type("id=Company_trading_name", "Test Company 3 - update");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isElementPresent("css=div.flash-success"));
        $this->click("link=Manage Companies");
        $this->click("css=li.even > a > span");
        $this->waitForPageToLoad("30000");
        $this->type("css=td > input[name=\"Company[name]\"]", "Test Company 3");
        $this->type("xpath=(//input[@name='Company[trading_name]'])[2]", "Test Company 3");
        sleep(1);
        $this->assertEquals("Test Company 3", $this->getText("css=tr.odd > td"));
        $this->assertEquals("Test Company 3 - update", $this->getText("//div[@id='company-grid']/table/tbody/tr/td[2]"));
    }

    /*
      Scenario 3 – Login as super admin and check for validation errors
      Expected Behavior
      -	Assert text  please fix the following input errors
     * - Assert Email address is not valid
     * - Assert website is not a valid url
     * - assert company name cannot be blank

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Manage Companies’
      7.        Click 'add company'
      7.	click submit
      8.	assert please fix the following input errors
      9.	type 123 in email field
      10.	assert email address is not valid
      11.	Click save
      12.	type 123 in website
      13.	assert website is not a valid url

     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Companies");
        $this->click("link=Add Company");
        $this->waitForPageToLoad("30000");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Please fix the following input errors:", $this->getText("css=div.errorSummary > p"));
        $this->type("id=Company_email_address", "123");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Email Address is not a valid email address.", $this->getText("//form[@id='company-form']/table/tbody/tr[6]/td[3]/div"));
        $this->type("id=Company_website", "123");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Website is not a valid URL.", $this->getText("//form[@id='company-form']/table/tbody/tr[9]/td[3]/div"));
    }

    /*
      Scenario 4 – Login as admin and assert not authorized to access
      Expected Behavior
      -	Assert text you are not authorized to perform this action

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	open url http://localhost/vms/index.php?r=company/admin
      6.        assert text you are not authorized to perform this action

     */

    function Scenario4() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->open("http://localhost/vms/index.php?r=company/admin");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
    }

}

?>