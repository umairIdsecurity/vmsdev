<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue126FunctionalTest
 *
 * @author Jeremiah
 */
class Issue126FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 – 
     *  input email@test.com with spaces at the beginning and end. Assert email is not a valid email address not present.
     *  Assert user is saved
     * */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("css=a.has-sub-sub");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_role", "label=Staff Member");
        $this->type("id=User_first_name", "testemail");
        $this->type("id=User_last_name", "testemail");
        $this->type("id=User_email", " testemail@test.com ");
        $this->type("id=User_contact_number", "12345");
        $this->select("id=User_tenant", "label=NAIA Airport");
        $this->type("id=User_password", "123");
        $this->type("id=User_repeat_password", "123");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("testemail", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->assertEquals("testemail", $this->getText("css=tr.odd > td"));
        $this->click("link=Edit");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("", $this->getText("id=User_email"));
        try {
            $this->assertEquals("testemail@test.com", $this->getValue("id=User_email"));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            array_push($this->verificationErrors, $e->toString());
        }
    }

}

?>
