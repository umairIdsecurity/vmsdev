<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue65FunctionalTest
 * Print card logo
 * @author Jeremiah
 */
class Issue65FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 Logo should be based on tenants company not the visitors company
     * Expected Behavior
     * -Assert PAL in card code
     * -Assert PAL000001 in card number
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/a/span");
        $this->click("id=clicktabA");
        
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "test@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        sleep(1);
        $this->select("id=workstation", "label=Workstation3");
        $this->click("id=addCompanyLink");
        $this->waitForElementPresent("id=Company_name");
        sleep(1);
        $this->type("id=Company_name", "TESTCOMPANY");
        $this->type("id=Company_code", "TCC");
        $this->type("//input[@type='file']", "C:\\xampp\\htdocs\\vms\\protected\\assets\\images\\admin_lifehouse.png");
        $this->clickAndWait("id=createBtn");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "TEST");
        $this->type("id=User_last_name", "TEST");
        $this->type("id=User_email", "TEST@HOST.COM");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->select("id=User_tenant", "label=NAIA Airport");
        sleep(1);
        $this->clickAndWait("id=submitFormUser");
        $this->assertEquals("NAI", $this->getText("css=#cardDetailsTable > tbody > tr > td"));
        $this->click("//li[@id='activateLi']/a/span");
        $this->click("css=#activate-a-visit-form > input.complete");
        sleep(3);
        $this->assertEquals("Visit is now activated. You can now print the visitor badge.", $this->getAlert());
        $this->clickAndWait("link=Dashboard");
        $this->clickAndWait("link=Active");
        $this->assertEquals("NAI000008", $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td/span"));
        $this->click("id=printCardBtn");
        $this->waitForPopUp("_blank", "30000");
        $this->waitForPageToLoad("30000");
        $this->clickAndWait("link=Dashboard");
        $this->assertEquals("NAI000008", $this->getText("//div[@id='visit-gridDashboard']/table/tbody/tr/td[2]"));
    }

}

?>