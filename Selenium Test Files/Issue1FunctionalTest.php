<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue 1
 *
 * @author Jeremiah
 */
class Issue1 extends BaseFunctionalTest {

    protected function setUp() {
        parent::setUp();
        $this->setBrowser("*firefoxproxy");
        $this->setBrowserUrl("http://dev.identitysecurity.info");
        
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
    
    
    
    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->assertTrue($this->isElementPresent("link=Logged in as " . $username . " - Super Administrator"));
    }

    function Scenario2() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->assertTrue($this->isElementPresent("link=Logged in as " . $username . " - Administrator"));
    }

    function Scenario3() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->assertTrue($this->isElementPresent("link=Logged in as " . $username . " - Agent Administrator"));
    }

    function Scenario4() {
        $username = 'agentoperator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->assertTrue($this->isElementPresent("link=Logged in as " . $username . " - Agent Operator"));
    }

    function Scenario5() {
        $username = 'operator@test.com';
        $this->login($username, '12345');
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submit");
        $this->assertTrue($this->isElementPresent("link=Logged in as " . $username . " - Operator"));
    }

    function Scenario6() {
        $username = 'staffmember@test.com';
        $this->login($username, '12345');

        $this->assertTrue($this->isElementPresent("link=Logged in as " . $username . " - Staff Member"));
    }

}

?>
