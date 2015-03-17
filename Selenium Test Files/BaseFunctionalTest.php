<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This base functional test is an 
 *
 * @author jeremiah
 */
class BaseFunctionalTest extends PHPUnit_Extensions_SeleniumTestCase {

    protected $captureScreenshotOnFailure = TRUE;
    protected $screenshotPath = 'C:/xampp/htdocs/screenshots';
    protected $screenshotUrl = 'http://localhost/screenshots';

    protected function setUp() {

        parent::setUp();
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }

    public function resetDb() {
        $this->open("http://dev.identitysecurity.info/index.php?r=site/resetDb");
        $this->assertEquals("Tables imported successfully", $this->getText("css=body"));
        
        $this->open("http://dev.identitysecurity.info/index.php?r=site/DBpatch");
        $this->assertEquals("--== Starting Patcher ==-- \nDone patch for issue81", $this->getText("css=body"));
        
    }

    public function resetDbWithData() {
        $this->start();
        $this->open("http://dev.identitysecurity.info/index.php?r=site/resetDb2");
        $this->assertEquals("Tables imported successfully", $this->getText("css=body"));
        
        $this->open("http://dev.identitysecurity.info/index.php?r=site/DBpatch");
        $this->assertEquals("--== Starting Patcher ==-- \nDone patch for issue81", $this->getText("css=body"));
    }
    
    public function issue35Sql() {
        $this->start();
        $this->open("http://dev.identitysecurity.info/index.php?r=site/issue35UpdateDatabaseRecord");
        $this->assertEquals("Tables updated successfully", $this->getText("css=body"));
    }
    
    public function issue48Sql() {
        $this->start();
        $this->open("http://dev.identitysecurity.info/index.php?r=site/issue48UpdateDatabaseRecord");
        $this->assertEquals("Tables updated successfully", $this->getText("css=body"));
    }
    
    

    public function __destruct() {
        parent::__destruct();
    }

    function login($username = NULL, $password = NULL) {
        $this->open("http://dev.identitysecurity.info/index.php?r=site/login");

        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", $username);
        $this->type("id=LoginForm_password", $password);
        $this->click("name=yt0");
        $this->clickAndWait("name=yt0");
    }

    function updatePassword($id = NULL) {
        $this->open("http://dev.identitysecurity.info/index.php?r=password/update&id=" . $id);
        $this->type("name=Password[password]", "admin");
        $this->type("name=Password[repeatpassword]", "admin");
        $this->click("id=updateBtn");
        $this->click("id=save");
        $this->waitForPageToLoad("30000");
    }

    function addUser($email = NULL, $lastname = NULL) {
        $this->type("id=User_first_name", "Test");
        $this->type("id=User_last_name", $lastname);
        $this->type("id=User_email", $email);
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->type("id=User_contact_number", "123456");
        $this->select("id=fromDay", "label=10");
        $this->select("id=fromMonth", "label=Jul");
        $this->select("id=fromYear", "label=1993");
        $this->waitForElementPresent("id=User_department");
        $this->type("id=User_department", "Test Department");
        $this->type("id=User_position", "Test Position");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_notes", "Test Notes");
    }

    function addCompany($companyname = NULL, $companyemail = NULL, $companycode = NULL) {
        $this->click("id=addCompanyLink");
        $this->waitForElementPresent("id=Company_name");
        $this->type("id=Company_name", $companyname);
        $this->type("id=Company_code", $companycode);
        $this->type("id=Company_trading_name", $companyname);
        $this->type("id=Company_contact", "Test Person");
        $this->type("id=Company_billing_address", "123 street");
        $this->type("id=Company_email_address", $companyemail . "@test.com");
        $this->type("id=Company_office_number", "12345");
        $this->type("id=Company_mobile_number", "12345");
        $this->type("id=Company_logo", "1");
        $this->type("id=Company_website", "http://" . $companyemail . ".com");
        $this->waitForElementPresent("id=createBtn");
        //sleep(100);
        $this->clickAndWait("id=createBtn");
        sleep(1);
    }

