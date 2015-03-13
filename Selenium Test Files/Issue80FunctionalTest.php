<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue80FunctionalTest
 *
 * @author Jeremiah
 */
class Issue80FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 – Check validation errors
      Expected Behavior
      -	Assert Please enter a First Name
      - Assert Please enter an Email Address
      - Assert Please select a Role

     */

    function Scenario1() {
        $this->login("superadmin@test.com", "12345");
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        $this->click("id=submitFormVisitor");
        sleep(1);
        $this->assertEquals("Please enter a First Name", $this->getText("id=Visitor_first_name_em_"));
        $this->assertEquals("Please enter a Last Name", $this->getText("id=Visitor_last_name_em_"));
        $this->assertEquals("Please enter a Mobile Number", $this->getText("id=Visitor_contact_number_em_"));
        $this->assertEquals("Please enter an Email Address", $this->getText("id=Visitor_email_em_"));
        $this->assertEquals("Please enter a Password", $this->getText("id=Visitor_password_em_"));
        $this->assertEquals("Please enter a Repeat Password", $this->getText("id=Visitor_repeatpassword_em_"));
        $this->assertEquals("Please select a Tenant", $this->getText("id=Visitor_tenant_em_"));
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("id=search-visitor-reason-error");
        $this->assertEquals("Please select a reason", $this->getText("id=search-visitor-reason-error"));
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("css=div.errorMessage.errorMessageWorkstationSearch");
        $this->assertEquals("Please select a workstation", $this->getText("css=div.errorMessage.errorMessageWorkstationSearch"));
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->click("id=submitFormUser");
        sleep(1);
        $this->assertEquals("Please enter a First Name", $this->getText("id=User_first_name_em_"));
        $this->assertEquals("Please enter a Last Name", $this->getText("id=User_last_name_em_"));
        $this->assertEquals("Please enter an Email Address", $this->getText("id=User_email_em_"));
        $this->assertEquals("Please enter a Contact No.", $this->getText("id=User_contact_number_em_"));
        $this->assertEquals("Please enter a Password", $this->getText("id=User_password_em_"));
        $this->assertEquals("Please select a Company Name", $this->getText("id=User_company_em_"));
        $this->clickAndWait("css=a.submenu-icon.addvisitorprofile > span");
        $this->click("id=submitFormVisitor");
        sleep(1);
        $this->assertEquals("Please enter a First Name", $this->getText("id=Visitor_first_name_em_"));
        $this->assertEquals("Please enter a Last Name", $this->getText("id=Visitor_last_name_em_"));
        $this->assertEquals("Please enter an Email Address", $this->getText("id=Visitor_email_em_"));
        $this->assertEquals("Please enter a Mobile Number", $this->getText("id=Visitor_contact_number_em_"));
        $this->assertEquals("Please enter a Password", $this->getText("id=Visitor_password_em_"));
        $this->assertEquals("Please enter a Repeat Password", $this->getText("id=Visitor_repeatpassword_em_"));
        $this->assertEquals("Please select a Tenant", $this->getText("id=Visitor_tenant_em_"));

        $this->clickAndWait("link=Administration");
        $this->click("id=yt0");
        $this->clickAndWait("css=span");
        $this->clickAndWait("id=createBtn");
        $this->assertEquals("Please enter a Company Name", $this->getText("css=div.errorMessage"));
        $this->assertEquals("Please enter a Company Code", $this->getText("//form[@id='company-form']/table/tbody/tr[3]/td[3]/div"));
        $this->click("id=yt2");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/ul/li/a/span");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Please enter a Name", $this->getText("css=div.errorMessage"));
        $this->assertEquals("Please select a Tenant", $this->getText("//form[@id='workstations-form']/table/tbody/tr[6]/td[3]/div"));
        $this->click("id=yt3");
        $this->clickAndWait("css=div.customIcon-adminmenu");
        $this->click("id=submitForm");
        sleep(1);
        $this->assertEquals("Please enter a First Name", $this->getText("id=User_first_name_em_"));
        $this->assertEquals("Please enter a Last Name", $this->getText("id=User_last_name_em_"));
        $this->assertEquals("Please enter an Email Address", $this->getText("id=User_email_em_"));
        $this->assertEquals("Please enter a Contact No.", $this->getText("id=User_contact_number_em_"));
        $this->assertEquals("Please select a Role", $this->getText("css=div.errorMessage"));
        $this->assertEquals("Please select a Company Name", $this->getText("css=#companyRow > div.errorMessage"));
        $this->assertEquals("Please enter a Password", $this->getText("id=User_password_em_"));
        $this->click("id=yt4");
        $this->click("id=yt5");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[5]/ul/li/a/span");
        $this->click("//div[@id='cssmenu']/ul/li[5]/ul/li/a/span");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Please enter a Name", $this->getText("css=div.errorMessage"));
        $this->click("id=yt6");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[6]/ul/li/a/span");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Please enter a Reason", $this->getText("css=div.errorMessage"));
       
        $this->clickAndWait("//ul[@id='tabs']/li[2]/a/p");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Please enter a Message", $this->getText("css=div.errorSummary > ul > li"));
    }

    /* Scenario 2 – Check validation errors for unique email
      Expected Behavior
      -	Assert A profile already exists for this Email Address.
     */

    function Scenario2() {
        $this->login("superadmin@test.com", "12345");
        $this->clickAndWait("css=span");
        $this->click("id=clicktabA");
        
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "testvisitor1@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        sleep(1);
        $this->select("id=workstation", "label=Workstation3");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("xpath=(//div[@id='Visitor_email_em_'])[2]");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='Visitor_email_em_'])[2]"));
        $this->type("id=Visitor_email", "testvisitor@test.com");
        $this->click("id=submitFormVisitor");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_email", "superadmin@test.com");
        $this->type("id=User_contact_number", "123");
        $this->type("id=User_password", "123");
        $this->type("id=User_repeatpassword", "123");
        $this->select("id=User_tenant", "label=NAIA Airport");
        $this->click("id=submitFormUser");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='User_email_em_'])[2]"));
        $this->clickAndWait("css=a.submenu-icon.addvisitorprofile > span");
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_email", "testvisitor1@test.com");
        $this->type("id=Visitor_contact_number", "123");
        $this->type("id=Visitor_password", "123");
        $this->type("id=Visitor_repeatpassword", "123");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        $this->click("id=submitFormVisitor");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("css=div.errorMessageEmail"));
       
        $this->click("id=yt0");
        $this->waitForElementPresent("id=User_first_name");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_email", "superadmin@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->select("id=User_tenant", "label=NAIA Airport");
        $this->type("id=User_password", "123");
        $this->type("id=User_repeatpassword", "123");
        $this->click("id=submitFormUser");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='User_email_em_'])[2]"));
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("css=a.has-sub-sub > span");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_email", "superadmin@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->select("id=User_role", "label=Administrator");
        $this->type("id=User_password", "123");
        $this->type("id=User_repeat_password", "123");
        $this->click("id=submitForm");
        sleep(1);
        $this->waitForElementPresent("css=span.errorMessageEmail1");
        $this->assertEquals("A profile already exists for this email address", $this->getText("css=span.errorMessageEmail1"));
    }

}

?>
