<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue112FunctionalTest
 * @author Jeremiah
 */
class Issue112FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
//        $this->resetDbWithData();
//        $this->scenariosForSuperadmin();
        $this->resetDbWithData();
        $this->scenariosForSuperadminDataControl();
        $this->scenariosForAdminDataControl();
        $this->scenariosForAdminAgentDataControl();
        $this->scenariosForOperatorDataControl();
        $this->scenariosForAgentOperatorDataControl();
    }

    function scenariosForSuperadmin() {
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
    }

    function scenariosForSuperadminDataControl() {
        $this->Scenario6();
    }

    function scenariosForAdminDataControl() {
        $this->Scenario7();
        $this->Scenario8();
        $this->Scenario9();
        $this->Scenario10();
    }

    function scenariosForAdminAgentDataControl() {
        $this->Scenario11();
        $this->Scenario12();
        $this->Scenario13();
        $this->Scenario14();
    }

    function scenariosForOperatorDataControl() {
        $this->Scenario15();
        $this->Scenario16();
        $this->Scenario17();
    }

    function scenariosForAgentOperatorDataControl() {
        $this->Scenario18();
    }

    /* Scenario 1 – Add new administrator, add new company kalibo
      Expected Behavior –
      Assert kalibo@test.com in table

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Add Administrator");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Please select a company NAIA Airport Philippine Airline", $this->getText("id=User_company"));
        $this->click("id=addCompanyLink");
        $this->waitForElementPresent("id=Company_name");
        $this->type("id=Company_name", "Kalibo Airport");
        $this->type("id=Company_code", "KAL");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->type("id=User_first_name", "kalibo");
        $this->type("id=User_last_name", "kalibo");
        $this->type("id=User_email", "kalibo@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("kalibo", $this->getText("css=tr.odd > td"));
        $this->assertEquals("kalibo", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->clickAndWait("css=li.submenu.addSubMenu > a > span");
        $this->assertEquals("Please select a company NAIA Airport Philippine Airline Kalibo Airport", $this->getText("id=User_company"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $this->login("kalibo@test.com", '12345');
        $this->assertEquals("Logged in as kalibo@test.com - Administrator", $this->getText("link=Logged in as kalibo@test.com - Administrator"));
        $this->clickAndWait("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Displaying 1-1 of 1 result", $this->getText("css=div.summary"));
    }

    /* Scenario 2 – Add agent admin for kalibo
      Expected Behavior –
      Assert agentadminkalibo@test.com in table

     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[3]/ul/li[3]/a/span");
        $this->assertEquals("Please select a tenant NAIA Airport Kalibo Airport", $this->getText("id=User_tenant"));
        $this->select("id=User_tenant", "label=Kalibo Airport");
        $this->assertEquals("", $this->getText("id=User_company"));
        $this->click("id=addCompanyLink");
        $this->waitForElementPresent("id=Company_name");
        $this->type("id=Company_name", "Philippine Airline - Kalibo");
        $this->type("id=Company_code", "PAL");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        sleep(1);
        $this->assertEquals("Philippine Airline - Kalibo", $this->getText("id=User_company"));
        $this->type("id=User_first_name", "TEST");
        $this->type("id=User_first_name", "agentadminkalibo");
        $this->type("id=User_last_name", "agentadminkalibo");
        $this->type("id=User_email", "agentadminkalibo@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("agentadminkalibo", $this->getText("css=tr.odd > td"));
        $this->assertEquals("agentadminkalibo", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->click("//div[@id='cssmenu']/ul/li[3]/ul/li[3]/a/span");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_tenant", "label=Kalibo Airport");
        sleep(1);
        $this->assertEquals("Philippine Airline - Kalibo", $this->getText("id=User_company"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'kalibo@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Displaying 1-2 of 2 results", $this->getText("css=div.summary"));
        $this->assertEquals("agentadminkalibo", $this->getText("css=tr.odd > td"));
        $this->click("//div[@id='cssmenu']/ul/li[3]/ul/li[3]/a/span");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Please select a company Philippine Airline - Kalibo", $this->getText("id=User_company"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'agentadminkalibo@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("agentadminkalibo", $this->getText("css=tr.odd > td"));
        $this->assertEquals("Displaying 1-1 of 1 result", $this->getText("css=div.summary"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->type("name=User[first_name]", "kalibo");
        sleep(1);
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

    /* Scenario 3 – Add operator for kalibo
      Expected Behavior
      Assert  operatorkalibo.com  for operator

     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.manageworkstations > span");
        $this->waitForPageToLoad("30000");
        $this->click("//div[@id='cssmenu']/ul/li[2]/ul/li/a/span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Workstation_name", "workstation for KAL");
        $this->select("id=Workstation_tenant", "label=Kalibo Airport");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("workstation for KAL", $this->getText("css=tr.odd > td"));
        $this->click("id=yt4");
        $this->click("//div[@id='cssmenu']/ul/li[3]/ul/li[4]/a/span");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_tenant", "label=Kalibo Airport");
        sleep(1);
        $this->assertEquals("workstation for KAL", $this->getText("id=User_workstation"));
        $this->type("id=User_first_name", "operator");
        $this->type("id=User_first_name", "operatorkalibo");
        $this->type("id=User_last_name", "operatorkalibo");
        $this->type("id=User_email", "operatorkalibo@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("operatorkalibo", $this->getText("css=tr.odd > td"));
        $this->assertEquals("workstation for KAL", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[4]"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'operatorkalibo@test.com';
        $this->login($username, '12345');
        $this->assertEquals("workstation for KAL", $this->getText("id=userWorkstation"));
        $this->click("id=submitBtn");
        $this->click("id=submit");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("workstation for KAL", $this->getText("css=h1"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $username = 'kalibo@test.com';
        $this->login($username, '12345');
        $this->assertEquals("workstation for KAL", $this->getText("css=h1"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Displaying 1-3 of 3 results", $this->getText("css=div.summary"));
        $this->assertEquals("operatorkalibo", $this->getText("css=tr.odd > td"));
    }

    /* Scenario 4 – Add agent operator for kalibo
      Expected Behavior
      Assert  agentoperatorkalibo.com  for agent operator
     */

    function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.manageworkstations > span");
        $this->waitForPageToLoad("30000");
        $this->click("//div[@id='cssmenu']/ul/li[2]/ul/li/a/span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Workstation_name", "workstation for PAL-KAL");
        $this->select("id=Workstation_tenant", "label=Kalibo Airport");
        $this->select("id=Workstation_tenant_agent", "label=Philippine Airline - Kalibo");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("workstation for PAL-KAL", $this->getText("css=tr.odd > td"));
        $this->click("id=yt6");
        $this->click("//div[@id='cssmenu']/ul/li[3]/ul/li[5]/a/span");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_tenant", "label=Kalibo Airport");
        $this->click("id=User_tenant_agent");
        $this->select("id=User_tenant_agent", "label=Philippine Airline - Kalibo");
        $this->assertEquals("workstation for PAL-KAL", $this->getText("id=User_workstation"));
        $this->type("id=User_first_name", "agentopkalibo");
        $this->type("id=User_last_name", "agentopkalibo");
        $this->type("id=User_email", "agentopkalibo@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("agentopkalibo", $this->getText("css=tr.odd > td"));
        $this->assertEquals("workstation for PAL-KAL", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[4]"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'kalibo@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("agentopkalibo", $this->getText("css=tr.odd > td"));
        $this->assertEquals("workstation for PAL-KAL", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[4]"));
    }

    /* Scenario 5 – Add staff member for kalibo
      Expected Behavior
      Assert  staffmember@test.com for kalibo
     */

    function Scenario5() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.has-sub-sub > span");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_role", "label=Staff Member");
        $this->select("id=User_tenant", "label=Kalibo Airport");
        $this->assertEquals("Please select a tenant agentPhilippine Airline - Kalibo", $this->getText("id=User_tenant_agent"));
        $this->type("id=User_first_name", "staff1");
        $this->type("id=User_last_name", "staff1");
        $this->type("id=User_email", "staff1@test.com");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->type("id=User_contact_number", "12345");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("staff1", $this->getText("css=tr.odd > td"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "kalibo@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        try {
            $this->assertEquals("staff1", $this->getText("css=tr.odd > td"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->assertEquals("staff1", $this->getText("css=tr.odd > td"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "agentadminkalibo@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertFalse($this->isTextPresent("css=tr.odd > td"));
    }

    /* Scenario 6 – login as superadmin and check for data controls 
      Expected Behavior
      o	IDsecurity should not be included in company dropdown
      o	In adding administrator – all companies except idsecurity should be shown
      o	In adding agent admin – Companies’ under selected tenant except tenant’s company
      o	In adding agent operator – all companies where tenant and tenant agent is equals to selected tenant and tenant agent
      o	In adding operator – company of selected tenant
      o	In adding staff member – if tenant is selected, company of tenant should be the company of staff member. If tenant agent is selected, company of tenant agent should be the company of staff member.
      o	Kalibo airport should not see Philippine airline in tenant agent
      o	NAIA should not see Philippine airline – kalibo in tenant agent
      o	Kalibo Airport should be allowed to add tenant agent company with same code (PAL)
      o	In workstation – NAIA should see all workstation with same tenant only, if tenant agent is not selected. If a tenant agent is selected NAIA should not see workstation in dropdown.
      o	In workstation – if NAIA is selected in tenant, PAL is selected in tenant agent. Workstation should be all workstation with same tenant and tenant agent.
      o	In preregister/log a visit – tenant and tenant agent of visitor and host should be the same. If from search visitor, selected tenant and tenant agent if visitor will be the tenant and tenant agent of host
     */

    function Scenario6() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.has-sub-sub > span");
        $this->waitForPageToLoad("30000");
        $this->click("css=li.submenu.addSubMenu > a > span");
        $this->waitForPageToLoad("30000");
        sleep(1);
        $this->assertEquals("Please select a company NAIA Airport Philippine Airline", $this->getText("id=User_company"));
        $this->type("id=User_first_name", "kalibo");
        $this->type("id=User_last_name", "kalibo");
        $this->type("id=User_email", "kalibo@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->click("id=addCompanyLink");
        $this->waitForElementPresent("id=Company_name");
        $this->type("id=Company_name", "Kalibo Airport");
        $this->type("id=Company_code", "KAL");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        sleep(1);
        $this->assertEquals("Please select a company NAIA AirportPhilippine AirlineKalibo Airport", $this->getText("id=User_company"));
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("kalibo", $this->getText("css=tr.odd > td"));
        $this->click("link=Add Administrator");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Please select a company NAIA Airport Philippine Airline Kalibo Airport", $this->getText("id=User_company"));
        $this->click("link=Add Agent Administrator");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Please select a tenant NAIA Airport Kalibo Airport", $this->getText("id=User_tenant"));
        $this->select("id=User_tenant", "label=NAIA Airport");
        sleep(1);
        $this->assertEquals("Philippine Airline", $this->getText("id=User_company"));
        $this->select("id=User_tenant", "label=Kalibo Airport");
        $this->assertEquals("", $this->getText("id=User_company"));
        $this->click("id=addCompanyLink");
        $this->waitForElementPresent("id=Company_name");
        $this->type("id=Company_name", "Philippine Airline - Kalibo");
        $this->type("id=Company_code", "PAL");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        sleep(1);
        $this->assertEquals("Philippine Airline - Kalibo", $this->getText("id=User_company"));
        $this->type("id=User_first_name", "agentadminkalibo");
        $this->type("id=User_last_name", "agentadminkalibo");
        $this->type("id=User_email", "agentadminkalibo@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("agentadminkalibo", $this->getText("css=tr.odd > td"));
        $this->assertEquals("Agent Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->click("link=Add Agent Administrator");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_tenant", "label=Kalibo Airport");
        sleep(1);
        $this->assertEquals("Philippine Airline - Kalibo", $this->getText("id=User_company"));
        $this->select("id=User_tenant", "label=NAIA Airport");
        sleep(1);
        $this->assertEquals("Philippine Airline", $this->getText("id=User_company"));
        $this->click("//div[@id='cssmenu']/ul/li[3]/ul/li[5]/a/span");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Please select a tenant NAIA Airport Kalibo Airport", $this->getText("id=User_tenant"));
        $this->select("id=User_tenant", "label=NAIA Airport");
        sleep(1);
        $this->assertEquals("Please select a tenant agentPhilippine Airline", $this->getText("id=User_tenant_agent"));
        $this->select("id=User_tenant", "label=Kalibo Airport");
        sleep(1);
        $this->assertEquals("Please select a tenant agentPhilippine Airline - Kalibo", $this->getText("id=User_tenant_agent"));
        $this->select("id=User_tenant_agent", "label=Philippine Airline - Kalibo");
        $this->click("css=a.manageworkstations > span");
        $this->waitForPageToLoad("30000");
        $this->click("//div[@id='cssmenu']/ul/li[2]/ul/li/a/span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Workstation_name", "workstation for PAL-KAL");
        $this->select("id=Workstation_tenant", "label=Kalibo Airport");
        sleep(1);
        $this->assertEquals("Please select a tenant agent Philippine Airline - Kalibo", $this->getText("id=Workstation_tenant_agent"));
        $this->select("id=Workstation_tenant_agent", "label=Philippine Airline - Kalibo");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt5");
        $this->click("//div[@id='cssmenu']/ul/li[3]/ul/li[5]/a/span");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_tenant", "label=Kalibo Airport");
        sleep(1);
        $this->select("id=User_tenant_agent", "label=Philippine Airline - Kalibo");
        sleep(1);
        $this->assertEquals("workstation for PAL-KAL", $this->getText("id=User_workstation"));
        $this->type("id=User_first_name", "agentopkalibo");
        $this->type("id=User_last_name", "agentopkalibo");
        $this->type("id=User_email", "agentopkalibo@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("agentopkalibo", $this->getText("css=tr.odd > td"));
        $this->assertEquals("agentopkalibo", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Displaying 1-7 of 7 results", $this->getText("css=div.summary"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "kalibo@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("agentopkalibo", $this->getText("css=tr.odd > td"));
        $this->assertEquals("workstation for PAL-KAL", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[4]"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("//div[@id='cssmenu']/ul/li[3]/ul/li[4]/a/span");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Please select a tenant NAIA Airport Kalibo Airport", $this->getText("id=User_tenant"));
        $this->select("id=User_tenant", "label=NAIA Airport");
        sleep(1);
        $this->assertEquals("Workstation3", $this->getText("id=User_workstation"));
        $this->select("id=User_tenant", "label=Kalibo Airport");
        $this->click("id=User_workstation");
        $this->click("css=a.has-sub-sub");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_role", "label=Staff Member");
        $this->assertEquals("Please select a tenant NAIA Airport Kalibo Airport", $this->getText("id=User_tenant"));
        $this->select("id=User_tenant", "label=NAIA Airport");
        sleep(1);
        $this->assertEquals("Please select a tenant agentPhilippine Airline", $this->getText("id=User_tenant_agent"));
        $this->select("id=User_tenant_agent", "label=Philippine Airline");
        $this->select("id=User_tenant", "label=Kalibo Airport");
        sleep(1);
        $this->assertEquals("Please select a tenant agentPhilippine Airline - Kalibo", $this->getText("id=User_tenant_agent"));
        $this->select("id=User_tenant_agent", "label=Philippine Airline - Kalibo");
        $this->click("css=a.manageworkstations > span");
        $this->waitForPageToLoad("30000");
        $this->click("//div[@id='cssmenu']/ul/li[2]/ul/li/a/span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Workstation_name", "workstation for NAIA");
        $this->select("id=Workstation_tenant", "label=Kalibo Airport");
        $this->select("id=Workstation_tenant", "label=NAIA Airport");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Please select a tenant agent Philippine Airline" == $this->getText("id=Workstation_tenant_agent"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("workstation for NAIA", $this->getText("css=tr.odd > td"));
        $this->click("//div[@id='cssmenu']/ul/li[2]/ul/li/a/span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Workstation_name", "workstation for PAL");
        $this->select("id=Workstation_tenant", "label=NAIA Airport");
        sleep(1);
        $this->select("id=Workstation_tenant_agent", "label=Philippine Airline");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("workstation for PAL", $this->getText("css=tr.odd > td"));
        $this->click("//div[@id='cssmenu']/ul/li[2]/ul/li/a/span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Workstation_name", "workstation for KAL");
        $this->select("id=Workstation_tenant", "label=Kalibo Airport");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("workstation for KAL", $this->getText("css=tr.odd > td"));
        $this->click("id=yt8");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Add Operator" == $this->getText("//div[@id='cssmenu']/ul/li[3]/ul/li[4]/a/span"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->click("//div[@id='cssmenu']/ul/li[3]/ul/li[4]/a/span");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_tenant", "label=NAIA Airport");
        sleep(1);
        $this->assertEquals("Workstation3workstation for NAIA", $this->getText("id=User_workstation"));
        $this->select("id=User_tenant", "label=Kalibo Airport");
        sleep(1);
        $this->assertEquals("workstation for KAL", $this->getText("id=User_workstation"));
        $this->click("link=Add Agent Operator");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_tenant", "label=NAIA Airport");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Please select a tenant agentPhilippine Airline" == $this->getText("id=User_tenant_agent"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->select("id=User_tenant_agent", "label=Philippine Airline");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Workstation1Workstation2workstation for PAL" == $this->getText("id=User_workstation"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Workstation1Workstation2workstation for PAL", $this->getText("id=User_workstation"));
        $this->select("id=User_tenant", "label=Kalibo Airport");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Please select a tenant agentPhilippine Airline - Kalibo" == $this->getText("id=User_tenant_agent"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->select("id=User_tenant_agent", "label=Philippine Airline - Kalibo");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("workstation for PAL-KAL" == $this->getText("id=User_workstation"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("workstation for PAL-KAL", $this->getText("id=User_workstation"));
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        $this->click("id=addCompanyLink");
        $this->waitForElementPresent("id=Company_name");

        $this->type("id=Company_name", "Japan Airline");
        $this->type("id=Company_code", "JAL");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        $this->waitForElementPresent("id=Visitor_company");
        sleep(1);
        $this->assertEquals("Japan Airline", $this->getText("id=Visitor_company"));
        $this->assertEquals("Please select a workstation Workstation3workstation for NAIA", $this->getText("id=workstation"));

        $this->select("id=Visitor_tenant", "label=Kalibo Airport");
        sleep(1);
        $this->assertEquals("Please select a tenant agentPhilippine Airline - Kalibo", $this->getText("id=Visitor_tenant_agent"));
        $this->click("id=addCompanyLink");
        $this->waitForElementPresent("id=Company_name");
        $this->type("id=Company_name", "Japan Airline - Kalibo");
        $this->type("id=Company_code", "JAL");
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
        sleep(1);
        $this->assertEquals("Japan Airline - Kalibo", $this->getText("id=Visitor_company"));
        $this->select("id=workstation", "label=workstation for KAL");
        $this->type("id=Visitor_first_name", "testvisitor");
        $this->type("id=Visitor_last_name", "testvisitor");
        $this->type("id=Visitor_email", "testvisitor@test.com");
        $this->type("id=Visitor_vehicle", "123456");
        $this->type("id=Visitor_contact_number", "12345");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->click("id=submitFormVisitor");
        $this->click("css=#register-host-form > div.register-a-visitor-buttons-div > #btnBackTab3");
        $this->select("id=Visitor_tenant_agent", "label=Philippine Airline - Kalibo");
        sleep(1);
        $this->assertEquals("Philippine Airline - Kalibo", $this->getText("id=Visitor_company"));
        $this->assertEquals("Please select a workstation workstation for PAL-KAL", $this->getText("id=workstation"));
        $this->select("id=workstation", "label=workstation for PAL-KAL");
        $this->click("id=submitFormVisitor");
    }

    /* Scenario 7: Login as administrator and check data control
      Expected behavior:
      In adding administrator/operator/staff member – company should be the same with tenant’s company (NAIA)
      In adding agent administrator – company should be all company of tenant except tenant’s company. Philippine airlines should be in dropdown
      In adding operator – all workstation with same tenant only should be displayed
      In search visitor and host – records should be the same tenant only
     */

    function Scenario7() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=li.submenu.addSubMenu > a > span");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("2", $this->getEval("window.document.getElementById(\"User_company\").value"));
        $this->click("css=a.has-sub-sub");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_role", "label=Agent Administrator");
        $this->assertEquals("Please select a company Philippine Airline Japan Airline", $this->getText("id=User_company"));
        $this->select("id=User_role", "label=Operator");
        sleep(1);
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Workstation3workstation for NAIA" == $this->getText("id=User_workstation"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Workstation3workstation for NAIA", $this->getText("id=User_workstation"));
        $this->assertEquals("2", $this->getEval("window.document.getElementById(\"User_company\").value"));
        $this->select("id=User_role", "label=Staff Member");
        $this->assertEquals("2", $this->getEval("window.document.getElementById(\"User_company\").value"));
    }

    /* Scenario 8: Check data control in preregister/log visit
      Expected Behavior:
      Workstation should display all workstations with same tenant only. Assert workstation for NAIA in dropdown.
      Company dropdown should be all companies under tenant except tenant’s company. Assert Philippine airline in company. Assert NAIA not present in company.
      In search visitor profile, assert testvisitor1@test.com in table only. Assert workstation for NAI in workstation dropdown
      In search host, all users with same tenant. Assert admin, operator, admin2 in table

     */

    function Scenario8() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.sidemenu-icon.pre-visits > span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        sleep(1);
        $this->assertEquals("Please select a workstation Workstation3workstation for NAIA", $this->getText("id=workstation"));
        $this->select("id=workstation", "label=workstation for NAIA");
        $this->assertEquals("Japan Airline", $this->getText("id=Visitor_company"));
        $this->type("id=Visitor_first_name", "visitor");
        $this->type("id=Visitor_last_name", "visitor");
        $this->type("id=Visitor_email", "visitor@test.com");
        $this->type("id=Visitor_vehicle", "123456");
        $this->type("id=Visitor_contact_number", "123456");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->click("id=submitFormVisitor");
        $this->assertEquals("2", $this->getEval("window.document.getElementById(\"User_company\").value"));
        $this->click("css=#register-host-form > div.register-a-visitor-buttons-div > #btnBackTab3");
        $this->click("link=Search Visitor Profile");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        sleep(1);
        $this->waitForElementPresent("id=workstation_search");
        $this->assertEquals("Please select a workstation Workstation3workstation for NAIA", $this->getText("id=workstation_search"));

        $this->click("css=ul.nav.nav-tabs > li > a");
        $this->click("id=submitFormVisitor");
        $this->click("link=Search Host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("//div[@id='findHost-grid']/table/tbody/tr/td[2]");
        $this->assertEquals("admin", $this->getText("//div[@id='findHost-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("operator", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[2]/td[2]"));
        $this->assertEquals("admin2", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[3]/td[2]"));
    }

    /* Scenario 9: Check data control in manage workstations
      Expected Behavior:
      Assert second workstation NAIA in workstation dropdowns

     */

    function Scenario9() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.manageworkstations > span");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.addSubMenu > span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Workstation_name", "second workstation for NAIA");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("second workstation for NAIA", $this->getText("css=tr.odd > td"));
        $this->click("id=yt6");
        $this->click("css=a.has-sub-sub > span");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_role", "label=Operator");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Workstation3workstation for NAIAsecond workstation for NAIA" == $this->getText("id=User_workstation"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Workstation3workstation for NAIAsecond workstation for NAIA", $this->getText("id=User_workstation"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.sidemenu-icon.pre-visits > span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        sleep(1);
        $this->assertEquals("Please select a workstation Workstation3workstation for NAIAsecond workstation for NAIA", $this->getText("id=workstation"));
        $this->click("link=Search Visitor Profile");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ($this->isElementPresent("id=workstation_search"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        sleep(1);
        $this->assertEquals("Please select a workstation Workstation3workstation for NAIAsecond workstation for NAIA", $this->getText("id=workstation_search"));
        $this->click("css=ul.nav.nav-tabs > li > a");
        $this->select("id=workstation", "label=second workstation for NAIA");
    }

    /* Scenario 10: : Check data control in add visitor profile and add host
      Expected Behavior:
      Assert second workstation NAIA in workstation dropdowns

     */

    function Scenario10() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt0");
        $this->waitForElementPresent("id=User_first_name");
        $this->type("id=User_first_name", "newhost");
        $this->type("id=User_last_name", "newhost");
        $this->type("id=User_email", "newhost@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        sleep(1);
        $this->select("id=workstation", "label=workstation for NAIA");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_email", "newvisitor@test.com");
        $this->type("id=Visitor_contact_number", "12345");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->click("id=submitFormVisitor");
        $this->click("link=Search Host");
        $this->type("id=search-host", "new");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("//div[@id='findHost-grid']/table/tbody/tr/td[3]");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Select Host" == $this->getText("id=27"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("newhost@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr/td[3]"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.submenu-icon.addvisitorprofile > span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Visitor_first_name", "new");
        $this->type("id=Visitor_last_name", "new");
        $this->type("id=Visitor_email", "newvisitor@test.com");
        $this->type("id=Visitor_contact_number", "12345");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormVisitor");
        $this->assertEquals("newvisitor@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->click("link=Search Visitor Profile");
        $this->type("id=search-visitor", "new");
        $this->click("id=dummy-visitor-findBtn");
        sleep(1);

        $this->assertEquals("newvisitor@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[3]"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "kalibo@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt0");
        $this->type("name=User[first_name]", "new");
        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("link=Add Visitor Profile");
        $this->waitForPageToLoad("30000");
        $this->click("//div[@id='cssmenu']/ul/li[4]/ul/li[2]/a/span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->click("link=Search Visitor Profile");
        $this->type("id=search-visitor", "new");
        $this->click("id=dummy-visitor-findBtn");
        sleep(1);

        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("css=ul.nav.nav-tabs > li > a");
        $this->select("id=workstation", "label=workstation for KAL");
        $this->type("id=Visitor_first_name", "testkal");
        $this->type("id=Visitor_last_name", "testkal");
        $this->type("id=Visitor_email", "testkal@test.com");
        $this->type("id=Visitor_contact_number", "12345");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->click("id=submitFormVisitor");
        $this->click("link=Search Host");
        $this->type("id=search-host", "new");
        $this->click("id=dummy-host-findBtn");
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

    /* Scenario 11: Login as agent administrator and check data control
      Expected behavior:
      In adding agent administrator – company should be the same with tenant agent
      In adding agent operator/staff member – company should be the same with tenant’s company (NAIA)
      In adding agent operator – company should be all company of tenant except tenant’s company. Philippine airlines should be in dropdown
      In adding operator – all workstation with same tenant only should be displayed
      In search visitor and host – records should be the same tenant only


     */

    function Scenario11() {
        $username = 'agentadminkalibo@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=li.submenu.addSubMenu > a > span");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("5", $this->getEval("window.document.getElementById(\"User_company\").value"));
        $this->click("css=a.has-sub-sub > span");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_role", "label=Agent Operator");
        sleep(1);
        $this->assertEquals("workstation for PAL-KAL", $this->getText("id=User_workstation"));
        $this->assertEquals("5", $this->getEval("window.document.getElementById(\"User_company\").value"));
        $this->select("id=User_role", "label=Staff Member");
        $this->assertEquals("5", $this->getEval("window.document.getElementById(\"User_company\").value"));
    }

    /* Scenario 12 Check data control in preregister/log visit
      Expected Behavior:
      Workstation should display all workstations with same tenant and tenant agent only. Assert workstation for PAL-KAL in dropdown.
      Assert Philippine airline-Kalibo in company.
      In search visitor profile, assert testvisitor1@test.com in table only. Assert workstation for pal-kal in workstation dropdown

     */

    function Scenario12() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->click("link=Search Visitor Profile");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        sleep(1);

        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("testVisitor3@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr[2]/td[3]"));
        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr[3]/td[3]"));
        $this->assertEquals("Please select a workstation Workstation1Workstation2workstation for PAL", $this->getText("id=workstation_search"));
        $this->select("id=workstation_search", "label=workstation for PAL");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->click("id=2");
        $this->click("id=clicktabB1");
        $this->click("link=Search Host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        sleep(1);
        $this->assertEquals("agentadmin@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("agentoperator@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[2]/td[3]"));
        $this->assertEquals("staffmember@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[3]/td[3]"));
        $this->assertEquals("testHost1@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[4]/td[3]"));
    }

    /* Scenario 13 Check data control in manage workstations
     */

    function Scenario13() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.manageworkstations > span");
        $this->waitForPageToLoad("30000");
        $this->clickAndWait("css=a.addSubMenu > span");
        sleep(1);
        $this->type("id=Workstation_name", "second workstation PAL");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("second workstation PAL", $this->getText("css=tr.odd > td"));
        $this->clickAndWait("link=Administration");

        $this->click("css=a.has-sub-sub > span");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_role", "label=Agent Administrator");
        $this->select("id=User_role", "label=Agent Operator");
        sleep(1);
        $this->select("id=User_workstation", "label=second workstation PAL");
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.sidemenu-icon.pre-visits > span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        sleep(1);
        $this->assertEquals("Please select a workstation Workstation1Workstation2workstation for PALsecond workstation PAL", $this->getText("id=workstation"));
        $this->click("link=Search Visitor Profile");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        sleep(1);
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("testVisitor3@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr[2]/td[3]"));
        $this->assertEquals("testVisitor4@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr[3]/td[3]"));
        $this->assertEquals("Please select a workstation Workstation1Workstation2workstation for PALsecond workstation PAL", $this->getText("id=workstation_search"));
    }

    /* Scenario 14 Check data control in add visitor profile and add host
     */

    function Scenario14() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt0");
        $this->waitForElementPresent("id=User_first_name");
        sleep(1);
        $this->type("id=User_first_name", "newhost");
        $this->type("id=User_last_name", "newhost");
        $this->type("id=User_email", "newhost@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->type("id=User_email", "newhostagentadmin@test.com");
        $this->clickAndWait("id=submitFormUser");
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        sleep(1);
        $this->assertEquals("Please select a workstation Workstation1Workstation2workstation for PALsecond workstation PAL", $this->getText("id=workstation"));
        $this->select("id=workstation", "label=workstation for PAL");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_email", "visitorpal@test.com");
        $this->type("id=Visitor_contact_number", "12345");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->click("id=submitFormVisitor");
        $this->click("link=Search Host");
        $this->type("id=search-host", "new");
        $this->click("id=dummy-host-findBtn");
        sleep(1);
        $this->assertEquals("newhostagentadmin@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr/td[3]"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("newhost", $this->getText("css=tr.odd > td"));
        $this->assertEquals("newhost", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.submenu-icon.addvisitorprofile > span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_email", "newvisitoragentadmin@test.com");
        $this->type("id=Visitor_contact_number", "12345");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormVisitor");
        $this->assertEquals("newvisitoragentadmin@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
        $this->click("link=Log Visit");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->click("link=Search Visitor Profile");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        sleep(1);
        $this->assertEquals("newvisitoragentadmin@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr[4]/td[3]"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "kalibo@test.com");
        $this->type("id=LoginForm_password", "12345");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->type("name=User[first_name]", "test");
        sleep(1);

        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("css=a.managevisitorrecords > span");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
    }

    /* Scenario 15 Login as operator and check data control
      Expected behavior:
      In adding host – tenant should be the same with operator’s tenant
      In search visitor and host – records should be the same tenant only

     */

    function Scenario15() {
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("id=submitBtn");
        $this->click("id=yt0");
        sleep(1);
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_email", "operatorhost@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormUser");
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->click("link=Search Visitor Profile");
        $this->type("id=search-visitor", "new");
        $this->click("id=dummy-visitor-findBtn");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->waitForElementPresent("id=5");
        $this->click("id=5");
        $this->click("id=clicktabB1");
        $this->click("link=Search Host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        sleep(1);
        $this->assertEquals("operatorhost@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[4]/td[3]"));
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.submenu-icon.addvisitorprofile > span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_email", "operatorvisitor@test.com");
        $this->type("id=Visitor_contact_number", "12345");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->clickAndWait("id=submitFormVisitor");
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->click("link=Search Visitor Profile");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        sleep(1);
        $this->assertEquals("operatorvisitor@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[3]"));
    }

    /* Scenario 16 Check data control in preregister/log visit
      Expected Behavior:
      Assert workstation for NAIA, workstation for PAL in workstation dropdown
      Assert Philippine airline in company.
      In search visitor profile, assert workstation for pal and workstation for naia in workstation dropdown

     */

    function Scenario16() {
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->assertEquals("10", $this->getEval("window.document.getElementById(\"userWorkstation\").value"));
        $this->click("id=submitBtn");
        $this->click("id=submit");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Visitor Management System - Dashboard", $this->getTitle());
        $this->assertEquals("Workstation3", $this->getText("css=h1"));
        $this->click("link=Preregister Visit");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->type("id=Visitor_first_name", "visitor");
        $this->type("id=Visitor_last_name", "visitor");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->type("id=Visitor_email", "visitor2@test.com");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->type("id=Visitor_contact_number", "12345");
        $this->assertEquals("Japan Airline", $this->getText("id=Visitor_company"));
        $this->click("id=submitFormVisitor");
        $this->click("css=#register-host-form > div.register-a-visitor-buttons-div > #btnBackTab3");
        $this->click("link=Search Visitor Profile");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=7");
        $this->assertEquals("Select Visitor", $this->getText("id=7"));
        $this->assertEquals("operatorvisitor@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[3]"));
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->waitForElementPresent("id=7");
        $this->click("id=7");
        $this->click("id=clicktabB1");
        $this->click("link=Search Host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        sleep(1);

        $this->assertEquals("admin@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("operator@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[2]/td[3]"));
        $this->assertEquals("admin2@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[3]/td[3]"));
        $this->assertEquals("operatorhost@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[4]/td[3]"));
        $this->waitForElementPresent("id=17");
        $this->click("id=17");
        $this->click("id=clicktabB2");
        $this->click("id=submitVisitForm");
        $this->waitForPageToLoad("30000");
        try {
            $this->assertEquals("operatorvisitor@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("id=confirmPreregisterDummy");
        $this->assertEquals("Preregistered", $this->getText("link=Preregistered"));
        $this->assertEquals("Japan Airline", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[5]"));
        $this->assertEquals("operatorvisitor@test.com", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[7]"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->select("id=userWorkstation", "label=Workstation1");
        $this->click("id=submitBtn");
        $this->click("id=submit");
        $this->waitForPageToLoad("30000");

        $this->assertEquals("Workstation1", $this->getText("css=h1"));
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->type("name=Visit[contactemail]", "operator");

        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
    }

    /* Scenario 17 Check data control in add visitor profile and add host
      Expected Behavior:
      Assert second workstation PAL in workstation dropdowns

     */

    function Scenario17() {
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->click("id=submit");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt0");
        sleep(1);
        $this->type("id=User_first_name", "operatorhost2");
        $this->type("id=User_last_name", "operatorhost2");
        $this->type("id=User_email", "operatorhost2@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->click("id=submitFormUser");
        $this->waitForPageToLoad("30000");
        $this->click("css=a.submenu-icon.addvisitorprofile > span");
        $this->waitForPageToLoad("30000");
        $this->type("id=Visitor_first_name", "operatorvisitor");
        $this->type("id=Visitor_last_name", "operatorvisitor");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->type("id=Visitor_email", "operatorvisitor2@test.com");
        $this->type("id=Visitor_contact_number", "12345");
        $this->assertEquals("Japan Airline", $this->getText("id=Visitor_company"));
        $this->click("id=submitFormVisitor");
        $this->waitForPageToLoad("30000");
        $this->clickAndWait("link=Dashboard");
        $this->click("css=span");
        $this->waitForPageToLoad("30000");
        $this->click("id=clicktabA");
        $this->click("link=Search Visitor Profile");
        $this->type("id=search-visitor", "visitor");
        $this->click("id=dummy-visitor-findBtn");
        sleep(1);
        $this->assertEquals("operatorvisitor2@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[3]"));
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->waitForElementPresent("id=8");
        $this->click("id=8");
        $this->click("id=clicktabB1");
        $this->click("link=Search Host");
        $this->type("id=search-host", "host");
        $this->click("id=dummy-host-findBtn");
        sleep(1);
        $this->assertEquals("operatorhost2@test.com", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[2]/td[3]"));
        $this->assertEquals("operatorhost2", $this->getText("//div[@id='findHost-grid']/table/tbody/tr[2]/td[2]"));
        $this->waitForElementPresent("id=30");
        $this->click("id=30");
        $this->click("id=clicktabB2");
        $this->click("id=submitVisitForm");
        $this->waitForPageToLoad("30000");
        try {
            $this->assertEquals("operatorvisitor2@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(3);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->click("link=Dashboard");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Active", $this->getText("link=Active"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'kalibo@test.com';
        $this->login($username, '12345');
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->select("name=Visit[visit_status]", "label=Active");
        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Visit History");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Active", $this->getText("link=Active"));
        sleep(1);
        $this->assertEquals("operatorvisitor2@test.com", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[8]"));
    }

    /* Scenario 18 Login as agent operator and check data control
      Expected behavior:
      Assert agentoperatorvisitor@test.com in search visitor profile
      Assert agentoperatorhost@test.com in search host profile
      Assert Philippine airline in company dropdown

     */

    function Scenario18() {
        $username = 'agentoperator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->click("id=submit");
        $this->waitForPageToLoad("30000");
        
    }

}

?>