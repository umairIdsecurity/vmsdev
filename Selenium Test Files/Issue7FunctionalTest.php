<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue7FunctionalTest
 *
 * @author Jeremiah
 */
class Issue7FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*iexplore");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
    }

    /* Scenario 1 – Login as super admin and view and update profile
      Expected Behavior
      -	Assert text ‘test - update’ in last name field

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Profile
      6.      Assert Text 'superadmin@test.com in email field'
      7.      Assert company field disabled
      8.      Assert First name, last name, email, and contact number not disabled
      9.      Type test - update in last name field
      10.    Click save wait for page to reload and go to my profile
      11.    Assert text last name 'test - update'

     */

    function Scenario1() {
        $this->login("superadmin@test.com", "12345");
        $this->click("css=p");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isEditable("id=User_first_name"));
        $this->assertTrue($this->isEditable("id=User_last_name"));
        $this->assertTrue($this->isEditable("id=User_email"));
        $this->assertTrue($this->isEditable("id=User_contact_number"));
        $this->type("id=User_last_name", "Test - update");
        $this->click("id=submitBtn");
        $this->waitForPageToLoad("30000");
        $this->click("css=p");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Test - update", $this->getValue("id=User_last_name"));
    }

    /* Scenario 2 – Login as super admin and check for validation errors
      Expected Behavior
      -	Assert text  Firstname, last name, email, contact number, required
      - Assert text email address is not valid

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      7.        Click 'My Profile'
      8.	Wait for page to redirect in my profile
      9.        Empty fields
      10.       Click Save
      11.        Assert text first name, last name , email address, contact number is required
      12.        type 123 in email field
      13.        Click save
      14.        Assert text email addess is not valid.
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("css=p");
        $this->waitForPageToLoad("30000");
        $this->type("id=User_first_name", "");
        $this->type("id=User_last_name", "");
        $this->type("id=User_email", "");
        $this->type("id=User_contact_number", "");
        $this->click("id=submitBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("First Name cannot be blank.", $this->getText("css=div.errorSummary > ul > li"));
        $this->assertEquals("Last Name cannot be blank.", $this->getText("//form[@id='user-form']/div/ul/li[2]"));
        $this->assertEquals("Email cannot be blank.", $this->getText("//form[@id='user-form']/div/ul/li[3]"));
        $this->assertEquals("Contact No. cannot be blank.", $this->getText("//form[@id='user-form']/div/ul/li[4]"));
        $this->type("id=User_email", "123");
        $this->click("id=submitBtn");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Email is not a valid email address.", $this->getText("//form[@id='user-form']/div/ul/li[4]"));
    }

    /*
      Scenario 3 – Login as super admin and check access control
      Expected Behavior
      -	Assert text you are not authorized to perform this action.

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Go to localhost/vms/index.php?r=user/profile&id=17
      6.        Assert Text you are not authorized this action.
      7.        Go to localhost/vms/index.php?r=user/profile&id=18
      8.        Assert Text you are not authorized this action.
      9.        Go to localhost/vms/index.php?r=user/profile&id=19
      10        Assert Text you are not authorized this action.
      11.        Go to localhost/vms/index.php?r=user/profile&id=20
      12.        Assert Text you are not authorized this action.
      13.        Go to localhost/vms/index.php?r=user/profile&id=21
      14.        Assert Text you are not authorized this action.
     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->open("http://dev.identitysecurity.info/index.php?r=user/profile&id=17");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
        $this->open("http://dev.identitysecurity.info/index.php?r=user/profile&id=18");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
        $this->open("http://dev.identitysecurity.info/index.php?r=user/profile&id=19");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
        $this->open("http://dev.identitysecurity.info/index.php?r=user/profile&id=20");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
        $this->open("http://dev.identitysecurity.info/index.php?r=user/profile&id=21");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
    }

    /*
      Scenario 4 – Login as staffmember and account cannot be updated
      Expected Behavior
      -	Assert fields are disabled

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	open url http://localhost/vms/index.php?r=company/admin
      6.        assert text you are not authorized to perform this action

     */

    function Scenario4() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');
        $this->click("css=p");
        $this->waitForPageToLoad("30000");
        $this->assertFalse($this->isElementPresent("id='User_first_name'"));
        $this->assertEquals("Test", $this->getEval("window.document.getElementById(\"User_first_name\").value"));
        $this->assertFalse($this->isElementPresent("id='User_last_name'"));
        $this->assertEquals("staffmember", $this->getEval("window.document.getElementById(\"User_last_name\").value"));
        $this->getDisabledCompanyValue("Test Company 1");
        $this->assertFalse($this->isElementPresent("id='User_email'"));
        $this->assertEquals("staffmember@test.com", $this->getEval("window.document.getElementById(\"User_email\").value"));
        $this->assertFalse($this->isElementPresent("id='User_contact_number'"));
        $this->assertEquals("123456", $this->getEval("window.document.getElementById(\"User_contact_number\").value"));
    }

}

?>