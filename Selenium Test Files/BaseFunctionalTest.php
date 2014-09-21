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
    }

    public function resetDb() {
        echo 'Resetting Database';
        $return_var = NULL;
        $output = NULL;
        //make sure mysql is in your path
        $sql = 'mysql -u user_vms -pHFz7c9dHrmPqwNGr vms < "vms.sql"';
        exec($sql, $output, $return_var);
    }
    
    public function resetDbWithData() {
        echo 'Resetting Database';
        $return_var = NULL;
        $output = NULL;
        //make sure mysql is in your path
        $sql = 'mysql -u user_vms -pHFz7c9dHrmPqwNGr vms < "vms-withData.sql"';
        exec($sql, $output, $return_var);
    }
    
    public function __destruct() {
        parent::__destruct();
    }

    function login($username = NULL, $password = NULL) {
        $this->open("http://cvms.identitysecurity.info/index.php?r=site/login");

        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", $username);
        $this->type("id=LoginForm_password", $password);
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
    }

    function updatePassword($id = NULL) {
        $this->open("http://cvms.identitysecurity.info/index.php?r=password/update&id=" . $id);
        $this->type("id=Password_currentpassword", "12345");
        $this->type("name=Password[password]", "admin");
        $this->type("name=confirmPassword", "admin");
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
        $this->click("id=User_date_of_birth");
        $this->waitForElementPresent("link=14");
        $this->click("link=14");
        $this->waitForElementPresent("id=User_department");
        $this->type("id=User_department", "Test Department");
        $this->type("id=User_position", "Test Position");
        $this->type("id=User_staff_id", "123456");
        $this->type("id=User_notes", "Test Notes");
    }

    function addCompany($companyname = NULL, $companyemail = NULL) {
        $this->click("id=addCompanyLink");
        $this->waitForElementPresent("id=Company_name");
        $this->type("id=Company_name", $companyname);
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

    function getDisabledRoleValue($value = NULL) {
        $this->assertFalse($this->isElementPresent("id='User_role'"));
        $this->assertEquals($value, $this->getEval("window.document.getElementById(\"User_role\").value"));
    }

    function getDisabledCompanyValue($value = NULL) {
        $this->assertFalse($this->isElementPresent("id='User_company'"));
        $this->assertEquals($value, $this->getEval("window.document.getElementById(\"User_company\").options[window.document.getElementById(\"User_company\").selectedIndex].text"));
    }

    function addinAdministrationCompany($companyname = NULL, $companyemail = NULL) {
        $this->waitForElementPresent("id=Company_name");
        $this->type("id=Company_name", $companyname);
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
    
    function testBlank(){
        assert(true);
    }
}
