<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue 10
 *
 * @author Jeremiah
 */
class Issue10FunctionalTestSorting extends BaseFunctionalTest {

    protected function setUp() {
        parent::setUp();
        $this->setBrowser("*iexplore");
        $this->setBrowserUrl("http://cvms.identitysecurity.info");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 - Log in as super admin and check if sorting is working
      Expected Behavior:
      -   Assert last name is admin
      -   Assert last name is staffmember
     * Steps 
     * 1.    login as superadmin@test.com with 12345 as password
     * 2.    Click firstname header    
     * 3.   click lastname header
     * 4.   Assert Text admin in lastname column row 2
     * 5.   Click Lastname header 
     * 6.   Assert text staffmember in lastname column row 2
     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertTrue($this->isElementPresent("link=First Name"));
        $this->assertTrue($this->isElementPresent("link=Last Name"));
        $this->assertTrue($this->isElementPresent("link=Role"));
        $this->assertTrue($this->isElementPresent("link=User Type"));
        $this->assertTrue($this->isElementPresent("link=Contact No."));
        $this->click("link=First Name");
        $this->click("link=Last Name");
        sleep(1);
        $this->assertTrue($this->isElementPresent("css=a.sort-link.asc"));
        $this->assertEquals("admin2", $this->getText("//div[@id='user-grid']/table/tbody/tr[2]/td[2]"));
        $this->click("link=Last Name");
        sleep(1);
        $this->assertTrue($this->isElementPresent("css=a.sort-link.desc"));
        $this->assertEquals("staffmember", $this->getText("//div[@id='user-grid']/table/tbody/tr[2]/td[2]"));
    }

}

?>