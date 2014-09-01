<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

/**
 * Description of Issue3FunctionalTest
 *
 * @author Jeremiah
 */
class Issue3FunctionalTest extends PHPUnit_Extensions_SeleniumTestCase {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://localhost/");
    }

    /*Scenario 1 – Login as super admin and add user Admin
Expected Behavior 
-	Save new account
-	Assert ‘testadmin@test.com’
-	Assert role ‘Administrator’
Steps:
1.	Go to localhost/vms
2.	Type superadmin@test.com in username field
3.	Type 12345 in password field
4.	Click Login 
5.	Click ‘Administration’
6.	Click ‘Add Administrator’
7.	Type ‘testadmin@test.com’ in email field
8.	Fill up remaining fields 
9.	Click Create
10.	Assert text ‘testadmin@test.com’
11.	Assert text ‘Administrator’
*/
    function testScenario1(){
        $username = 'superadmin@test.com';
        $this->login($username,'12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Add Administrator");
        $this->waitForPageToLoad("30000");
        $this->type("id=User_first_name", "New");
        $this->type("id=User_last_name", "Admin");
        $this->type("id=User_email", "newadmin@test.com");
        $this->type("id=User_password", "12345");
        $this->type("id=User_contact_number", "123456");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        for ($second = 0; ; $second++) {
            if ($second >= 60) $this->fail("timeout");
            try {
                if ($this->isElementPresent("//table[@id='yw0']/tbody/tr[4]/td")) break;
            } catch (Exception $e) {}
            sleep(1);
        }

        $this->assertEquals("newadmin@test.com", $this->getText("//table[@id='yw0']/tbody/tr[4]/td"));
        $this->assertEquals("Administrator", $this->getText("//table[@id='yw0']/tbody/tr[14]/td"));
    }

    /*Scenario 2– Login as super admin and add user Agent Admin
            Expected Behavior 
            -	Save new account
            -	Assert ‘testadmin@test.com’
            -	Assert role ‘Administrator’
            Steps:
            1.	Go to localhost/vms
            2.	Type superadmin@test.com in username field
            3.	Type 12345 in password field
            4.	Click Login 
            5.	Click ‘Administration’
            6.	Click ‘Add Agent Administrator’
            7.	Type ‘testadmin@test.com’ in email field
            8.	Fill up remaining fields 
            9.	Click Create
            10.	Assert text ‘testadmin@test.com’
            11.	Assert text ‘Administrator’
            */
    function testScenario2(){
        $username = 'superadmin@test.com';
        $this->login($username,'12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Add Agent Administrator");
        $this->waitForPageToLoad("30000");
        $this->type("id=User_first_name", "New");
        $this->type("id=User_last_name", "Agent Admin");
        $this->type("id=User_email", "newagentadmin@test.com");
        $this->type("id=User_password", "12345");
        $this->type("id=User_contact_number", "123456");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        for ($second = 0; ; $second++) {
            if ($second >= 60) $this->fail("timeout");
            try {
                if ($this->isElementPresent("//table[@id='yw0']/tbody/tr[4]/td")) break;
            } catch (Exception $e) {}
            sleep(1);
        }

        $this->assertEquals("newagentadmin@test.com", $this->getText("//table[@id='yw0']/tbody/tr[4]/td"));
        $this->assertEquals("Agent Administrator", $this->getText("//table[@id='yw0']/tbody/tr[14]/td"));
    }
    /*
Scenario 3– Login as super admin and add user Admin, check for errors
Expected Behavior 
-	Assert text ‘Please fix the following input field.’
Steps:
1.	Go to localhost/vms
2.	Type superadmin@test.com in username field
3.	Type 12345 in password field
4.	Click Login 
5.	Click ‘Administration’
6.	Click ‘Add Administrator’ 
7.	Click Create
8.	Assert text ‘Please fix the following input errors.’
     */
    function testScenario3(){
        $username = 'superadmin@test.com';
        $this->login($username,'12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Add Administrator");
        $this->waitForPageToLoad("30000");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        for ($second = 0; ; $second++) {
            if ($second >= 60) $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=div.errorSummary")) break;
            } catch (Exception $e) {}
            sleep(1);
        }

        $this->assertEquals("Please fix the following input errors:", $this->getText("css=div.errorSummary > p"));
    }
    
    function login($username = NULL,$password = NULL){
        $this->open("http://localhost/vms");
        $this->click("link=Login");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", $username);
        $this->type("id=LoginForm_password", $password);
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");    
    }
   
}

?>