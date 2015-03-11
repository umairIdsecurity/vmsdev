<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue122FunctionalTest
 * @author Jeremiah
 */
class Issue122FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
    }

    /* Scenario 1 – Login as admin. Delete workstation assert not present in table 
     */

    function Scenario1() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.manageworkstations > span");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.addSubMenu > span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Workstation_name", "New workstation");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Visitor Management System - Admin Workstation", $this->getTitle());
        $this->assertEquals("New workstation", $this->getText("css=tr.odd > td"));
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->type("name=Workstation[name]", "new");
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

        $this->assertEquals("No results found.", $this->getText("css=td.empty"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.manageworkstations > span");
        $this->waitForPageToLoad("30000");
        $this->type("name=Workstation[name]", "new");
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
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Workstations");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->assertEquals("An exisitng user is linked to this workstation. Please remove workstation assignment first.", $this->getAlert());
        $this->click("id=yt1");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->chooseCancelOnNextConfirmation();
        $this->click("id=yt1");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->click("css=a.manageworkstations > span");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt1");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->assertEquals("An exisitng user is linked to this workstation. Please remove workstation assignment first.", $this->getAlert());
    }

}

?>