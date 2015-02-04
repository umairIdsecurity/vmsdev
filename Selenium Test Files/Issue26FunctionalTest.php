<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue26FunctionalTest
 * visitor detail page
 * @author Jeremiah
 */
class Issue26FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
      //  $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario5();
    }

    /* Scenario 1 – Login as super admin then perform update a visitor functionality for patient visitor type
      Expected Behavior
      -	Assert text testvisitorB@test.com in email field.
      -	Assert text of all fields to verify correct record.


      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.	Go to http://cvms.identitysecurity.info/index.php?r=visit/detail&id=1
      7.	Assert first name: test , last name: visitor1, email: testvisitor1@test.com, mobile: 123456, visitor type:patient visitor, reason: reason 1, Patient name: patient name 1.
      8.	Type 09123456789 in mobile number and testvisitorB@test.com in email field for contact details. Click update button under contact details.
      9.	Assert contact details updated successfully. select other in reason then Type reason 3 in reason field then click add button under reason. Assert reason added successfully. Click update under reason .
      10.	Assert reason updated successfully. Type patient name 3 in patient name field. Click update button under patient details.
      11.	Assert patient updated successfully. Go to http://cvms.identitysecurity.info/index.php?r=visit/detail&id=1. Assert 09123456789 in mobile number, testvisitorB@test.com in email field for contact details.
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
        $this->waitForElementPresent("css=div.flash-success.success-update-contact-details");
        $this->assertEquals("Contact Details Updated Successfully.", $this->getText("css=div.flash-success.success-update-contact-details"));
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=VisitReason_reason", "Reason 3");

        $this->click("id=submitAddReasonForm");
        $this->waitForElementPresent("css=div.flash-success.success-add-reason");
        $this->assertEquals("Reason Added Successfully.", $this->getText("css=div.flash-success.success-add-reason"));

        $this->click("id=submitReasonForm");
        $this->waitForElementPresent("css=div.flash-success.success-update-reason");
        $this->assertEquals("Reason Updated Successfully.", $this->getText("css=div.flash-success.success-update-reason"));

        $this->type("document.forms['update-patient-form'].elements['Patient[name]']", "Patient Name 3");
        $this->click("id=submit");
        $this->waitForElementPresent("css=div.flash-success.success-update-patient");
        $this->assertEquals("Patient Updated Successfully.", $this->getText("css=div.flash-success.success-update-patient"));
    }

    /* Scenario 2 – Login as super admin then perform update visitor functionality for corporate visitor type
      Expected Behavior
      -	Assert text testvisitorC@test.com in email field.
      -	Assert text of all fields to verify correct record.


      Steps:
      1.	Go to cvms.identitysecurity.info/index.php?r=site/login
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click Administration
      6.	Go to http://cvms.identitysecurity.info/index.php?r=visit/detail&id=6
      7.	Assert email field testvisitor4@Test.com in email, and corporate visitor in visitor type.
      8.	Type 09123456789 in mobile number and testvisitorC@test.com in email field for contact details. Click update button under contact details.
      9.	Assert contact details updated successfully. Select reason 2 in reason then click update button. Assert reason updated successfully.
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
        $this->waitForElementPresent("css=div.flash-success.success-update-contact-details");
        $this->assertEquals("Contact Details Updated Successfully.", $this->getText("css=div.flash-success.success-update-contact-details"));

        $this->select("id=Visit_reason", "label=Reason 2");
        $this->click("id=submitReasonForm");
        $this->waitForElementPresent("css=div.flash-success.success-update-reason");
        $this->assertEquals("Reason Updated Successfully.", $this->getText("css=div.flash-success.success-update-reason"));
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
      5.	Go to http://cvms.identitysecurity.info/index.php?r=visit/detail&id=1
      6.	Empty field mobile number and email field. Click update button under contact details.
      7.	Assert email address cannot be blank.
      8.	Type testvisitor3@test.com in email field. Click update and assert text email has already been taken.
      9.	Select select reason in reason field
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

    /* Scenario 5 – Login as super admin update a patient visitor to corporate visitor. Add new host and check validations
      Expected Behavior
      -	Assert corporate visitor in visitor type
      -	Assert testnewhosta@test.com in host email field
      -	Assert text first name cannot be blank, last name cannot be blank, contact number cannot be blank, email cannot be blank, and Company name cannot be blank.
      -	Assert text email is not a valid email address
      -	Assert text email has already been taken

      Steps:
      1.	Log in as superadmin@test.com with 12345  as password
      2.	Click administration
      3.	go to cvms.idsecurity.info/index.php?r=visit/detail&id=1
      5.	Assert email testVisitorB@test.com
      6.	Select corporate visitor in visitor type
      7.	Wait for host details to show below
      8.	Click add button under host details
      9.	Assert text first name cannot be blank, last name cannot be blank, contact number cannot be blank, email cannot be blank,password cannot be blank, repeat password cannot be blank and Company name cannot be blank.
      10.	Type 123 in email
      11.	Assert text email is not a valid email address.
      12.	Type test in first name, newhostA in last name, admin@test.com in email field, 12345 in contact no., select test admin in tenant, select tenant agentadmin in tenant agent, and test company1 in company name.
      13.	Type 12345 in password and repeat password. Click add button
      14.	Assert text email address has already been taken.
      15.	Type testnewHostA@test.com in email field. click add button
      16.	Assert host added successfully in host details and visitor type updated successfully in visitor type.
      17.	go to cvms.idsecurity.info/index.php?r=visit/detail&id=1
      18.	Assert email testVisitorB@test.com
      19.	Assert corporate type in visitor type
      20.	Assert email testnewHostA@test.com in host email field
      21.	Assert test in first name
      22.	Assert newhostA in last name
      23.	Assert 12345 in contact no.
     */

    function Scenario5() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->open("/index.php?r=visit/detail&id=1");
        //$this->assertEquals("testVisitorB@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("testVisitor1@test.com", $this->getValue("id=Visitor_email"));
        $this->select("id=Visit_visitor_type", "label=Corporate Visitor");
        sleep(1);
        $this->click("document.forms['register-newhost-form'].yt0");
        sleep(1);
        $this->assertEquals("First Name cannot be blank.", $this->getText("id=User_first_name_em_"));
        $this->assertEquals("Last Name cannot be blank.", $this->getText("id=User_last_name_em_"));
        $this->assertEquals("Email cannot be blank.", $this->getText("id=User_email_em_"));
        $this->assertEquals("Contact No. cannot be blank.", $this->getText("id=User_contact_number_em_"));
        $this->assertEquals("Password cannot be blank.", $this->getText("id=User_password_em_"));
        $this->assertEquals("Repeat Password cannot be blank.", $this->getText("id=User_repeatpassword_em_"));
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "newhostA");
        $this->type("id=User_email", "admin@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->select("id=User_tenant", "label=Test admin");
        sleep(1);
        $this->select("id=User_tenant_agent", "label=Test agentadmin");
        sleep(1);
        $this->click("document.forms['register-newhost-form'].yt0");
        sleep(1);
        $this->assertEquals("Email Address has already been taken.", $this->getText("id=New_user_email_em_"));
        $this->type("id=User_email", "testnewHostA@test.com");
        $this->click("document.forms['register-newhost-form'].yt0");
        
        $this->waitForElementPresent("css=div.flash-success.success-add-host");
        $this->assertEquals("Host Added Successfully.", $this->getText("css=div.flash-success.success-add-host"));
        
        $this->waitForElementPresent("css=div.flash-success.success-update-visitor-type");
        $this->assertEquals("Visitor Type Updated Successfully.", $this->getText("css=div.flash-success.success-update-visitor-type"));

    }

}

?>
