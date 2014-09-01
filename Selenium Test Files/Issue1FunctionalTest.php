<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
//require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue 1
 *
 * @author Jeremiah
 */
class Issue1 extends PHPUnit_Extensions_SeleniumTestCase {

    
    protected function setUp() {
        parent::setUp();
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://localhost/vms");
    }
    
    
    function testScenario1() {
        $username = 'superadmin@test.com';
        $this->login($username,'12345');
        $this->assertTrue($this->isElementPresent("link=Logged in as ".$username." - Super Administrator"));
        $this->click("link=Logout");
        $this->waitForPageToLoad("30000");
    }
    
    function testScenario2() {
        $username = 'admin@test.com';
        $this->login($username,'12345');
        $this->assertTrue($this->isElementPresent("link=Logged in as ".$username." - Administrator"));
        $this->click("link=Logout");
        $this->waitForPageToLoad("30000");
    }
    
    function testScenario3() {
        $username = 'agentadmin@test.com';
        $this->login($username,'12345');
        $this->assertTrue($this->isElementPresent("link=Logged in as ".$username." - Agent Administrator"));
        $this->click("link=Logout");
        $this->waitForPageToLoad("30000");
    }
    
    function testScenario4() {
        $username = 'agentworkstation@test.com';
        $this->login($username,'12345');
        $this->assertTrue($this->isElementPresent("link=Logged in as ".$username." - Agent Workstation"));
        $this->click("link=Logout");
        $this->waitForPageToLoad("30000");
    }
    
    function testScenario5() {
        $username = 'workstation@test.com';
        $this->login($username,'12345');
        $this->assertTrue($this->isElementPresent("link=Logged in as ".$username." - Workstation"));
        $this->click("link=Logout");
        $this->waitForPageToLoad("30000");
    }
    
    function testScenario6() {
        $username = 'staffmember@test.com';
        $this->login($username,'12345');
        $this->assertTrue($this->isElementPresent("link=Logged in as ".$username." - Staff Member"));
        $this->click("link=Logout");
        $this->waitForPageToLoad("30000");
    }
    
    function testScenario7() {
        $username = 'visitor@test.com';
        $this->login($username,'12345');
        $this->assertTrue($this->isElementPresent("link=Logged in as ".$username." - Visitor"));
        $this->click("link=Logout");
        $this->waitForPageToLoad("30000");
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