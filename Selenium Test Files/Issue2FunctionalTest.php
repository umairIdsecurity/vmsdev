<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue 2
 *
 * @author Jeremiah
 */
class Issue2 extends BaseFunctionalTest {

    
    protected function setUp() {
        parent::setUp();
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://localhost/vms");
    }
   /** 
    Scenario 1 – Login as super admin
        Expected Behavior 
        -	Update password
        -	Assert ‘Password successfully updated’

        Steps:
        1.	Go to localhost/vms
        2.	Type superadmin@test.com in username field
        3.	Type 12345 in password field
        4.	Click Login 
        5.	Open ‘http://localhost/vms/index.php?r=password’
        6.	Type ‘12345’ in current password
        7.	Type ‘admin’ in new password
        8.	Type ‘admin’ in repeat new password
        9.	Click ‘update’ button
        10.	Assert text ‘Password successfully updated’
    **
    */

    function testScenario1() {
        $username = 'superadmin@test.com';
        $this->login($username,'12345');
        $this->updatePassword('16');
    }
    /*
Scenario 2– Login as administrator
Expected Behavior 
-	Update password
-	Assert ‘Password successfully updated’

Steps:
1.	Go to localhost/vms
2.	Type admin@test.com in username field
3.	Type 12345 in password field
4.	Click Login 
5.	Open ‘http://localhost/vms/index.php?r=password’
6.	Type ‘12345’ in current password
7.	Type ‘admin’ in new password
8.	Type ‘admin’ in repeat new password
9.	Click ‘update’ button
10.	Assert text ‘Password successfully updated’

     *      */
    function testScenario2() {
        $username = 'admin@test.com';
        $this->login($username,'12345');
        $this->updatePassword('17');
    }
    /*
Scenario 3– Login as superadmin and check for error messages if current password not equals to password in database.
Expected Behavior 
-	Update password
-	Assert ‘Current password does not match with password in database.’

Steps:
1.	Go to localhost/vms
2.	Type superadmin@test.com in username field
3.	Type admin in password field
4.	Click Login 
5.	Open ‘http://localhost/vms/index.php?r=password’
6.	Type ‘12345’ in current password
7.	Click ‘update’ button
8.	Assert text ‘Current password does not match with password in database’

          */
    function testScenario3() {
        
        $username = 'superadmin@test.com';
        $this->login($username,'admin');
        $this->open("/vms/index.php?r=password/update&id=16");
        $this->type("id=Password_currentpassword", "test");
        $this->type("name=Password[password]", "12345");
        $this->type("name=confirmPassword", "12345");
        $this->click("id=updateBtn");
        $this->waitForPageToLoad("30000");
        for ($second = 0; ; $second++) {
            if ($second >= 60) $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=div.flash-error")) break;
            } catch (Exception $e) {}
            sleep(1);
        }

        $this->assertEquals("Current password does not match password in your account.", $this->getText("css=div.flash-error"));
    }
    /*Scenario 4– Login as admin and check for error messages if repeat password not equal to new password
Expected Behavior 
-	Update password
-	Assert ‘New password does not match with current password.’

Steps:
9.	Go to localhost/vms
10.	Type admin@test.com in username field
11.	Type admin in password field
12.	Click Login 
13.	Open ‘http://localhost/vms/index.php?r=password’
14.	Type ‘12345’ in new password
15.	Type ‘1332345’ in repeat new password
16.	Click ‘update’ button
17.	Assert text ‘New password does not match with current password
*/
    function testScenario4() {
        //repeat
        $username = 'admin@test.com';
        $this->login($username,'admin');
        $this->open("/vms/index.php?r=password/update&id=17");
        $this->type("id=Password_currentpassword", "12345");
        $this->click("id=updateBtn");
        $this->waitForPageToLoad("30000");
        for ($second = 0; ; $second++) {
            if ($second >= 60) $this->fail("timeout");
            try {
                if ($this->isElementPresent("css=div.flash-error")) break;
            } catch (Exception $e) {}
            sleep(1);
        }

        $this->assertEquals("New password does not match with repeat new password.", $this->getText("css=div.flash-error"));
        $this->type("id=Password_currentpassword", "12345");
        $this->type("name=Password[password]", "123");
        $this->type("name=confirmPassword", "12");
        for ($second = 0; ; $second++) {
            if ($second >= 60) $this->fail("timeout");
            try {
                if ($this->isElementPresent("//form[@id='password-form']/table/tbody/tr[4]/td/div")) break;
            } catch (Exception $e) {}
            sleep(1);
        }

        $this->assertEquals("New Password does not match with Repeat New Password.", $this->getText("//form[@id='password-form']/table/tbody/tr[4]/td/div"));
    }
   /*Scenario 5– Login as superadmin and update another user id
Expected Behavior 
-	Update password
-	Assert ‘You are not authorized to access this page.’

Steps:
18.	Go to localhost/vms
19.	Type superadmin@test.com in username field
20.	Type admin in password field
21.	Click Login 
22.	Open ‘http://localhost/vms/index.php?r=password’
23.	Assert text ‘You are not authorized to access this page’
*/ 
    function testScenario5(){
        $username = 'superadmin@test.com';
        $this->login($username,'admin');
        $this->open("http://localhost/vms/index.php?r=password/update&id=17");
        for ($second = 0; ; $second++) {
            if ($second >= 60) $this->fail("timeout");
            try {
                if ($this->isElementPresent("id=content")) break;
            } catch (Exception $e) {}
            sleep(1);
        }

        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
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