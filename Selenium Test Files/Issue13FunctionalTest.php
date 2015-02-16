<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue13FunctionalTest
 *
 * @author Jeremiah
 */
class Issue13FunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*iexploreproxy");
        $this->setBrowserUrl("http://cvms.identitysecurity.info");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
    }

    /* Scenario 1 – Login as super admin and check date of birth values
      Expected Behavior
      -	Assert text 29 birthday day is not present if not leap year else it is present
      - Assert text 31 birthday day if month is october
      - Assert text 31 birthday day not present if month is november

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add User'’
      7.	Select 2014 in year
      8.	Select Feb in month
      9.	Assert 29 is not included in birthday day option
      10.	Select 2012 in year
      11.	Assert 29 is included in birthday day option
      12.	Select month oct and year 2014
      13.	Assert 31 is included in birthday day option
      14.	Select month nov. and assert 31 is not included in birthday day option

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("link=Add User");
        $this->select("id=fromMonth", "label=Feb");
        $this->assertEquals("12345678910111213141516171819202122232425262728", $this->getText("id=fromDay"));
        $this->select("id=fromYear", "label=2012");
        $this->assertEquals("1234567891011121314151617181920212223242526272829", $this->getText("id=fromDay"));
        $this->select("id=fromYear", "label=2014");
        $this->select("id=fromMonth", "label=Oct");
        $this->assertEquals("12345678910111213141516171819202122232425262728293031", $this->getText("id=fromDay"));
        $this->select("id=fromMonth", "label=Nov");
        $this->assertEquals("123456789101112131415161718192021222324252627282930", $this->getText("id=fromDay"));
    
    }

    /* Scenario 2 – Login as super admin, add administrator and check if birthday is correct
      Expected Behavior
      -	Asser text 1993 in year jul in month and 30 in day

      Steps:
      1.	Go to localhost/vms
      2.	Type agentadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Click ‘Add User’
      7.	Fill up fields, user testbirthday in first name and test in last name,use testbirthday@test.com for email and 12345 for password
      8.	Select administrator in role field
      9.	Select jul in month 31 in day and 1993 in year
      10.	Click save
      11.	Wait for page to redirect in manage users
      12.	Type testbirthday in firstname
      13.	click edit and wait for page to load
      14.	Assert year is 1993 month is jul day is 31

     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->clickAndWait("link=Administration");
        $this->clickAndWait("link=Add User");
        $this->type("id=User_first_name", "testbirthday");
        $this->type("id=User_last_name", "test");
        $this->type("id=User_email", "testbirthday@test.com");
        $this->type("id=User_contact_number", "123456");
        $this->select("id=User_role", "label=Administrator");
        $this->select("id=fromMonth", "label=Jul");
        sleep(1);
        $this->select("id=fromDay", "label=26");
        $this->select("id=fromYear", "label=1993");
        $this->type("id=User_password", "123");
        $this->type("id=User_repeat_password", "123");
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submitForm");
        $this->type("name=User[first_name]", "testbirthday");
        $this->type("name=User[last_name]", "test");
        sleep(1);
        $this->clickAndWait("link=Edit");
        $this->assertEquals("1993", $this->getEval("window.document.getElementById(\"fromYear\").value"));
        $this->assertEquals("26", $this->getEval("window.document.getElementById(\"fromDay\").value"));
        $this->assertEquals("7", $this->getEval("window.document.getElementById(\"fromMonth\").value"));
    }

}

?>
