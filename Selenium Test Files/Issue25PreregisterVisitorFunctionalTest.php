<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue25FunctionalTest
 * Preregister a visitor
 * @author Jeremiah
 */
class Issue25PreregisterVisitorFunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        //scenario 1-3 is for patient type comment as of now.
      //  $this->Scenario1();
      //  $this->Scenario2();
     //   $this->Scenario3();
        $this->Scenario4();
       // $this->Scenario5();
        $this->Scenario6();
        $this->Scenario7();
        $this->Scenario8();
    }

    /* Scenario 1 – Login as super admin then perform preregister a visitor functionality 
      for patient visitor type. Add new patient and add new reason

      Expected Behavior
      -	Assert text testvisitor5@test.com in email field.
      -	Assert text of all fields to verify correct record.


      Steps:
      1.	Go to dev.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in passtd field
      4.	Click Login
      5.	Click Administration
      6.        Click manage visitor records then click pre-register a visitor
      7.	Click same day visitor. Click continue button. Type ‘test’ in first name, visitor5 in last name, testvisitor5@test.com in email, 123456 in mobile Number. Select patient type in visitor type. Select test admin in tenant and select tenant agentadmin for tenant agent.
      8.	type 12345 in password and repeat password. Assert company field is disabled. Select other in reason. Type reason 3 in reason field.
      9.	Click save and continue button.
      10.	Type patient name 1 in patient name field.
      11.	Click save and continue button.
      12.	Wait for page to load. Assert text visitor detail. Assert test in first name, visitor5 in last name, testvisitor5@test.com in email field, and 1234567 in mobile field


     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Preregister Visit");
        $this->click("id=clicktabA");
        $this->addVisitor('Visitor5');
        $this->select("id=workstation", "label=Workstation1");
        $this->addReason('Reason 3');
        $this->waitForElementPresent("id=submitFormVisitor");
        $this->click("id=submitFormVisitor");
        $this->addPatient("Patient Name 1");
        $this->clickAndWait("id=submitFormPatientName");
        $this->verifyVisitorInTable('Visitor5');
    }

    /* Scenario 2 – Login as super admin then perform register a visitor functionality for exisiting patient visitor type. Add new patient and add new reason

      Expected Behavior
      -	Assert text visitor2@test.com in email field.
      -	Assert text of all fields to verify correct record.


      Steps:
      1.	Go to dev.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.        Click manage visitor records then click pre-register a visitor
      7.	Click same day visitor. Click continue button. Type ‘test visitor1’ in search name click find record. Click select visitor. Select patient type in visitor type.
      8.	Select other in reason. Type reason 4 in reason field
      9.	Click save and continue button.
      10.	Type patient name 2 in patient name field.
      11.	Click save and continue button.
      12.	Wait for page to load. Assert text visitor detail. Assert test in first name, visitor1 in last name, testvisitor1@test.com in email field, and 1234567 in mobile field
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Preregister Visit");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test visitor1");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Selected Visitor Record : Test Visitor1" == $this->getText("css=h4"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Selected Visitor Record : Test Visitor1", $this->getText("css=h4"));
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "Reason 4");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");
        $this->type("id=Patient_name", "Patient Name 2");
        $this->clickAndWait("id=submitFormPatientName");
    }

    /* Scenario 3 – Login as super admin then perform register a visitor functionality for patient visitor type. Add new patient and add new reason

      Expected Behavior
      -	Assert text testvisitor2@test.com in email field.
      -	Assert text of all fields to verify correct record.


      Steps:
      1.	Go to dev.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.        Click manage visitor records then click pre-register a visitor
      7.	Click same day visitor. Click continue button. Type ‘test’ in first name, visitor2 in last name, testvisitor2@test.com in email, 123456 in mobile Number. Select patient type in visitor type. Select test admin in tenant and select tenant agentadmin for tenant agent.
      8.	type 12345 in password and repeat password. Assert company field is disabled. Select reason 1 in reason field
      9.	Click save and continue button.
      10.	Type patient name 3 in patient name field.
      11.	Click save and continue button.
      12.	Wait for page to load. Assert text visitor detail. Assert test in first name, visitor2 in last name, testvisitor2@test.com in email field, and 123456 in mobile field
     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Preregister Visit");
        $this->click("id=clicktabA");
        $this->addVisitor('Visitor2');
        $this->select("id=workstation", "label=Workstation1");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->click("id=submitFormVisitor");
        $this->addPatient("Patient Name 3");
        $this->clickAndWait("id=submitFormPatientName");
        $this->verifyVisitorInTable('Visitor2');
    }

    /* Scenario 4 – Login as super admin then perform add visitor functionality for corporate visitor type
      Expected Behavior
      -	Assert text testvisitor6@test.com in email field.
      -	Assert text of all fields to verify correct record.


      Steps:
      1.	Go to dev.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.      Click manage visitor records then click pre-register a visitor
      7.	Click same day visitor. Click continue button. Type ‘test’ in first name, visitor6 in last name, testvisitor6@test.com in email, 123456 in mobile Number. Select corporate type in visitor type. Select test admin in tenant and select tenant agentadmin for tenant admin. Select reason 1 in reason field.
      8.	type 12345 in password and repeat password. Assert company field is present. Select test company 1 in company then Click save and continue button.
      9.	Type test in first name, staffmemberHostA in last name, Test department in department, 12345 in staff id, staffmemberHostA@test.com in email field, and 123456 in mobile number field.
      10.	type 12345 in password and repeat password. Select test admin in tenant and test agent admin in tenant agent. Click save and continue button.
      11.	Wait for page to load. Assert text visitor detail. Assert test in first name, visitor6 in last name, visitor6@test.com in email field, and 123456 in mobile field. Assert visitor type is corporate visitor. Assert text reason 1 in reason dropdown.
     */

    function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Preregister Visit");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->addVisitor('Visitor6');
        $this->select("id=workstation", "label=Workstation3");
        $this->select("id=Visit_reason", "label=Reason 1");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Philippine Airline" == $this->getText("id=Visitor_company"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Philippine Airline", $this->getText("id=Visitor_company"));
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=User_first_name");
        $this->addHost("staffmemberHostA");
        $this->waitForElementPresent("id=submitFormUser");
        $this->clickAndWait("id=submitFormUser");
        $this->verifyVisitorInTable('Visitor6');
    }

    /* Scenario 5 –Login as super admin and Check for validations in registering a patient visitor
      Expected behavior
      -	Assert text Please enter a First Name
      -	Assert text Last Name cannot be blank
      -	Assert text mobile number cannot be blank
      -	Assert text email address cannot be blank
      -	Assert text email address has already been taken.
      -	Assert text reason cannot be blank
      -	Assert patient name cannot be blank

      Steps:
      1.	Go to dev.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in email field and 12345 in password field
      3.	Click login
      4.	Click administration
      5.	Click manage visitor records
      6.	Click pre-register a visitor
      7.	Select same day visitor then click continue
      9.	Click save and continue button
      11.	Assert text first name cannot be blank, last name cannot be blank, mobile number cannot be blank, email address cannot be blank, tenant cannot be blank,password cannot be blank and repeat password cannot be blank.
      12.	Type test in email address field and assert email address is not a valid email address.
      13.	Type test in firstname, visitor in last name, 12345 in mobile number, testvisitor1@test.com in email address, and select test admin in tenant field.
      14.	type 12345 in password and repeat password. select test agent admin in tenant agent. Click save and continue button
      15.	Assert reason cannot be blank. select reason 1 in reason. Click save and continue. Assert A profile already exists for this email address.
      16.	Type visitor1@test.com in email address field
      17.	Click save and continue button
      18.	Wait for add patient name tab
      21.	Click save and continue button
      22.	Assert Please enter a Patient Name

     */

    function Scenario5() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Preregister Visit");
        $this->click("id=clicktabA");
        $this->click("id=submitFormVisitor");
        $this->select("id=workstation", "label=Workstation1");
        $this->type("id=Visitor_first_name", "Test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "test");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        $this->type("id=Visitor_email", "testvisitor1@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->waitForElementPresent("id=Visitor_tenant_agent");
        sleep(1);
        $this->select("id=Visitor_tenant_agent", "label=Philippine Airline");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("css=td > div.errorMessage.visitorReason");
        $this->assertEquals("Please select a reason", $this->getText("css=td > div.errorMessage.visitorReason"));
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=VisitReason_reason", "reason 1");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=visitReasonErrorMessage");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Reason is already registered." == $this->getText("id=visitReasonErrorMessage"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Reason is already registered.", $this->getText("id=visitReasonErrorMessage"));
        $this->type("id=VisitReason_reason", "reason test");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("xpath=(//div[@id='Visitor_email_em_'])[2]");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='Visitor_email_em_'])[2]"));
        $this->type("id=Visitor_email", "testvisitor6@test.com");
        $this->click("id=submitFormVisitor");

        $this->click("id=submitFormPatientName");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Please enter a Patient Name" == $this->getText("id=Patient_name_em_"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Please enter a Patient Name", $this->getText("id=Patient_name_em_"));
        $this->click("css=#register-host-patient-form > div.register-a-visitor-buttons-div > #btnBackTab3");
        $this->waitForElementPresent("id=Patient_name_em_");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->select("id=Visit_reason_search", "label=Please select a reason");
        $this->select("id=Visit_reason_search", "label=Other");
        $this->type("id=VisitReason_reason_search", "reason 2");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->click("id=clicktabB1");

        $this->waitForTextPresent("Reason is already registered.");
        $this->assertEquals("Reason is already registered.", $this->getText("id=visitReasonErrorMessageSearch"));
        $this->type("id=VisitReason_reason_search", "");
        $this->click("id=clicktabB1");
        $this->assertEquals("Please select a reason", $this->getText("id=search-visitor-reason-error"));
    }

    /* Scenario 6 –Login as super admin and Check for validations in registering a corporate visitor
      Expected behavior
      -	Assert text Please enter a First Name
      -	Assert text Last Name cannot be blank
      -	Assert text mobile number cannot be blank
      -	Assert text email address cannot be blank
      -	Assert text email address has already been taken.
      -	Assert text reason cannot be blank
      -	Assert text company cannot be blank
      -	Assert text contact no. cannot be blank

      Steps:
      1.	Go to dev.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in email field and 12345 in password field
      3.	Click login
      4.	Click administration
      5.	Click manage visitor records
      6.	Click pre-register a visitor
      7.	Select same day visitor then click continue
      9.	Click save and continue button
      11.	Assert text first name cannot be blank, last name cannot be blank, mobile number cannot be blank, email address cannot be blank, tenant cannot be blank, password cannot be blank and repeat password cannot be blank.
      12.	Type test in email address field and assert email address is not a valid email address.
      13.	Select corporate type in visitor type. Type test in firstname, visitor in last name, 12345 in mobile number, testvisitor1@test.com in email address, and select test admin in tenant field.
      14.	Select tenant agent admin in tenant agent. type 12345 in password and repeat password. Click save and continue button
      15.	assert reason cannot be blank. select reason 1 in reason. click save and continue button. Assert A profile already exists for this email address.
      16.	Type visitor1@test.com in email address field
      17.	Click save and continue button
      18.	Wait for add host tab. Click save and continue button.
      19.	Assert text first name cannot be blank, last name cannot be blank, Contact no. cannot be blank, email cannot be blank, company cannot be blank, password and repeat password cannot be blank.
      20.	Type test in email field and assert email is not a valid email address
      21.	Type test in first name, visitor in last name, 12345 in contact number, staffmember@test.com in email address, and select test admin in tenant field.
      22.	type 12345 in password and repeat password. Click save and continue
      23.	Assert email address has already been taken.
     */

    function Scenario6() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Preregister Visit");
        $this->click("id=clicktabA");
        $this->click("id=submitFormVisitor");
        
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->type("id=Visitor_first_name", "Test");
        $this->type("id=Visitor_last_name", "test");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "test");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        $this->waitForElementPresent("id=Visitor_email");
        $this->type("id=Visitor_email", "testvisitor1@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        sleep(1);
        $this->select("id=Visitor_tenant_agent", "label=Philippine Airline");
        $this->select("id=workstation", "label=Workstation3");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("css=td > div.errorMessage.visitorReason");
        $this->assertEquals("Please select a reason", $this->getText("css=td > div.errorMessage.visitorReason"));
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=VisitReason_reason", "reason 1");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=visitReasonErrorMessage");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Reason is already registered." == $this->getText("id=visitReasonErrorMessage"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Reason is already registered.", $this->getText("id=visitReasonErrorMessage"));
        $this->type("id=VisitReason_reason", "reason test");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("xpath=(//div[@id='Visitor_email_em_'])[2]");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='Visitor_email_em_'])[2]"));
        $this->type("id=Visitor_email", "testvisitor7@test.com");
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=submitFormUser");
        $this->click("id=submitFormUser");
        $this->waitForElementPresent("id=User_first_name_em_");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Please enter a First Name" == $this->getText("id=User_first_name_em_"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Please enter a First Name", $this->getText("id=User_first_name_em_"));
        $this->assertEquals("Please enter a Last Name", $this->getText("id=User_last_name_em_"));
        $this->assertEquals("Please enter an Email Address", $this->getText("id=User_email_em_"));
        $this->assertEquals("Please enter a Contact No.", $this->getText("id=User_contact_number_em_"));
        $this->assertEquals("Please select a Company Name", $this->getText("id=User_company_em_"));
        $this->type("id=User_email", "123");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");

        $this->type("id=User_email", "123");
        $this->click("id=submitFormUser");
        //$this->assertEquals("Email is not a valid email address.", $this->getText("id=User_email_em_"));
        $this->type("id=User_email", "staffmember@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->select("id=User_tenant", "label=NAIA Airport");
        $this->click("id=submitFormUser");
        $this->assertEquals("A profile already exists for this email address.", $this->getText("xpath=(//div[@id='User_email_em_'])[2]"));
    }

    /* Scenario 7 – Log in as super admin and register a corporate visitor with existing host and visitor record
      Expected behavior
      -	Assert text testvisitor1@test.com in visitor email field.
      Steps:
      1.	Go to dev.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in email field and 12345 in password field
      3.	Click login
      4.	Click administration
      5.	Click manage visitor records
      6.	Click pre-register a visitor
      7.	Select same day visitor then click continue
      8.	Type test visitor1 in search name field
      9.	Click find record.
      10.	Assert text testVisitor1@test.com in email field
      11.	Click select visitor
      12.	Select corporate visitor in visitor type field
      13.	Select reason 1 in reason field.
      14.	Click save and continue
      15.	Type staffmember in search name field.
      16.	Click find host
      17.	Assert text staffmember@test.com in email row
      18.	Click select host
      19.	Assert selected host record: test staffmember
      20.	Click save and continue
      21.       assert testvisitor1@test.com in email field. assert staffmember@test.com in host email field
     */

    function Scenario7() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Preregister Visit");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test visitor1");
        $this->click("id=dummy-visitor-findBtn");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->waitForElementPresent("css=h4");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->assertEquals("testVisitor1@test.com", $this->getText("//div[@id='findvisitor-grid']/table/tbody/tr/td[3]"));
        $this->select("id=Visitor_visitor_type_search", "label=Corporate Visitor");
        $this->click("id=clicktabB1");
        $this->type("id=search-host", "staffmember");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=21");
        $this->waitForElementPresent("id=21");
        $this->click("id=21");
        $this->clickAndWait("id=clicktabB2");
    }

    /* Scenario 8 - Login as superadmin. Preregister a corporate visitor with new company. Check for validations. 
      Expected Behavior: Assert New Company in company row.
      Steps:
      1.	Go to dev.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in email field and 12345 in password field
      3.	Click login
      4.	Click administration
      5.	Click manage visitor records
      6.	Click pre-register a visitor
      7.	Select same day visitor then click continue
      8.	Select corporate visitor. Wait for add new company button.
      9.	Type test in firstame, visitornewcompany in lastname, position in position,123456 in mobile number,testvisitornewcompany@test.com in email
      select reason 1,12345 in password and repeat password,select workstation1 in workstation.
      10.	Click add new company button. Wait for text then assert "Please select a tenant"
      11.	Select test admin in tenant, select test agent admin in tenant agent.
      12.	Click add new company
      13.	Wait for company form to show. Type "New Company" in Company Name.
      14.	Click add button. Wait for company form to close and assert new company selected and added in company dropdown field.
      15.	Click save and continue.
      16.	type test in search field. Click find host
      17.	Select staffmember@test.com as host
      18.	Wait for text "Selected Host Record: Test staffmember" below search field.
      19.	Click save and continue then wait for page to load.
      20.	Assert "testvisitornewcompany@test.com" in email field, corporate type in visitor type.
      21.       Click dashboard then wait for page to load. Type visitornewcompany in lastname, assert "new company" in company column.
     */

    function Scenario8() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitors");
        $this->clickAndWait("link=Preregister Visit");
        $this->click("id=clicktabA");
        $this->select("id=Visitor_visitor_type", "label=Corporate Visitor");
        $this->select("id=workstation", "label=Workstation1");
        $this->waitForElementPresent("id=addCompanyLink");
        $this->assertEquals("Add New Company", $this->getText("id=addCompanyLink"));
        $this->type("id=Visitor_first_name", "test");
        $this->type("id=Visitor_last_name", "visitornewcompany");
        $this->type("id=Visitor_position", "position");
        $this->type("id=Visitor_contact_number", "123456");
        $this->type("id=Visitor_email", "testvisitornewcompany@test.com");
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->click("id=Visit_reason");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->click("id=addCompanyLink");
        $this->waitForElementPresent("id=Visitor_company_em_");
        $this->assertEquals("Please select a tenant", $this->getText("id=Visitor_company_em_"));
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        $this->click("id=Visitor_tenant_agent");
        sleep(1);
        $this->select("id=Visitor_tenant_agent", "label=Philippine Airline");
        $this->click("id=addCompanyLink");
        $this->waitForElementPresent("css=h1");
        
        $this->waitForElementPresent("id=Company_name");
        $this->type("id=Company_name", "new company");
        $this->type("id=Company_code", "NCA");
        $this->click("id=createBtn");
        sleep(3);
        $this->assertEquals("NAIA AirportPhilippine Airlinenew company", $this->getText("id=Visitor_company"));
        $this->click("id=submitFormVisitor");
        $this->waitForElementPresent("id=search-host");
        $this->type("id=search-host", "test");
        $this->click("id=dummy-host-findBtn");
        $this->waitForElementPresent("id=21");
        $this->click("id=21");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Selected Host Record : Test staffmember" == $this->getText("css=#searchHostTableDiv > h4"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Selected Host Record : Test staffmember", $this->getText("css=#searchHostTableDiv > h4"));
        $this->clickAndWait("id=clicktabB2");
        try {
            $this->assertEquals("testvisitornewcompany@test.com", $this->getValue("id=Visitor_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("link=Visit History");
        $this->type("name=Visit[lastname]", "visitornewcompany");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("new company" == $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[6]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("new company", $this->getText("//div[@id='view-visitor-records']/table/tbody/tr/td[6]"));
    }

}

?>
