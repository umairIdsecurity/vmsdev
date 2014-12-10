<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue24FunctionalTest
 *manage reasons
 * @author Jeremiah
 */
class Issue24FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDb();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->resetDbWithData();
        $this->Scenario4();
        $this->Scenario5();
    }

    /* Scenario 1 – Login as super admin and add new visit reason.
      Expected Behavior
      -	Assert Reason is added successfully. Search for test reason in manage table.


      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.        Click manage visit reasons then click add. 
      7.	Type test reason in reason field.
      8.	Click add button and wait for page to load.
      9.	Type test reason  in reason filter
      10. 	Assert text test reason in table.

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[5]/a/span");
        $this->clickAndWait("css=li.has-sub.active > ul > li.odd > a.addSubMenu > span");
        $this->type("id=VisitReason_reason", "Test Reason");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Test Reason", $this->getText("css=tr.odd > td"));
    }

    /* Scenario 2 – Login as super admin and update a reason.
      Expected Behavior
      -	Assert Reason is updated successfully. Search for test reason - updated in manage table.


      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.        Click manage visit reasons
      7.	Type test reason in reason filter.
      8.	Click edit and wait for page to load
      9.	Type test reason – updated in reason field then click save button.
      10. 	Wait for manage visit reason page, then type test reason-updated in reason filter
      11.	Assert text test reason- updated in table.
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("link=Manage Visit Reasons");
        $this->type("name=VisitReason[reason]", "Test Reason");
        $this->clickAndWait("link=Edit");
        $this->type("id=VisitReason_reason", "Test Reason - updated");
        $this->clickAndWait("name=yt0");
        $this->type("name=VisitReason[reason]", "Test Reason - updated");
        $this->assertEquals("Test Reason - updated", $this->getText("css=tr.odd > td"));
    }

    /* Scenario 3 – Login as super admin and delete a reason.
      Expected Behavior
      -	Assert text no results found.


      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.       Click manage visit reasons
      7.	Type test reason - updated in reason filter.
      8.	Click delete, then click ok to confirm.
      9.	Wait for page to reload then, Type test reason – updated in reason
      10.	Assert text no results found.
     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[5]/a/span");
        $this->type("name=VisitReason[reason]", "Test Reason - updated");
        $this->click("link=Delete");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->waitForElementPresent("css=span.empty");
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
    }

    /* Scenario 4 – Check Access Control
      Expected Behavior
      -	Only Super Admin can access visit reasons.

      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Login as superadmin@test.com and use 12345 as password
      3.	Click administration
      4.	Click manage visit reasons
      5.	Assert text manage visit reasons.
      6.	Click logout
      7.	Login as admin@test.com and use 12345 as password
      8.	click administration
      9.	assert manage visit reasons not present
      10.	go to http://cvms.identitysecurity.info/index.php?r=visitReason/admin
      11.	assert text You are not authorized to perform this action.
      14.	go to http://cvms.identitysecurity.info/index.php?r=visitReason/update
      15.	assert text You are not authorized to perform this action.
      16.	Click logout
      17.	Login as agentadmin@test.com and use 12345 as password
      18.	click administration
      19.	assert manage visit reasons not present
      20.	go to http://cvms.identitysecurity.info/index.php?r=visitReason/admin
      21.	assert text You are not authorized to perform this action.
      24.	go to http://cvms.identitysecurity.info/index.php?r=visitReason/update
      25.	assert text You are not authorized to perform this action.
     */

    function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->assertEquals("Manage Visit Reasons", $this->getText("//div[@id='cssmenu']/ul/li[5]/a/span"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login("admin@test.com", '12345');
        $this->clickAndWait("link=Administration");
        $this->assertFalse($this->isTextPresent("//div[@id='cssmenu']/ul/li[5]/a/span"));
        $this->open("http://cvms.identitysecurity.info/index.php?r=visitReason/admin");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
        $this->open("http://cvms.identitysecurity.info/index.php?r=visitReason/update");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
    }

    /* Scenario 5 – Log in as super admin and check for validations
      Expected Behavior
      -	Assert text reason has already been taken
      -	Assert text “This is a valid reason ?!.,’”()@#$%^&*-+” in manage reason field

      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Login as superadmin@test.com and use 12345 as password
      3.	Click administration
      4.	Click manage visit reasons
      5.	Click Add reason
      6.	Type “ this is a reason ”. Then click add.
      7.	Wait for page to load, then type this is a reason in reason filter.
      8.	Assert text “This is a reason”.
      9.	Click add button.
      10.	Wait for page to load then type “THIS IS A REASON” in reason field.
      11.	Click Add button
      12.	Assert text reason has already been taken.
      13.	Click add reason, then type “This is a valid reason ?!.,’”()@#$%^&*-+”
      14.	Click add button
      15.	Wait for page to load
      16.	Type This is a valid reason ?!.,’”()@#$%^&*-+ in reason filter
      17.	Assert text This is a valid reason ?!.,’”()@#$%^&*-+
     */

    function Scenario5() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[5]/a/span");
        $this->clickAndWait("css=li.has-sub.active > ul > li.odd > a.addSubMenu > span");
        $this->type("id=VisitReason_reason", "This is a reason");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("This Is A Reason", $this->getText("css=tr.odd > td"));
        $this->clickAndWait("css=li.has-sub.active > ul > li.odd > a.addSubMenu > span");
        $this->type("id=VisitReason_reason", " THIS IS A REASON ");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Reason \"THIS IS A REASON\" has already been taken.", $this->getText("css=div.errorSummary > ul > li"));
        $this->clickAndWait("css=li.has-sub.active > ul > li.odd > a.addSubMenu > span");
        
        $this->type("id=VisitReason_reason", "This is a valid reason ?!.,’”()@#$%^&*-+");
        $this->clickAndWait("name=yt0");
        
        $this->type("name=VisitReason[reason]", "This is a valid reason ?!.,’”()@#$%^&*-+");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("This Is A Valid Reason ?!.,’”()@#$%^&*-+" == $this->getText("css=tr.odd > td"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("This Is A Valid Reason ?!.,’”()@#$%^&*-+", $this->getText("css=tr.odd > td"));
       
    }

}

?>
