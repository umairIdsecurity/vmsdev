<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue25FunctionalTest
 *
 * @author Jeremiah
 */
class Issue25FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
        $this->Scenario5();
        $this->Scenario6();
    }

    /* Scenario 1 – Login as super admin then perform register a visitor functionality for patient visitor type
      Expected Behavior
      -	Assert text visitor1@test.com in email field.
      -	Assert text of all fields to verify correct record.


      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.      Click manage visitor records then click register a visitor
      7.	Click same day visitor. Click continue button. Type ‘test’ in first name, visitor in last name, testvisitor1@test.com in email, 123456 in mobile Number. Select patient type in visitor type. Select test admin in tenant and select tenant agentadmin for tenant agent.
      8.	Assert company field is disabled. Select other in reason. Type reason 1 in reason field then click add.
      9.	Click save and continue button.
      10.	Type patient name 1 in patient name field.
      11.	Click continue button.
      12.	Wait for page to load. Assert text visitor detail. Assert test in first name, visitor in last name, visitor1@test.com in email field, and 123456 in mobile field. Assert visitor type is patient visitor. Assert text this is a reason in reason dropdown.
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[4]/a/span");
        $this->clickAndWait("link=Register a Visitor");
        $this->click("id=clicktabA");
        $this->addVisitor('Visitor1');
        $this->addReason('Reason 1');
        $this->assertEquals("Other Reason 1", $this->getText("id=Visit_reason"));
        $this->click("id=clicktabB");
        $this->addPatient("Patient Name 1");
        $this->click("id=dummy-submitFormPatientName");
        $this->click("id=submitFormVisitor");
        sleep(2);
        $this->click("id=submitFormPatientName");
        
        $this->clickAndWait("id=submitVisitForm");
        
        $this->verifyVisitorInTable('Visitor1', 'Patient Visitor');
    }

    /* Scenario 2 – Login as super admin then perform add visitor functionality for corporate visitor type
      Expected Behavior
      -	Assert text visitor2@test.com in email field.
      -	Assert text of all fields to verify correct record.


      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.      Click manage visitor records then click register a visitor
      7.	Click same day visitor. Click continue button. Type ‘test’ in first name, visitor2 in last name, testvisitor2@test.com in email, 123456 in mobile Number. Select corporate type in visitor type. Select test admin in tenant and select tenant agentadmin for tenant admin. Select reason 1 in reason field.
      8.	Assert company field is present. Select test company 1 in company then Click Add button.
      9.	Wait for page to load. Type test in first name, host1 in last name, Test department in department, 12345 in staff id, testhost1@test.com in email field, and 123456 in mobile number field.
      10.	Click Continue button.
      11.	Wait for page to load. Assert text visitor detail. Assert test in first name, visitor2 in last name, testvisitor2@test.com in email field, and 123456 in mobile field. Assert visitor type is corporate visitor. Assert text reason 1 in reason dropdown.
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[4]/a/span");
        $this->clickAndWait("link=Register a Visitor");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->addVisitor('Visitor2');
        $this->select("id=Visit_reason", "label=Reason 1");
        sleep(1);
        $this->assertEquals("Test Company 1", $this->getText("id=Visitor_company"));
        $this->click("id=clicktabB");
        $this->addHost("Host1");
        $this->click("id=submitFormVisitor");
        sleep(2);
        $this->click("id=submitFormUser");
        sleep(2);
        $this->clickAndWait("id=submitVisitForm");
        $this->verifyVisitorInTable('Visitor2', 'Corporate Visitor');
    }

    /* Scenario 3 –Login as super admin and Check for validations in registering a patient visitor
      Expected behavior
      -	Assert text First Name cannot be blank.
      -	Assert text Last Name cannot be blank
      -	Assert text mobile number cannot be blank
      -	Assert text email address cannot be blank
      -	Assert text email address has already been taken.
      -	Assert text reason cannot be blank
      -	Assert patient name cannot be blank
      -	Assert patient name has already been taken

      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in email field and 12345 in password field
      3.	Click login
      4.	Click administration
      5.	Click manage visitor records
      6.	Click register a visitor
      7.	Select same day visitor then click continue
      8.	Select Reason 1 in reason field
      9.	Click save and continue button
      10.	Click save and continue button for add patient name tab
      11.	Assert text first name cannot be blank, last name cannot be blank, mobile number cannot be blank, email address cannot be blank, tenant cannot be blank.
      12.	Type test in email address field and assert email address is not a valid email address.
      13.	Type test in firstname, visitor in last name, 12345 in mobile number, testvisitor1@test.com in email address, and select test admin in tenant field.
      14.	Click save and continue button
      15.	Assert Email Address has already been taken.
      16.	Type visitor1@test.com in email address field
      17.	Click save and continue button
      18.	Wait for add patient name tab
      19.	Assert Patient name cannot be blank
      20.	Type Patient Name 1 in patient name field
      21.	Click save and continue button
      22.	Assert Patient Name has already been taken.

     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[4]/a/span");
        $this->clickAndWait("link=Register a Visitor");
        $this->click("id=clicktabA");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->click("id=clicktabB");
        $this->click("id=dummy-submitFormPatientName");
        $this->click("id=submitFormVisitor");
        $this->click("id=clicktabA");
        sleep(1);
        $this->waitForElementPresent("id=Visitor_first_name_em_");
        $this->assertEquals("First Name cannot be blank.", $this->getText("id=Visitor_first_name_em_"));
        $this->assertEquals("Last Name cannot be blank.", $this->getText("id=Visitor_last_name_em_"));
        $this->assertEquals("Mobile Number cannot be blank.", $this->getText("id=Visitor_contact_number_em_"));
        $this->assertEquals("Email Address cannot be blank.", $this->getText("id=Visitor_email_em_"));
        $this->assertEquals("Tenant cannot be blank.", $this->getText("id=Visitor_tenant_em_"));
        $this->type("id=Visitor_email", "123");
        $this->click("id=Visitor_first_name");
        sleep(1);
        $this->assertEquals("Email Address is not a valid email address.", $this->getText("id=Visitor_email_em_"));
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "testvisitor1@test.com");
        $this->select("id=Visitor_tenant", "label=Test admin");
        $this->click("id=submitFormVisitor");
        $this->assertEquals("Email Address has already been taken.", $this->getText("xpath=(//div[@id='Visitor_email_em_'])[2]"));
        $this->type("id=Visitor_email", "test1@test.com");
        $this->click("id=submitFormVisitor");
        $this->click("id=submitFormPatientName");
        $this->click("id=clicktabB");
        sleep(1);
        $this->assertEquals("Patient name cannot be blank.", $this->getText("id=Patient_name_em_"));
        $this->type("id=Patient_name", "Patient Name 1");
        $this->click("id=submitFormPatientName");
        $this->assertEquals("Patient Name has already been taken.", $this->getText("id=Patient_name_error"));
    }

    /* Scenario 4 –Login as super admin and Check for validations in registering a corporate visitor
      Expected behavior
      -	Assert text First Name cannot be blank.
      -	Assert text Last Name cannot be blank
      -	Assert text mobile number cannot be blank
      -	Assert text email address cannot be blank
      -	Assert text email address has already been taken.
      -	Assert text reason cannot be blank
      -	Assert text company cannot be blank
      -	Assert text contact no. cannot be blank

      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in email field and 12345 in password field
      3.	Click login
      4.	Click administration
      5.	Click manage visitor records
      6.	Click register a visitor
      7.	Select same day visitor then click continue
      8.	Select Reason 1 in reason field and corporate visitor in visitor type
      9.	Click save and continue button
      10.	Click save and continue button for add host tab
      11.	Assert text first name cannot be blank, last name cannot be blank, mobile number cannot be blank, email address cannot be blank, tenant cannot be blank.
      12.	Type test in email address field and assert email address is not a valid email address.
      13.	Type test in firstname, visitor in last name, 12345 in mobile number, testvisitor1@test.com in email address, and select test admin in tenant field.
      14.	Click save and continue button
      15.	Assert Email Address has already been taken.
      16.	Type visitor1@test.com in email address field
      17.	Click save and continue button
      18.	Wait for add host tab
      19.	Assert text first name cannot be blank, last name cannot be blank, Contact no. cannot be blank, email cannot be blank, company cannot be blank.
      20.	Type test in email field and assert email is not a valid email address
      21.	Type test in first name, visitor in last name, 12345 in contact number, staffmember@test.com in email address, and select test admin in tenant field.
      22.	Click save and continue
      23.	Assert email address has already been taken.
     */

    function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[4]/a/span");
        $this->clickAndWait("link=Register a Visitor");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->click("id=clicktabB");
        $this->click("id=clicktabC");
        $this->click("id=submitFormVisitor");
        $this->click("id=clicktabA");
        sleep(1);
        $this->waitForElementPresent("id=Visitor_first_name_em_");
        $this->assertEquals("First Name cannot be blank.", $this->getText("id=Visitor_first_name_em_"));
        $this->assertEquals("Last Name cannot be blank.", $this->getText("id=Visitor_last_name_em_"));
        $this->assertEquals("Mobile Number cannot be blank.", $this->getText("id=Visitor_contact_number_em_"));
        $this->assertEquals("Email Address cannot be blank.", $this->getText("id=Visitor_email_em_"));
        $this->assertEquals("Tenant cannot be blank.", $this->getText("id=Visitor_tenant_em_"));
        $this->type("id=Visitor_email", "123");
        $this->click("id=Visitor_first_name");
        sleep(1);
        $this->assertEquals("Email Address is not a valid email address.", $this->getText("id=Visitor_email_em_"));
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_contact_number", "1234");
        $this->type("id=Visitor_email", "testvisitor1@test.com");
        $this->select("id=Visitor_tenant", "label=Test admin");
        $this->click("id=submitFormVisitor");
        $this->assertEquals("Email Address has already been taken.", $this->getText("xpath=(//div[@id='Visitor_email_em_'])[2]"));
        $this->type("id=Visitor_email", "test2@test.com");
        $this->click("id=submitFormVisitor");
        $this->click("id=submitFormUser");
        $this->click("id=clicktabB");
        sleep(1);
        $this->waitForElementPresent("id=User_first_name_em_");

        $this->assertEquals("First Name cannot be blank.", $this->getText("id=User_first_name_em_"));
        $this->assertEquals("Last Name cannot be blank.", $this->getText("id=User_last_name_em_"));
        $this->assertEquals("Email cannot be blank.", $this->getText("id=User_email_em_"));
        $this->assertEquals("Contact No. cannot be blank.", $this->getText("id=User_contact_number_em_"));
        $this->assertEquals("Company Name cannot be blank.", $this->getText("id=User_company_em_"));
        $this->type("id=User_email", "123");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_email", "staffmember@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->select("id=User_tenant", "label=Test admin");
        $this->click("id=submitFormUser");
        $this->waitForElementPresent("xpath=(//div[@id='User_email_em_'])[2]");
        $this->assertEquals("Email Address has already been taken.", $this->getText("xpath=(//div[@id='User_email_em_'])[2]"));
    }

    /* Scenario 5 – Log in as super admin and register a patient visitor with existing host and visitor record
      Expected behavior
      -	Assert text testvisitor3@test.com in visitor email field.
      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in email field and 12345 in password field
      3.	Click login
      4.	Click administration
      5.	Click manage visitor records
      6.	Click register a visitor
      7.	Select same day visitor then click continue
      8.	Type test visitor1 in search name field
      9.	Click find record
      10.	Assert text testVisitor1@test.com in email field
      11.	Click select visitor
      12.	Select patient visitor in visitor type field
      13.	Select reason 1 in reason field.
      14.	Click save and continue
      15.	Type patient name 1 in search name field.
      16.	Click find host
      17.	Assert text patient name 1 in name field
      18.	Click select patient
      19.	Assert selected patient: patient name 1
      20.	Click save and continue
     */

    function Scenario5() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[4]/a/span");
        $this->clickAndWait("link=Register a Visitor");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test visitor1");
        $this->click("id=dummy-visitor-findBtn");
        sleep(1);
        $this->click("id=2");
        $this->waitForElementPresent("css=h4");
        sleep(1);
        $this->assertEquals("Selected Visitor Record : Test Visitor1", $this->getText("css=h4"));
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[3]"));
        $this->click("id=clicktabB1");
        $this->type("id=search-host", "Patient Name 1");
        $this->click("id=dummy-host-findBtn");
        sleep(1);
        $this->waitForElementPresent("id=38");
        $this->click("id=38");
        sleep(1);
        $this->click("id=clicktabB2");
        $this->click("id=submitVisitForm");
    }

    /* Scenario 6 – Log in as super admin and register a visitor with new reason
      Expected behavior
      -	Assert text testvisitor3@test.com in visitor email field.
      -	Assert text “Reason 2”.
      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in email field and 12345 in password field
      3.	Click login
      4.	Click administration
      5.	Click manage visitor records
      6.	Click register a visitor
      7.	Select same day visitor then click continue
      8.	Type ‘test’ in first name, visitor3 in last name, testvisitor3@test.com in email, 123456 in mobile Number. Select patient type in visitor type. Select test admin in tenant and select tenant agentadmin for tenant agent.
      9.	Select other in reason
      10.	Wait for add reason field
      11.	Type reason 2 in reason field
      12.	Click Add
      13.	Assert reason 2 in reason dropdown
      14.	Click save and continue
      15.	Type patient name 2 in patient name
      16.	Click save and continue
      17.	Wait for page to load
      18.	Click manage visitor records
      19.	Type testvisitor3@test.com in email search field
      20.	Assert testvisitor3@test.com in table and assert displaying 1-1 result.
     */
    
    function Scenario6(){
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("//div[@id='cssmenu']/ul/li[4]/a/span");
        $this->clickAndWait("link=Register a Visitor");
        $this->click("id=clicktabA");
        $this->addVisitor('Visitor3');
        $this->addReason('Reason 2');
        $this->assertEquals("Other Reason 1Reason 2", $this->getText("id=Visit_reason"));
        $this->click("id=clicktabB");
        $this->addPatient("Patient Name 2");
        $this->click("id=dummy-submitFormPatientName");
        $this->click("id=submitFormVisitor");
        sleep(2);
        $this->click("id=submitFormPatientName");
        $this->clickAndWait("id=submitVisitForm");
        $this->verifyVisitorInTable('Visitor3', 'Patient Visitor');
    }
}

?>