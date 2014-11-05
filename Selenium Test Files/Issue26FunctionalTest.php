<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue26FunctionalTest
 *
 * @author Jeremiah
 */
class Issue26FunctionalTest extends BaseFunctionalTest {

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
    }

    /* Scenario 1 – Login as super admin then perform update a visitor functionality for patient visitor type
      Expected Behavior
      -	Assert text testvisitor1@test.com in email field.
      -	Assert text of all fields to verify correct record.


      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.	Go to http://cvms.identitysecurity.info/index.php?r=visit/detail&id=2
      7.	Assert first name: test , last name: visitor1, email: testvisitor1@test.com, mobile: 123456, visitor type:patient visitor, reason: reason 1, Patient name: patient name 1.
      8.	Type 09123456789 in mobile number and testvisitorB@test.com in email field for contact details. Click save button under contact details.
      9.	select other in reason then Type reason 3 in reason field then click add button under reason
      10.	Type patient name 3 in patient name field. Click update button under patient details.
      11.	Go to http://cvms.identitysecurity.info/index.php?r=visit/detail&id=2. Assert t09123456789 in mobile number, testvisitorB@test.com in email field for contact details.
      Assert reason 3 in reason. Patient name 3 in patient name field.

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->open("/index.php?r=visit/detail&id=1");
        $this->assertEquals("Test", $this->getText("//table[@id='personalDetailsTable']/tbody/tr/td[2]"));
        $this->assertEquals("Visitor1", $this->getText("//table[@id='personalDetailsTable']/tbody/tr[2]/td[2]"));
        $this->assertEquals("testVisitor1@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("1234567", $this->getValue("id=Visitor_contact_number"));
        $this->assertEquals("1", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("1", $this->getValue("id=Visit_reason"));
        $this->assertEquals("Patient Name 1", $this->getValue("document.forms['update-patient-form'].elements['Patient[name]']"));
        $this->type("id=Visitor_contact_number", "1234567890");
        $this->type("id=Visitor_email", "testVisitorB@test.com");
        $this->click("id=submitContactDetailForm");
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=VisitReason_reason", "Reason 3");

        $this->click("id=submitAddReasonForm");
        sleep(1);
        $this->click("id=submitReasonForm");
        $this->type("document.forms['update-patient-form'].elements['Patient[name]']", "Patient Name 3");
        $this->click("id=submit");
        sleep(1);
        $this->open("/index.php?r=visit/detail&id=1");
        $this->assertEquals("testVisitorB@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("1234567890", $this->getValue("id=Visitor_contact_number"));
        $this->assertEquals("1", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("3", $this->getValue("id=Visit_reason"));
        $this->assertEquals("Patient Name 3", $this->getValue("document.forms['update-patient-form'].elements['Patient[name]']"));
    }

    /* Scenario 2 – Login as super admin then perform update visitor functionality for corporate visitor type
      Expected Behavior
      -	Assert text testvisitor2@test.com in email field.
      -	Assert text of all fields to verify correct record.


      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.	Go to http://cvms.identitysecurity.info/index.php?r=visit/detail&id=5
      7.	Assert email field testvisitor4@Test.com in email, and corporate visitor in visitor type.
      8.	Type 09123456789 in mobile number and testvisitorC@test.com in email field for contact details. Click update button under contact details.
      9.	Select reason 2 in reason then click update button
      10.	Type testA in host first name, hostA in last name, testHost1A@test.com in email field
      11.	Go to http://cvms.identitysecurity.info/index.php?r=visit/detail&id=5. Assert 1234567890 in mobile number, testvisitorC@test.com in email field for contact details.
      12.	Assert reason 2 in reason. TestA in host first name, HostA in last name, testHost1A@test.com in email
     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->open("/index.php?r=visit/detail&id=6");
        $this->assertEquals("testVisitor4@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("2", $this->getValue("id=Visit_visitor_type"));
        $this->type("id=Visitor_email", "testVisitorC@test.com");
        $this->type("id=Visitor_contact_number", "1234567890");
        $this->click("id=submitContactDetailForm");
        sleep(1);
        $this->select("id=Visit_reason", "label=Reason 2");
        $this->click("id=submitReasonForm");
        $this->type("document.forms['register-host-form'].elements['User[first_name]']", "TestA");
        $this->type("document.forms['register-host-form'].elements['User[last_name]']", "HostA");
        $this->type("document.forms['register-host-form'].elements['User[email]']", "testHost1A@test.com");
        $this->click("document.forms['register-host-form'].yt0");
        sleep(1);
        $this->open("/index.php?r=visit/detail&id=6");
        $this->assertEquals("testVisitorC@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("1234567890", $this->getValue("id=Visitor_contact_number"));
        $this->assertEquals("2", $this->getValue("id=Visit_reason"));
        $this->assertEquals("TestA", $this->getValue("document.forms['register-host-form'].elements['User[first_name]']"));
        $this->assertEquals("HostA", $this->getValue("document.forms['register-host-form'].elements['User[last_name]']"));
        $this->assertEquals("testHost1A@test.com", $this->getValue("document.forms['register-host-form'].elements['User[email]']"));
    }

    /* Scenario 3 –Login as super admin and Check for validations in updating a patient visitor
      Expected behavior
      -	Assert text mobile number cannot be blank
      -	Assert text email address cannot be blank
      -	Assert text email address has already been taken.
      -	Assert text reason cannot be blank
      -	Assert text reason has already been registered
      -	Assert patient name cannot be blank
      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in email field and 12345 in password field
      3.	Click login
      4.	Click administration
      5.	Go to http://cvms.identitysecurity.info/index.php?r=visit/detail&id=2
      6.	Empty field mobile number and email field. Click update button under contact details.
      7.	Assert email address cannot be blank.
      8.	Type testvisitor3@test.com in email field. Click update and assert text email has already been taken.
      9.	Empty reason field then click update button.
      10.	Assert text reason cannot be blank.
      11.	Select other in reason and Type reason 2 in reason field. Click add button
      12.	Assert text reason has already been registered.
      13.	Empty patient name field then click update button
      14.	Assert text patient name cannot be blank.
     */

    function Scenario3() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->open("/index.php?r=visit/detail&id=1");
        $this->type("id=Visitor_email", "");
        $this->type("id=Visitor_contact_number", "");
        $this->click("id=submitContactDetailForm");
        sleep(1);
        $this->waitForElementPresent("id=Visitor_email_em_");
        $this->assertEquals("Email Address cannot be blank.", $this->getText("id=Visitor_email_em_"));
        $this->type("id=Visitor_email", "testVisitor3@test.com");
        $this->type("id=Visitor_contact_number", "1234567890");
        $this->click("id=submitContactDetailForm");
        $this->assertEquals("Email Address has already been taken.", $this->getText("xpath=(//div[@id='Visitor_email_em_'])[2]"));
        $this->select("id=Visit_reason", "label=Select Reason");
        $this->click("id=submitReasonForm");
        sleep(1);
        $this->assertEquals("Reason cannot be blank.", $this->getText("id=Visit_reason_em_"));
        $this->select("id=Visit_reason", "label=Other");
        $this->click("id=submitReasonForm");
        $this->assertEquals("Reason cannot be blank.", $this->getText("id=visitReason"));
        $this->type("id=VisitReason_reason", "");
        $this->click("id=submitAddReasonForm");
        sleep(1);
        $this->assertEquals("Reason cannot be blank.", $this->getText("id=VisitReason_reason_em_"));
        $this->type("id=VisitReason_reason", "reason 1");
        $this->click("id=submitAddReasonForm");
        sleep(1);
        $this->assertEquals("Reason is already registered.", $this->getText("id=visitReasonErrorMessage"));
        $this->type("document.forms['update-patient-form'].elements['Patient[name]']", "");
        $this->click("id=submit");
        $this->waitForElementPresent("xpath=(//div[@id='Patient_name_em_'])[2]");
        sleep(1);
        $this->assertEquals("Patient Name cannot be blank.", $this->getText("xpath=(//div[@id='Patient_name_em_'])[2]"));
        $this->type("id=Visitor_email", "123");
        $this->waitForElementPresent("id=Visitor_email_em_");
        sleep(1);
        $this->assertEquals("Email Address is not a valid email address.", $this->getText("id=Visitor_email_em_"));
    }

    /* Scenario 4 –Login as super admin and Check for validations in updating a corporate visitor
      Expected behavior
      -	Assert text mobile number cannot be blank
      -	Assert text email address cannot be blank
      -	Assert text email address has already been taken.
      -	Assert text reason cannot be blank
      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in email field and 12345 in password field
      3.	Click login
      4.	Click administration
      5.	Go to http://cvms.identitysecurity.info/index.php?r=visit/detail&id=5
      6.	Empty all fields under host details then click update button
      7.	Assert text first name cannot be blank, last name cannot be blank, email cannot be blank and contact no. cannot be blank
      8.	Type test in first name, test in last name, staffmember@test.com in email field and 123456 in mobile field.
      9.	Click save button and assert text email has already been taken.
     */

    function Scenario4() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->open("/index.php?r=visit/detail&id=6");
        $this->type("document.forms['register-host-form'].elements['User[first_name]']", "");
        $this->type("document.forms['register-host-form'].elements['User[last_name]']", "");
        $this->type("document.forms['register-host-form'].elements['User[department]']", "");
        $this->type("document.forms['register-host-form'].elements['User[staff_id]']", "");
        $this->type("document.forms['register-host-form'].elements['User[email]']", "");
        $this->type("document.forms['register-host-form'].elements['User[contact_number]']", "");
        $this->click("document.forms['register-host-form'].yt0");
        $this->waitForElementPresent("xpath=(//div[@id='User_first_name_em_'])[2]");
        sleep(1);
        $this->assertEquals("First Name cannot be blank.", $this->getText("xpath=(//div[@id='User_first_name_em_'])[2]"));
        $this->assertEquals("Last Name cannot be blank.", $this->getText("xpath=(//div[@id='User_last_name_em_'])[2]"));
        $this->assertEquals("Email cannot be blank.", $this->getText("xpath=(//div[@id='User_email_em_'])[2]"));
        $this->assertEquals("Contact No. cannot be blank.", $this->getText("xpath=(//div[@id='User_contact_number_em_'])[2]"));
        $this->type("document.forms['register-host-form'].elements['User[first_name]']", "Test");
        $this->type("document.forms['register-host-form'].elements['User[last_name]']", "Host");
        $this->type("document.forms['register-host-form'].elements['User[email]']", "admin@test.com");
        $this->type("document.forms['register-host-form'].elements['User[contact_number]']", "123456");
        $this->click("document.forms['register-host-form'].yt0");
        sleep(1);
        $this->waitForElementPresent("id=User_email_em_1a");
        $this->assertEquals("Email Address has already been taken.", $this->getText("id=User_email_em_1a"));
        $this->type("document.forms['register-host-form'].elements['User[email]']", "123");
        $this->waitForElementPresent("xpath=(//div[@id='User_email_em_'])[2]");
        sleep(1);
        $this->assertEquals("Email is not a valid email address.", $this->getText("xpath=(//div[@id='User_email_em_'])[2]"));
    }

}

?>