<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue137FunctionalTest
 * @author Jeremiah
 */class Issue137FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
    }

    /* Scenario 1 – Check sort filters for all tables
      Expected Behavior: Click up and down filters then check if data are correctly displayed.
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Status");
        $this->click("link=Last Name");
        $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Visitor4" == $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[7]/td[4]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Visitor4", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[7]/td[4]"));
        $this->click("link=Last Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Visitor1" == $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[7]/td[4]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Visitor4", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[4]"));
        $this->assertEquals("Visitor1", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[7]/td[4]"));
        $this->click("link=Contact Email");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Visitor4" == $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[7]/td[4]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[7]/td[7]"));
        $this->click("link=Contact Email");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("testVisitor4@test.com" == $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr[7]/td[7]"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->click("link=Last Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Visitor4" == $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[7]/td[5]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Visitor1", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("Visitor4", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[7]/td[5]"));
        $this->click("link=Contact Email");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("testVisitor1@test.com" == $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[7]/td[8]"));
        $this->click("link=Contact Email");

        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("testVisitor1@test.com" == $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr[7]/td[8]"));
        $this->click("link=Contact Email");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.asc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("", $this->getText("css=a.sort-link.asc > div"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt7");
        $this->waitForElementPresent("link=Company Name");
        $this->click("link=Company Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.asc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Company Name", $this->getText("link=Company Name"));
        $this->click("link=Company Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("", $this->getText("css=a.sort-link.desc > div"));
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Philippine Airline" == $this->getText("css=tr.odd > td"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Philippine Airline", $this->getText("css=tr.odd > td"));
        $this->assertEquals("Identity Security", $this->getText("//div[@id='company-grid']/table/tbody/tr[3]/td"));
        $this->click("css=a.sort-link.desc > div");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Identity Security" == $this->getText("css=tr.odd > td"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Identity Security", $this->getText("css=tr.odd > td"));
        $this->assertEquals("Philippine Airline", $this->getText("//div[@id='company-grid']/table/tbody/tr[3]/td"));
        $this->click("link=Trading/Display Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.asc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Identity Security", $this->getText("//div[@id='company-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Philippine Airline", $this->getText("//div[@id='company-grid']/table/tbody/tr[3]/td[2]"));
        $this->click("link=Trading/Display Name");
        $this->waitForElementPresent("css=a.sort-link.asc > div");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.asc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->click("css=a.manageworkstations > span");
        $this->waitForPageToLoad("30000");
        $this->click("link=Name");
        $this->waitForElementPresent("css=a.sort-link.asc > div");

        $this->assertEquals("Workstation1", $this->getText("css=tr.odd > td"));
        $this->assertEquals("Workstation3", $this->getText("//div[@id='workstation-grid']/table/tbody/tr[3]/td"));
        $this->click("css=a.sort-link.asc > div");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Workstation3", $this->getText("css=tr.odd > td"));
        $this->assertEquals("Workstation1", $this->getText("//div[@id='workstation-grid']/table/tbody/tr[3]/td"));
        $this->click("link=Manage Users");
        $this->waitForPageToLoad("30000");
        $this->click("link=Last Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.asc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("admin", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->click("link=Last Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("staffmember", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("admin", $this->getText("//div[@id='user-grid']/table/tbody/tr[7]/td[2]"));
        $this->click("link=Role");
        $this->waitForElementPresent("css=a.sort-link.asc > div");
        $this->assertEquals("Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Staff Member", $this->getText("//div[@id='user-grid']/table/tbody/tr[7]/td[3]"));
        $this->click("link=Role");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Staff Member", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr[7]/td[3]"));
        $this->click("css=a.managevisitorrecords > span");
        $this->waitForPageToLoad("30000");
        $this->click("link=Last Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.asc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Visitor1", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Visitor4", $this->getText("//div[@id='visitor-grid']/table/tbody/tr[3]/td[2]"));
        $this->click("link=Last Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Visitor4", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Visitor1", $this->getText("//div[@id='visitor-grid']/table/tbody/tr[3]/td[2]"));
        $this->click("link=Email Address");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("testVisitor1@test.com" == $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr[3]/td[3]"));
        $this->assertEquals("", $this->getText("css=a.sort-link.asc > div"));
        $this->click("link=Email Address");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr[3]/td[3]"));
        $this->click("//div[@id='cssmenu']/ul/li[4]/ul/li/a/span");
        $this->waitForPageToLoad("30000");
        $this->click("link=Log Visit");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->click("link=Find Visitor Profile");
        $this->select("id=search_visitor_tenant", "label=NAIA Airport");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Please select a tenant agent Philippine Airline" == $this->getText("id=search_visitor_tenant_agent"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->select("id=search_visitor_tenant_agent", "label=Philippine Airline");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("id=2"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->click("link=First Name");
        $this->click("link=Last Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.asc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->click("link=Last Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Visitor4", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("Visitor1", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr[3]/td[2]"));
        $this->click("link=Email Address");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.asc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr[3]/td[3]"));
        $this->click("link=Email Address");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr[3]/td[3]"));
        $this->select("id=workstation_search", "label=Workstation1");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->click("id=4");
        $this->click("id=clicktabB1");
        $this->click("link=Find Host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=18");

        $this->click("link=Email Address");
        $this->waitForElementPresent("css=a.sort-link.asc > div");

        $this->assertEquals("agentadmin@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("testHost1@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[4]/td[3]"));
        $this->click("link=Email Address");
        try {
            $this->assertTrue($this->isElementPresent("link=Email Address"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->waitForElementPresent("css=a.sort-link.desc > div");
        $this->assertEquals("agentadmin@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("testHost1@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[4]/td[3]"));
        $this->click("//div[@id='cssmenu']/ul/li[4]/ul/li[4]/a/span");
        $this->waitForPageToLoad("30000");
        $this->click("link=Last Name");
        $this->waitForElementPresent("css=a.sort-link.asc > div");
        $this->assertEquals("", $this->getText("css=a.sort-link.asc > div"));
        $this->assertEquals("Visitor1", $this->getText("//div[@id='view-export-visitor-records']/table/tbody/tr/td[3]"));
        $this->click("link=Last Name");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Visitor4", $this->getText("//div[@id='view-export-visitor-records']/table/tbody/tr/td[3]"));
        $this->assertEquals("Visitor1", $this->getText("//div[@id='view-export-visitor-records']/table/tbody/tr[7]/td[3]"));
        $this->click("link=Contact Email");
        $this->waitForElementPresent("css=a.sort-link.asc > div");
        $this->assertEquals("", $this->getText("css=a.sort-link.asc > div"));
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='view-export-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='view-export-visitor-records']/table/tbody/tr[7]/td[5]"));
        $this->click("link=Contact Email");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='view-export-visitor-records']/table/tbody/tr/td[5]"));
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='view-export-visitor-records']/table/tbody/tr[7]/td[5]"));
        $this->click("id=yt6");
        $this->waitForElementPresent("link=Visitor Registration History");
        $this->click("link=Visitor Registration History");
        $this->waitForPageToLoad("30000");
        $this->click("//div[@id='cssmenu']/ul/li[8]/ul/li/a/span");
        $this->waitForPageToLoad("30000");
        $this->click("link=Status");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.asc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->click("link=Status");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->click("//div[@id='cssmenu']/ul/li[8]/ul/li[2]/a/span");
        $this->waitForPageToLoad("30000");
        $this->click("link=Visitor Type");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.asc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->click("css=a.sort-link.asc > div");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.desc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
    }

    /* Scenario 2 - Check company column present in manage users table, check filter */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->assertEquals("Company", $this->getText("id=user-grid_c5"));
        $this->type("name=User[companyname]", "NAIA");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("NAIA Airport" == $this->getText("//div[@id='user-grid']/table/tbody/tr/td[6]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("NAIA Airport", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[6]"));
        $this->type("name=User[companyname]", "Phili");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Philippine Airline" == $this->getText("//div[@id='user-grid']/table/tbody/tr/td[6]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Philippine Airline", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[6]"));
    }

    /* Scenario 3 - Check email address column present in manage users table, check filter */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Email Address", $this->getText("link=Email Address"));
        $this->click("link=Email Address");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("link=Email Address"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=a.sort-link.asc > div"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("admin2@test.com", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[8]"));
        $this->assertEquals("testHost1@test.com", $this->getText("//div[@id='user-grid']/table/tbody/tr[7]/td[8]"));
        $this->type("name=User[email]", "admin");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("admin2@test.com" == $this->getText("//div[@id='user-grid']/table/tbody/tr/td[8]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("admin2@test.com", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[8]"));
        $this->assertEquals("agentadmin@test.com", $this->getText("//div[@id='user-grid']/table/tbody/tr[3]/td[8]"));
    }

}

?>