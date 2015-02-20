<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue48FunctionalTest
 * Preregister a visitor
 * @author Jeremiah
 */
class Issue48FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->issue48Sql();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
    }

    /* Scenario 1 – Login as superadmin, delete a visitor with no visit

      Expected Behavior
      -	Assert testvisitor4@test.com not present in table.
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=a.managevisitorrecords > span");
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->type("name=Visitor[email]", "testVisitor4@test.com");
        $this->click("name=Visitor[email]");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("No results found." == $this->getText("css=span.empty"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
    }

    /* Scenario 2 – Login as superadmin, delete a visitor with preregistered and active visit

      Expected Behavior
      -	Assert testvisitor3@test.com is not deleted
      - Assert This record has an open visit and must be cancelled before deleting.
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("link=Manage Visitor Records");
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->assertEquals("This record has an open visit and must be cancelled before deleting.", $this->getAlert());
        $this->click("//div[@id='visitor-grid']/table/tbody/tr/td[3]");
        $this->assertEquals("testVisitor3@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
    }

    /* Scenario 3 – Login as superadmin, delete a visitor with closed and expired visit. 

      Expected Behavior
      -	Assert testvisitor1@test.com is not deleted
     * Assert all visits attached to testvisitor1@test.com are deleted
     * Assert This Visitor Record has visit data recorded. Do you wish to delete this visitor record and its visit history?
     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=a.managevisitorrecords > span");
        $this->click("id=yt1");
        $this->chooseCancelOnNextConfirmation();
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->assertTrue((bool) preg_match('/^This Visitor Record has visit data recorded\. Do you wish to delete this visitor record and its visit history[\s\S]$/', $this->getConfirmation()));
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr[2]/td[3]"));
        $this->click("id=yt1");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->assertTrue((bool) preg_match('/^This Visitor Record has visit data recorded\. Do you wish to delete this visitor record and its visit history[\s\S]$/', $this->getConfirmation()));
        $this->type("name=Visitor[email]", "testvisitor1@test.com");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("No results found." == $this->getText("css=span.empty"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->type("name=Visit[lastname]", "visitor1");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("No results found." == $this->getText("css=span.empty"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
    }

}

?>