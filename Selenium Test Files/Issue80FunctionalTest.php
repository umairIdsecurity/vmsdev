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
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
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
        $this->assertEquals("Please enter a First Name.", $this->getText("id=Visitor_first_name_em_"));
        $this->assertEquals("Please enter a Last Name.", $this->getText("id=Visitor_last_name_em_"));
        $this->assertEquals("Please enter a Mobile Number.", $this->getText("id=Visitor_contact_number_em_"));
        $this->assertEquals("Please enter an Email Address.", $this->getText("id=Visitor_email_em_"));
        $this->assertEquals("Please enter a Password.", $this->getText("id=Visitor_password_em_"));
        $this->assertEquals("Please enter a Repeat Password.", $this->getText("id=Visitor_repeatpassword_em_"));
        $this->assertEquals("Please select a Tenant.", $this->getText("id=Visitor_tenant_em_"));
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("id=search-visitor-reason-error");
        $this->assertEquals("Please select a Reason.", $this->getText("id=search-visitor-reason-error"));
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->click("id=clicktabB1");
        $this->waitForElementPresent("css=div.errorMessage.errorMessageWorkstationSearch");
        $this->assertEquals("Please select a Workstation.", $this->getText("css=div.errorMessage.errorMessageWorkstationSearch"));
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->click("id=submitFormUser");
        sleep(1);
        $this->assertEquals("Please enter a First Name.", $this->getText("id=User_first_name_em_"));
        $this->assertEquals("Please enter a Last Name.", $this->getText("id=User_last_name_em_"));
        $this->assertEquals("Please enter an Email Address.", $this->getText("id=User_email_em_"));
        $this->assertEquals("Please enter a Contact No..", $this->getText("id=User_contact_number_em_"));
        $this->assertEquals("Please enter a Password.", $this->getText("id=User_password_em_"));
        $this->assertEquals("Please enter a Repeat Password.", $this->getText("id=User_repeatpassword_em_"));
        $this->assertEquals("Please select a Company Name.", $this->getText("id=User_company_em_"));
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[3]/a/span");
        $this->click("id=submitFormVisitor");
        sleep(1);
        $this->assertEquals("Please enter a First Name.", $this->getText("id=Visitor_first_name_em_"));
        $this->assertEquals("Please enter a Last Name.", $this->getText("id=Visitor_last_name_em_"));
        $this->assertEquals("Please enter an Email Address.", $this->getText("id=Visitor_email_em_"));
        $this->assertEquals("Please enter a Mobile Number.", $this->getText("id=Visitor_contact_number_em_"));
        $this->assertEquals("Please enter a Password.", $this->getText("id=Visitor_password_em_"));
        $this->assertEquals("Please enter a Repeat Password.", $this->getText("id=Visitor_repeatpassword_em_"));
        $this->assertEquals("Please select a Tenant.", $this->getText("id=Visitor_tenant_em_"));
        
        $this->clickAndWait("link=Administration");
        $this->click("id=yt0");
        $this->clickAndWait("css=span");
        $this->clickAndWait("id=createBtn");
        $this->assertEquals("Please enter a Company Name.", $this->getText("css=div.errorMessage"));
        $this->assertEquals("Please enter a Company Code.", $this->getText("//form[@id='company-form']/table/tbody/tr[3]/td[3]/div"));
        $this->click("id=yt2");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[2]/ul/li/a/span");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Please enter a Name.", $this->getText("css=div.errorMessage"));
        $this->assertEquals("Please select a Tenant.", $this->getText("//form[@id='workstations-form']/table/tbody/tr[6]/td[3]/div"));
        $this->click("id=yt3");
        $this->clickAndWait("link=Add User");
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("Please enter a First Name.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr/td[2]/div"));
        $this->assertEquals("Please enter a Last Name.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[2]/td[2]/div"));
        $this->assertEquals("Please enter an Email Address.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[3]/td[2]/div"));
        $this->assertEquals("Please enter a Contact No..", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[4]/td[2]/div"));
        $this->assertEquals("Please select a Role.", $this->getText("css=div.errorMessage"));
        $this->assertEquals("Please select a Company Name.", $this->getText("css=#companyRow > div.errorMessage"));
        $this->assertEquals("Please enter a Password.", $this->getText("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[9]/td[2]/div"));
        $this->assertEquals("Please enter a Repeat Password.", $this->getText("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[10]/td[2]/div[2]"));
        $this->click("id=yt4");
        $this->click("id=yt5");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[5]/ul/li/a/span");
        $this->click("//div[@id='cssmenu']/ul/li[5]/ul/li/a/span");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Please enter a Name.", $this->getText("css=div.errorMessage"));
        $this->click("id=yt6");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[6]/ul/li/a/span");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Please enter a Reason.", $this->getText("css=div.errorMessage"));
        $this->click("id=yt8");
        $this->clickAndWait("css=p");
        $this->type("id=User_first_name", "");
        $this->type("id=User_last_name", "");
        $this->type("id=User_contact_number", "");
        $this->type("id=User_email", "");
        $this->clickAndWait("id=submitBtn");
        $this->assertEquals("Please enter a First Name.", $this->getText("css=div.errorMessage"));
        $this->assertEquals("Please enter a Last Name.", $this->getText("//form[@id='user-form']/table/tbody/tr[2]/td[3]/div"));
        $this->assertEquals("Please enter an Email Address.", $this->getText("//form[@id='user-form']/table/tbody/tr[4]/td[3]/div"));
        $this->assertEquals("Please enter a Contact No..", $this->getText("//form[@id='user-form']/table/tbody/tr[5]/td[3]/div"));
        $this->clickAndWait("//ul[@id='tabs']/li[2]/a/p");
        $this->clickAndWait("name=yt0");
        $this->assertEquals("Please enter a Message.", $this->getText("css=div.errorSummary > ul > li"));
    }

}

?>