    function getDisabledRoleValue($value = NULL) {
        $this->assertFalse($this->isElementPresent("id='User_role'"));
        $this->assertEquals($value, $this->getEval("window.document.getElementById(\"User_role\").value"));
    }

    function getDisabledCompanyValue($value = NULL) {
        $this->assertFalse($this->isElementPresent("id='User_company'"));
        $this->assertEquals($value, $this->getEval("window.document.getElementById(\"User_company\").options[window.document.getElementById(\"User_company\").selectedIndex].text"));
    }

    function addinAdministrationCompany($companyname = NULL, $companyemail = NULL, $companycode = NULL) {
        $this->waitForElementPresent("id=Company_name");
        $this->type("id=Company_name", $companyname);
        $this->type("id=Company_code", $companycode);
        $this->type("id=Company_trading_name", $companyname);
        $this->type("id=Company_contact", "Test Person");
        $this->type("id=Company_billing_address", "123 street");
        $this->type("id=Company_email_address", $companyemail . "@test.com");
        $this->type("id=Company_office_number", "12345");
        $this->type("id=Company_mobile_number", "12345");
        $this->type("id=Company_logo", "1");
        $this->type("id=Company_website", "http://" . $companyemail . ".com");
        $this->waitForElementPresent("id=createBtn");
        //sleep(100);
        $this->click("id=createBtn");
        $this->waitForPageToLoad("30000");
    }

    function addVisitor($visitor_name) {
        
        $this->type("id=Visitor_first_name", "Test");
        $this->type("id=Visitor_last_name", $visitor_name);
        $this->type("id=Visitor_contact_number", "1234567");
        $this->type("id=Visitor_position", "Position");
        $this->type("id=Visitor_email", "test" . $visitor_name . "@test.com");
        $this->select("id=Visitor_tenant", "label=NAIA Airport");
        sleep(1);
        $this->select("id=Visitor_tenant_agent", "label=Philippine Airline");
        sleep(1);
        $this->select("id=Visitor_company", "label=NAIA Airport");
        sleep(1);
        $this->type("id=Visitor_password", "12345");
        $this->type("id=Visitor_repeatpassword", "12345");
        $this->type("id=Visitor_vehicle", "ABC123");
        
    }

    function addReason($reason) {
        $this->select("id=Visit_reason", "label=Other");
        $this->type("id=VisitReason_reason", $reason);
    }

    function addHost($host_name) {
        $this->type("id=User_first_name", "Test");
        $this->type("id=User_last_name", $host_name);
        $this->type("id=User_department", "Department");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_email", "test".$host_name."@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->select("id=User_tenant", "label=NAIA Airport");
        sleep(1);
        $this->select("id=User_tenant_agent", "label=Philippine Airline");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeatpassword", "12345");
        sleep(1);
    }

    function addPatient($patient_name) {
        $this->type("id=Patient_name", $patient_name);
    }

    function verifyVisitorInTable($visitor_name) {
        $this->waitForElementPresent("link=Manage Visitors");
        $this->click("link=Manage Visitors");
        $this->waitForElementPresent("name=Visitor[first_name]");
        $this->type("name=Visitor[first_name]", "Test");
        $this->type("name=Visitor[last_name]", $visitor_name);
        $this->type("name=Visitor[email]", "test" . $visitor_name . "@test.com");
        sleep(1);
        $this->assertEquals("test" . $visitor_name . "@test.com", $this->getText("//div[@id='visitor-grid']/table/tbody/tr/td[3]"));
        sleep(1);
        $this->assertEquals("Displaying 1-1 of 1 result", $this->getText("css=div.summary"));
    }

    function testBlank() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info/");
    }
    function clearMailcatcher(){
        $this->start();
        $this->open("http://localhost:1080/");
        $this->selectWindow("title=MailCatcher");
        $this->windowFocus();

        $this->click("link=Clear");
        $this->getConfirmation();
        $this->chooseOkOnNextConfirmation();
    }
    

}
