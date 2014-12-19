<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';
date_default_timezone_set('Asia/Manila');

/**
 * Description of Issue27FunctionalTest
 * Administration Visits
 * @author Jeremiah
 */
class Issue27FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario5();
        $this->Scenario6();
        $this->Scenario7();
        $this->resetDbWithData();
        $this->Scenario8();
        $this->Scenario9();
        $this->Scenario10();
        $this->Scenario11();
        $this->resetDbWithData();
        $this->Scenario12();
        $this->Scenario13();
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
      6.	Click manage visits type test visitor 1 in visitor search filter. select same day visitor in card type, patient visitor in visitor type and reason 1 in reason
      7.	Click edit and wait for page to load. Assert first name: test , last name: visitor1, email: testvisitor1@test.com, mobile: 123456, visitor type:patient visitor, reason: reason 1, Patient name: patient name 1.
      8.	Type 09123456789 in mobile number and testvisitorB@test.com in email field for contact details. Click update button under contact details.
      9.	Assert contact details updated successfully. select other in reason then Type reason 3 in reason field then click add button under reason. assert reason added successfully.
      10.	Click update button under reason and assert reason updated successfully. Type patient name 3 in patient name field. Click update button under patient details.
      11.	Assert patient updated successfully.

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visits");        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor1");
        sleep(1);
        $this->select("name=Visit[card_type]", "label=Same Day Visitor");
        $this->select("name=Visit[visitor_type]", "label=Patient Visitor");
        sleep(1);
        $this->select("name=Visit[reason]", "label=Reason 1");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Test Visitor1" == $this->getText("css=tr.odd > td"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Reason 1" == $this->getText("//div[@id='visit-grid']/table/tbody/tr/td[4]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->clickAndWait("link=Edit");
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
        sleep(1);
        $this->waitForElementPresent("css=div.flash-success.success-add-reason");
        $this->assertEquals("Reason Added Successfully.", $this->getText("css=div.flash-success.success-add-reason"));

        $this->click("id=submitReasonForm");

        $this->waitForElementPresent("css=div.flash-success.success-update-reason");
        $this->assertEquals("Reason Updated Successfully.", $this->getText("css=div.flash-success.success-update-reason"));

        $this->type("document.forms['update-patient-form'].elements['Patient[name]']", "Patient Name 3");
        $this->click("id=submit");
        sleep(1);
        $this->click("link=Manage Visits");        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor1");
        sleep(1);
        $this->select("name=Visit[card_type]", "label=Same Day Visitor");
        $this->select("name=Visit[visitor_type]", "label=Patient Visitor");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Test Visitor1" == $this->getText("css=tr.odd > td"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->select("name=Visit[reason]", "label=Reason 3");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Reason 3" == $this->getText("//div[@id='visit-grid']/table/tbody/tr/td[4]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->clickAndWait("link=Edit");

        $this->assertEquals("testVisitorB@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("1234567890", $this->getValue("id=Visitor_contact_number"));
        $this->assertEquals("1", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("3", $this->getValue("id=Visit_reason"));
        $this->assertEquals("Patient Name 3", $this->getValue("document.forms['update-patient-form'].elements['Patient[name]']"));
    }

    /* Scenario 2 – Login as super admin then perform update visitor functionality for corporate visitor type
      Expected Behavior
      -	Assert text testvisitor4@test.com in email field.
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
        $this->click("link=Manage Visits");        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor4");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Test Visitor4" == $this->getText("css=tr.odd > td"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->clickAndWait("link=Edit");

        $this->assertEquals("testVisitor4@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("2", $this->getValue("id=Visit_visitor_type"));
        $this->type("id=Visitor_email", "testVisitorC@test.com");
        $this->type("id=Visitor_contact_number", "1234567890");
        $this->click("id=submitContactDetailForm");
        sleep(1);
        $this->select("id=Visit_reason", "label=Reason 2");
        $this->click("id=submitReasonForm");
        sleep(1);
        $this->click("link=Manage Visits");        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor4");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Test Visitor4" == $this->getText("css=tr.odd > td"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->clickAndWait("link=Edit");

        $this->assertEquals("testVisitorC@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("1234567890", $this->getValue("id=Visitor_contact_number"));
        $this->assertEquals("2", $this->getValue("id=Visit_reason"));
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
        $this->click("link=Manage Visits");        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor1");
        $this->select("name=Visit[card_type]", "label=Same Day Visitor");
        $this->select("name=Visit[visitor_type]", "label=Patient Visitor");
        $this->select("name=Visit[reason]", "label=Reason 3");

        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Test Visitor1" == $this->getText("css=tr.odd > td"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Reason 3" == $this->getText("//div[@id='visit-grid']/table/tbody/tr/td[4]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->clickAndWait("link=Edit");

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
        $this->waitForElementPresent("document.forms['update-patient-form'].elements['Patient[name]']");
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
        $this->click("link=Manage Visits");        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor4");
        $this->select("name=Visit[card_type]", "label=Same Day Visitor");
        $this->select("name=Visit[visitor_type]", "label=Corporate Visitor");
        $this->select("name=Visit[reason]", "label=Reason 2");
        sleep(1);
        $this->clickAndWait("link=Edit");
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

    /* Scenario 5 – Login as super admin update a patient visitor to corporate visitor. Add new host and check validations
      Expected Behavior
      -	Assert corporate visitor in visitor type
      -	Assert testHostB@test.com in host email field
      -	Assert text first name cannot be blank, last name cannot be blank, contact number cannot be blank, email cannot be blank, and Company name cannot be blank.
      -	Assert text email is not a valid email address
      -	Assert text email has already been taken

      Steps:
      1.	Log in as superadmin@test.com with 12345  as password
      2.	Click administration
      3.	Click manage visits
      4.	Type test visitor1 in name search field, select patient type in visitor type and select reason 3 in reason. Click edit
      5.	Assert email testVisitorB@test.com
      6.	Select corporate visitor in visitor type
      7.	Wait for host details to show below
      8.	Click add button
      9.	Assert text first name cannot be blank, last name cannot be blank, contact number cannot be blank, email cannot be blank, and Company name cannot be blank.
      10.	Type 123 in email
      11.	Assert text email is not a valid email address.
      12.	Type test in first name, newhostA in last name, admin@test.com in email field, 12345 in contact no., select test admin in tenant, select tenant agentadmin in tenant agent, and test company1 in company name.
      13.	Click add button
      14.	Assert text email address has already been taken.
      15.	Type testnewHostA@test.com in email field
      16.	Click manage visits
      17.	Type test visitor1 in name search field, select corporate type in visitor type and select reason 3 in reason. Click edit
      18.	Assert email testVisitorB@test.com
      19.	Assert corporate type in visitor type
      20.	Assert email testnewHostA@test.com in email field
      21.	Assert test in first name
      22.	Assert newhostA in last name
      23.	Assert 12345 in contact no.
     */

    function Scenario5() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visits");        
        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor1");
        $this->select("name=Visit[visitor_type]", "label=Patient Visitor");
        $this->select("name=Visit[reason]", "label=Reason 3");
        sleep(1);
        $this->clickAndWait("link=Edit");
        $this->assertEquals("testVisitorB@test.com", $this->getValue("id=Visitor_email"));
        $this->select("id=Visit_visitor_type", "label=Corporate Visitor");
        $this->waitForElementPresent("document.forms['register-newhost-form'].yt0");
        $this->click("document.forms['register-newhost-form'].yt0");
        sleep(1);
        $this->assertEquals("First Name cannot be blank.", $this->getText("id=User_first_name_em_"));
        $this->assertEquals("Last Name cannot be blank.", $this->getText("id=User_last_name_em_"));
        $this->assertEquals("Email cannot be blank.", $this->getText("id=User_email_em_"));
        $this->assertEquals("Contact No. cannot be blank.", $this->getText("id=User_contact_number_em_"));
        $this->assertEquals("Company Name cannot be blank.", $this->getText("id=User_company_em_"));
        $this->type("id=User_first_name", "test");
        $this->type("id=User_last_name", "newhostA");
        $this->type("id=User_email", "admin@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        $this->select("id=User_tenant", "label=Test admin");
        sleep(1);
        $this->select("id=User_tenant_agent", "label=Test agentadmin");
        $this->waitForElementPresent("document.forms['register-newhost-form'].yt0");
        $this->click("document.forms['register-newhost-form'].yt0");
        $this->waitForElementPresent("id=New_user_email_em_");
        $this->assertEquals("Email Address has already been taken.", $this->getText("id=New_user_email_em_"));
        $this->type("id=User_email", "testnewHosts@test.com");
        sleep(1);
        $this->click("document.forms['register-newhost-form'].yt0");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Host Added Successfully." == $this->getText("css=div.flash-success.success-add-host"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->waitForElementPresent("css=div.flash-success.success-add-host");
        $this->assertEquals("Host Added Successfully.", $this->getText("css=div.flash-success.success-add-host"));
        sleep(10);
        $this->waitForElementPresent("css=div.flash-success.success-update-visitor-type");
        $this->assertEquals("Visitor Type Updated Successfully.", $this->getText("css=div.flash-success.success-update-visitor-type"));
        sleep(1);
        $this->click("link=Manage Visits");        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor1");
        $this->select("name=Visit[visitor_type]", "label=Corporate Visitor");
        sleep(1);
        $this->select("name=Visit[reason]", "label=Reason 3");
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Test Visitor1" == $this->getText("css=tr.odd > td"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Reason 3" == $this->getText("//div[@id='visit-grid']/table/tbody/tr/td[4]"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->clickAndWait("link=Edit");
        $this->assertEquals("testVisitorB@test.com", $this->getValue("id=Visitor_email"));
        $this->assertEquals("2", $this->getValue("id=Visit_visitor_type"));
        $this->assertEquals("testnewHosts@test.com", $this->getValue("document.forms['register-host-form'].elements['User[email]']"));
        $this->assertEquals("test", $this->getValue("document.forms['register-host-form'].elements['User[first_name]']"));
        $this->assertEquals("newhostA", $this->getValue("document.forms['register-host-form'].elements['User[last_name]']"));
    }

    /*
      Scenario 6- Login as super admin and add log visit for same day card type
      Expected Behavior
      -	Assert date in 2014-11-25
      -	Assert date out 2014-11-25
      -	Assert time in 11:24
      Steps:
      1.	Login as superadmin@test.com use 12345 as password
      2.	Click administration
      3.	Click manage visits
      4.	Type test visitor1 in name search field, select reason 3 and click edit
      5.	Select November 25, 2014 in datepicker for date in
      6.	Select November 25, 2014 in datepicker for date out
      7.	Select 11 in hours dropdown and 24 in minutes dropdown
      8.	Click update button
      9.	Click manage visits
      10.	Type test visitor1 in name search field, select reason 3 and click edit
      11.	Assert value date in is 2014-11-25
      12.	Assert value date out is 2014-11-25
      13.	Assert hour selected 11
      14.	Assert minute selected 24
     */

    function Scenario6() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visits");        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor1");
        $this->select("name=Visit[reason]", "label=Reason 3");
        sleep(1);
        $this->clickAndWait("link=Edit");
        $this->click("//li[@id='preregisterLi']/a/span");
        $currentDate = date('d-m-Y');
        $this->assertEquals(date('d-m-Y', time() + 86400), $this->getEval("window.document.getElementById(\"Visit_date_in\").value"));
        $this->assertEquals(date('d-m-Y', time() + 86400), $this->getEval("window.document.getElementById(\"Visit_date_out\").value"));
        $currentHour = date('H');
        $currentMinute = date('i');
        $this->select("id=Visit_time_in_hours", "label=" . $currentHour);
        $this->select("id=Visit_time_in_minutes", "label=" . $currentMinute);
        $this->click("css=#update-log-visit-form > input[type='submit']");
        $this->waitForElementPresent("css=div.flash-success.success-update-preregister");
        $this->click("link=Manage Visits");
        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor1");
        $this->select("name=Visit[reason]", "label=Reason 3");
        sleep(1);
        $this->clickAndWait("link=Edit");
        $this->assertEquals(date('d-m-Y', time() + 86400), $this->getEval("window.document.getElementById(\"Visit_date_in\").value"));
        $this->assertEquals(date('d-m-Y', time() + 86400), $this->getEval("window.document.getElementById(\"Visit_date_out\").value"));

        $this->assertEquals($currentHour, $this->getValue("id=Visit_time_in_hours"));
        $this->assertEquals($currentMinute, $this->getValue("id=Visit_time_in_minutes"));
    }

    /*
      Scenario 7- Login as super admin and add log visit for multiday card type
      Expected Behavior
      -	Assert date in 2014-11-25
      -	Assert date out 2014-11-27
      -	Assert time in 11:24
      Steps:
      1.	Login as superadmin@test.com use 12345 as password
      2.	Click administration
      3.	Click manage visits
      4.	Type test visitor1 in name search field, select reason 1 in reason, multi day in card type
      5.	Click edit then click log visit
      6.	Click date in input text and select november 25 in datepicker in date out select november 27
      7.	Select 11 in hours dropdown and 24 in minutes dropdown
      8.	Click update button
      9.	Click manage visits
      10.	Type test visitor1 in name search field, select multi day visitor then click edit.
      11.	Click log visit. Assert value date in is 2014-11-25
      12.	Assert value date out is 2014-11-27
      13.	Assert hour selected 11
      14.	Assert minute selected 24
     */

    function Scenario7() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visits");        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor1");
        $this->select("name=Visit[card_type]", "label=Multi Day Visitor");
        sleep(1);
        $this->clickAndWait("link=Edit");
        $this->click("//li[@id='preregisterLi']/a/span");
        sleep(1);
        $this->select("id=Visit_time_in_hours", "label=11");
        $this->select("id=Visit_time_in_minutes", "label=24");
        $this->click("css=#update-log-visit-form > input[type=\"submit\"]");
        $this->assertEquals("Visit Successfully Updated.", $this->getText("css=div.flash-success.success-update-preregister"));

        $this->click("link=Manage Visits");
        $this->waitForElementPresent("name=Visit[visitor]");
        $this->type("name=Visit[visitor]", "test visitor1");
        $this->select("name=Visit[card_type]", "label=Multi Day Visitor");
        sleep(1);
        $this->select("name=Visit[reason]", "label=Reason 1");
        sleep(1);
        $this->clickAndWait("link=Edit");
        $this->click("//li[@id='preregisterLi']/a/span");
        sleep(1);
        $this->assertEquals(date('d-m-Y', time() + 86400), $this->getValue("id=Visit_date_in"));
        $this->assertEquals(date('d-m-Y', time() + 172800), $this->getValue("id=Visit_date_out"));
        $this->assertEquals("11", $this->getValue("id=Visit_time_in_hours"));
        $this->assertEquals("24", $this->getValue("id=Visit_time_in_minutes"));
    }

    /* Scenario 8 - Preregister a Visitor for same day card, activate visit
      Expected Behavior - Assert close visit in card actions, Assert current date in date expiration
     */

    function Scenario8() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitor Records");
        $this->waitForElementPresent("link=Preregister a Visitor");
        $this->clickAndWait("link=Preregister a Visitor");
        $this->click("id=clicktabA");
        $this->addVisitor('Visitor0a');
        $this->select("id=workstation", "label=Workstation1");
        $this->select("id=Visit_reason", "label=Reason 1");
        $this->click("id=submitFormVisitor");
        $this->addPatient("Patient Name 0");
        $this->clickAndWait("id=submitFormPatientName");
        $this->assertEquals("Same Day Visitor", $this->getText("css=#cardDetailsTable > tbody > tr > td"));
        $date = date('d/m/Y');
        $date2 = date('d-m-Y', time() + 86400);
        $this->assertEquals($date, $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td"));
        $this->assertEquals($date2, $this->getEval("window.document.getElementById(\"Visit_date_in\").value"));
        $this->assertEquals($date2, $this->getEval("window.document.getElementById(\"Visit_date_out\").value"));
        $this->click("css=#update-log-visit-form > input[type=\"submit\"]");
        $this->waitForElementPresent("css=div.flash-success.success-update-preregister");
        $this->assertEquals("Visit Successfully Updated.", $this->getText("css=div.flash-success.success-update-preregister"));
        $this->click("//li[@id='activateLi']/a/span");
        $this->clickAndWait("css=#activate-a-visit-form > input[type=\"submit\"]");

        $this->assertEquals("Close Visit", $this->getText("//li[@id='closevisitLi']/a/span"));
        $this->assertEquals($date, $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td"));
        $this->clickAndWait("css=#close-visit-form > input[type=\"submit\"]");
        $this->assertEquals("Visit Status: Closed", $this->getText("link=Visit Status: Closed"));
        $this->assertEquals(date('d-m-Y'), $this->getText("//div[@id='visit-grid']/table/tbody/tr/td[5]"));
        $this->assertEquals(date('d-m-Y'), $this->getText("//div[@id='visit-grid']/table/tbody/tr/td[3]"));
    }

    /* Scenario 9 - Preregister a Visitor for multi day card, activate visit
      Expected Behavior - Assert close visit in card actions, Assert date expiration is same with selected date.
     */

    function Scenario9() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitor Records");
        $this->waitForElementPresent("link=Preregister a Visitor");
        $this->clickAndWait("link=Preregister a Visitor");
        $this->click("id=multiday");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->click("id=clicktabB1");
        $this->type("id=Patient_name", "patient 0a");
        $this->clickAndWait("id=submitFormPatientName");

        $this->assertEquals("Multi Day Visitor", $this->getText("css=#cardDetailsTable > tbody > tr > td"));
        $date = date('d/m/Y');
        $date2 = date('d-m-Y', time() + 86400);
        $date3 = date('d-m-Y', time() + 172800);
        $this->assertEquals($date, $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td"));
        $this->assertEquals($date2, $this->getEval("window.document.getElementById(\"Visit_date_in\").value"));
        $this->assertEquals($date3, $this->getEval("window.document.getElementById(\"Visit_date_out\").value"));
        $this->click("css=#update-log-visit-form > input[type=\"submit\"]");

        $this->click("css=#update-log-visit-form > input[type=\"submit\"]");
        $this->waitForElementPresent("css=div.flash-success.success-update-preregister");
        $this->assertEquals("Visit Successfully Updated.", $this->getText("css=div.flash-success.success-update-preregister"));
        $this->click("//li[@id='activateLi']/a/span");
        $this->clickAndWait("css=#activate-a-visit-form > input[type=\"submit\"]");
        $this->assertEquals(date('d/m/Y', time() + 172800), $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td"));
        $this->clickAndWait("css=#close-visit-form > input[type=\"submit\"]");
        $this->assertEquals("Visit Status: Closed", $this->getText("link=Visit Status: Closed"));
        $this->assertEquals(date('d-m-Y'), $this->getText("//div[@id='visit-grid']/table/tbody/tr/td[5]"));
        $this->assertEquals(date('d-m-Y'), $this->getText("//div[@id='visit-grid']/table/tbody/tr/td[3]"));
    }

    /* Scenario 10 - Register a Visitor for same day card, verify dates same as current day. 
      Expected Behavior - Assert close visit in card actions, Assert date expiration is same with selected date.
     */

    function Scenario10() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitor Records");
        $this->waitForElementPresent("link=Register a Visitor");
        $this->clickAndWait("link=Register a Visitor");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->click("id=clicktabB1");
        $this->type("id=Patient_name", "patient 0a");
        $this->click("id=submitFormPatientName");
        try {
            $this->assertEquals(date('d-m-Y'), $this->getValue("id=Visit_date_inLog"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals("Same Day Visitor", $this->getText("css=#cardDetailsTable > tbody > tr > td"));
        $date = date('d/m/Y');
       // $this->assertEquals($date, $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td"));
        $this->assertEquals(date('d-m-Y'), $this->getEval("window.document.getElementById(\"Visit_date_check_out\").value"));
        $this->assertEquals("Close Visit", $this->getText("//li[@id='closevisitLi']/a/span"));

        $this->clickAndWait("css=#close-visit-form > input[type=\"submit\"]");
        $this->assertEquals("Visit Status: Closed", $this->getText("link=Visit Status: Closed"));
        $this->assertEquals(date('d-m-Y'), $this->getText("//div[@id='visit-grid']/table/tbody/tr/td[5]"));
//        $this->assertEquals(date('d-m-Y'), $this->getText("//div[@id='visit-grid']/table/tbody/tr/td[3]"));
    }

    /* Scenario 11 - Register a Visitor for multi day card, verify dates 1 day from now. 
      Expected Behavior - Assert close visit in card actions, Assert date expiration is same with selected date.
     */

    function Scenario11() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitor Records");
        $this->waitForElementPresent("link=Register a Visitor");
        $this->clickAndWait("link=Register a Visitor");
        $this->click("id=multiday");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->click("id=clicktabB1");
        $this->type("id=Patient_name", "patient 0a");
        $this->click("id=submitFormPatientName");
        try {
            $this->assertEquals(date('d-m-Y'), $this->getValue("id=Visit_date_inLog"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }

        $this->type("id=proposedDateOut", date('d-m-Y', time() + 86400));
        $this->type("id=Visit_date_out", date('d-m-Y', time() + 86400));
        $this->clickAndWait("id=submitAllForms");

        $this->assertEquals("Multi Day Visitor", $this->getText("css=#cardDetailsTable > tbody > tr > td"));
        try {
            $this->assertEquals(date('d-m-Y'), $this->getValue("id=Visit_date_check_out"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }

        $this->assertEquals("Close Visit", $this->getText("//li[@id='closevisitLi']/a/span"));
        $this->assertEquals(date('d/m/Y', time() + 86400), $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td"));
        $this->clickAndWait("css=#close-visit-form > input[type=\"submit\"]");
        $this->assertEquals("Visit Status: Closed", $this->getText("link=Visit Status: Closed"));
    }

    /* Scenario 12 - Check date validation for same day and muti day cards. Preregister function

      Expected Behavior - For same day , proposed date in and date out should be the same.
      For multi day, proposed date in and date out default should be 1 day from now. and 1 day apart eg. 12-12-2014 and 13-12-2014.
      For multi day, if proposed date out is supplied already. Proposed date out under log a visit should not be present
      if proposed date out is not yet supplied proposed date out in log a visit should be present with default day 1 day from current day.

     */

    function Scenario12() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitor Records");
        $this->waitForElementPresent("link=Preregister a Visitor");
        $this->clickAndWait("link=Preregister a Visitor");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->click("id=clicktabB1");
        $this->type("id=Patient_name", "patient 0a");
        $this->clickAndWait("id=submitFormPatientName");

        $date2 = date('d-m-Y', time() + 86400);
        $this->assertEquals($date2, $this->getEval("window.document.getElementById(\"Visit_date_in\").value"));
        $this->assertEquals($date2, $this->getEval("window.document.getElementById(\"Visit_date_out\").value"));


        $this->assertEquals("Same Day Visitor", $this->getText("css=#cardDetailsTable > tbody > tr > td"));

        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitor Records");
        $this->waitForElementPresent("link=Preregister a Visitor");
        $this->clickAndWait("link=Preregister a Visitor");
        $this->click("id=multiday");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->waitForElementPresent("id=2");
        $this->click("id=2");
        $this->click("id=clicktabB1");
        $this->type("id=Patient_name", "patient 0a");
        $this->clickAndWait("id=submitFormPatientName");
        $this->click("//li[@id='activateLi']/a/span");
        $this->assertEquals("Proposed Date Out", $this->getText("css=#dateoutDiv > td"));
        $this->click("//li[@id='preregisterLi']/a/span");
        $date2 = date('d-m-Y', time() + 86400);
        $date3 = date('d-m-Y', time() + 172800);
        $this->assertEquals($date2, $this->getEval("window.document.getElementById(\"Visit_date_in\").value"));
        $this->assertEquals($date3, $this->getEval("window.document.getElementById(\"Visit_date_out\").value"));


        $this->click("css=#update-log-visit-form > input[type=\"submit\"]");
        $this->assertEquals("Visit Successfully Updated.", $this->getText("css=div.flash-success.success-update-preregister"));
        $this->click("//li[@id='activateLi']/a/span");
        $this->assertFalse($this->isTextPresent("css=#dateoutDiv > td"));
        $this->clickAndWait("css=#activate-a-visit-form > input[type=\"submit\"]");
        $this->assertEquals(date('d/m/Y', time() + 172800), $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td"));
    }

    /* Scenario 13 - Check date validation for same day and muti day cards. Register function

      Expected Behavior - For same day , proposed date in and date out should be the same.
      For multi day, proposed date in and date out default should be 1 day from now. and 1 day apart eg. 12-12-2014 and 13-12-2014.

     */

    function Scenario13() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitor Records");
        $this->waitForElementPresent("link=Register a Visitor");
        $this->clickAndWait("link=Register a Visitor");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->waitForElementPresent("id=3");
        $this->click("id=3");
        $this->click("id=clicktabB1");
        $this->type("id=Patient_name", "patient 0a");
        $this->click("id=submitFormPatientName");
        try {
            $this->assertEquals(date("d-m-Y"), $this->getValue("id=Visit_date_inLog"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->clickAndWait("id=submitAllForms");
//        $this->assertEquals(date("d/m/Y"), $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td"));
        $this->assertEquals("Same Day Visitor", $this->getText("css=#cardDetailsTable > tbody > tr > td"));

        $this->clickAndWait("css=#close-visit-form > input[type=\"submit\"]");

        $this->clickAndWait("link=Administration");
        $this->click("link=Manage Visitor Records");
        $this->waitForElementPresent("link=Register a Visitor");
        $this->clickAndWait("link=Register a Visitor");
        $this->click("id=multiday");
        $this->click("id=clicktabA");
        $this->type("id=search-visitor", "test");
        $this->click("id=dummy-visitor-findBtn");
        $this->select("id=Visit_reason_search", "label=Reason 1");
        $this->select("id=workstation_search", "label=Workstation1");
        $this->waitForElementPresent("id=3");
        $this->click("id=3");
        $this->click("id=clicktabB1");
        $this->type("id=Patient_name", "patient 0a");
        $this->click("id=submitFormPatientName");
        try {
            $this->assertEquals(date("d-m-Y"), $this->getValue("id=Visit_date_inLog"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
        $this->click("id=submitAllForms");
        $this->waitForElementPresent("id=preregisterdateoutError");
        $this->assertEquals("Date Out cannot be blank.", $this->getText("id=preregisterdateoutError"));
        $this->type("id=proposedDateOut", date('d-m-Y', time() + 86400));
        $this->type("id=Visit_date_out", date('d-m-Y', time() + 86400));
        $this->clickAndWait("id=submitAllForms");
        $this->assertEquals(date('d/m/Y', time() + 86400), $this->getText("//table[@id='cardDetailsTable']/tbody/tr[4]/td"));
        $this->clickAndWait("css=#close-visit-form > input[type=\"submit\"]");
    }

}

?>