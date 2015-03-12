<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue124FunctionalTest
 *
 * @author Jeremiah
 */
class Issue124FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://dev.identitysecurity.info");
    }

    function testAll() {
       // $this->resetDbWithData();
        $this->Scenario1();
    }

    /* Scenario 1 – 
     *  delete staff member assert 'cannot be deleted. this user is currently assigned to a visit'
     *  delete admin2 - assert admin2 not in table
     *  delete agent operator - assert 'A workstation is linked to this profile. Please unlink workstation first before deleting this user.'
     *  delete operator - assert A workstation is linked to this profile. Please unlink workstation first before deleting this user.
     *  delete admin - This profile cannot be deleted. Profile is tenant of a company
     *  delete agentadmin - This record cannot be deleted. This tenant is currently the tenant agent of a company.
     *  Assert deleted user can't log in
     *  Use superadmin, admin, and agentadmin 
     * */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->click("id=yt0");
        sleep(1);
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("This profile cannot be deleted. This profile is currently assigned to a visit.", $this->getAlert());
        $this->click("id=yt1");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->clickAndWait("link=Administration");
        $this->type("name=User[last_name]", "admin2");
        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->clickAndWait("link=Administration");
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("This profile cannot be deleted. This profile is currently assigned to a visit.", $this->getAlert());
        $this->click("id=yt2");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("A workstation is linked to this profile. Please unlink workstation first before deleting this user.", $this->getAlert());
        $this->click("id=yt3");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("A workstation is linked to this profile. Please unlink workstation first before deleting this user.", $this->getAlert());
        $this->click("id=yt5");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("This profile cannot be deleted. Profile is tenant of a company", $this->getAlert());
        $this->clickAndWait("link=Administration");
        $this->type("name=User[first_name]", "IDS");
        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=td.empty"));
        $this->clickAndWait("//ul[@id='tabs']/li[3]/a/p");
        $username = 'admin2@test.com';
        $this->login($username, '12345');
        $this->assertEquals("Incorrect username or password.", $this->getText("id=LoginForm_password_em_"));
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->select("name=User[role]", "label=Administrator");
        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("This profile cannot be deleted. This profile is currently assigned to a visit.", $this->getAlert());
        $this->click("id=yt1");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("This profile cannot be deleted. This profile is currently assigned to a visit.", $this->getAlert());
        $this->click("id=yt2");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("A workstation is linked to this profile. Please unlink workstation first before deleting this user.", $this->getAlert());
        $this->click("id=yt3");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("A workstation is linked to this profile. Please unlink workstation first before deleting this user.", $this->getAlert());
        $this->click("css=a.has-sub-sub > span");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_role", "label=Staff Member");
        $this->type("id=User_first_name", "delete");
        $this->type("id=User_last_name", "delete");
        $this->type("id=User_email", "delete@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("delete", $this->getText("css=tr.odd > td"));
        $this->assertEquals("delete", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->type("name=User[first_name]", "delete");
        $this->clickAndWait("link=Administration");
        $this->type("name=User[first_name]", "delete");
        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("//ul[@id='tabs']/li[3]/a/p");
        $this->waitForPageToLoad("30000");
        $username = 'delete@test.com';
        $this->login($username, '12345');
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("Incorrect username or password." == $this->getText("id=LoginForm_password_em_"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("Incorrect username or password.", $this->getText("id=LoginForm_password_em_"));
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->select("name=User[role]", "label=Agent Administrator");
        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("This profile cannot be deleted. This profile is currently assigned to a visit.", $this->getAlert());
        $this->click("id=yt1");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("This profile cannot be deleted. This profile is currently assigned to a visit.", $this->getAlert());
        $this->click("id=yt2");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        sleep(1);
        $this->assertEquals("A workstation is linked to this profile. Please unlink workstation first before deleting this user.", $this->getAlert());
        $this->click("css=a.has-sub-sub > span");
        $this->waitForPageToLoad("30000");
        $this->select("id=User_role", "label=Staff Member");
        $this->type("id=User_first_name", "delete");
        $this->type("id=User_last_name", "delete");
        $this->type("id=User_email", "delete@test.com");
        $this->type("id=User_contact_number", "12345");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("delete", $this->getText("css=tr.odd > td"));
        $this->assertEquals("delete", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[2]"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->type("name=User[first_name]", "delete");
        for ($second = 0;; $second++) {
            if ($second >= 60)
                $this->fail("timeout");
            try {
                if ("delete" == $this->getText("css=tr.odd > td"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }

        $this->assertEquals("delete", $this->getText("css=tr.odd > td"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("id=yt0");
        $this->assertTrue((bool) preg_match('/^Are you sure you want to delete this item[\s\S]$/', $this->getConfirmation()));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->type("name=User[first_name]", "delete");
        sleep(1);
        $this->assertEquals("No results found.", $this->getText("css=span.empty"));
    }

}

?>
