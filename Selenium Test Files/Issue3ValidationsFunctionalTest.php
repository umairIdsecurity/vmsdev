<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'BaseFunctionalTest.php';

/**
 * Description of Issue3FunctionalTest
 *
 * @author Jeremiah
 */
class Issue3ValidationsFunctionalTest extends BaseFunctionalTest {

    function setUp() {
        $this->setBrowser("*iexplore");
        $this->setBrowserUrl("http://cvms.identitysecurity.info/");
    }

    function testAll() {
        $this->resetDbWithData();
        $this->Scenario1();
        $this->Scenario2();
        $this->Scenario3();
        $this->Scenario4();
        $this->Scenario5();
        $this->Scenario6();
        $this->Scenario7();
        $this->Scenario8();
        $this->Scenario9();
        $this->Scenario10();
        $this->Scenario11();
        $this->Scenario12();
    }

    /* Scenario 1 – Login as super admin and check data control. 
      Expected Behavior
      -	Asser text  ’administrator’, ’agent operator’, ’operator’, ’staff’ in search role field
      -	Assert link in sidebar menu ‘add user’, ‘add administrator’, ‘add agent administrator’, ‘add agent operator’, ‘add operator’, ‘add staff member’, ‘add visitor’

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Type ‘super administrator’ in search role field
      7.	Assert text ‘super administrator’
      8.	Type ‘administrator’ in search role field
      9.	Assert text ‘administrator’
      10.	Type ‘agent operator in search role field
      11.	Assert text ‘agent operator’
      12.	Type ‘operator’  in search role field
      13.	Assert text ‘operator
      14.	Type ‘staff member’  in search role field
      15.	Assert text ‘staff member’
      16.	Verify link present in sidebar ‘add user’, ‘add administrator’, ‘add agent administrator’, ‘add agent operator’, ‘add operator’, ‘add staff member’

     */

    function Scenario1() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Displaying 1-8 of 8 results.", $this->getText("css=div.summary"));
        $this->select("css=select[name=\"User[role]\"]", "label=Super Administrator");
        sleep(1);
        $this->assertEquals("Super Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Displaying 1-1 of 1 result." == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
        sleep(1);
        $this->select("css=select[name=\"User[role]\"]", "label=Administrator");
        sleep(1);
        $this->assertEquals("Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        for ($second = 0;; $second++) {
            if ($second >= 10)
                $this->fail("timeout");
            try {
                if ("Displaying 1-2 of 2 results." == $this->getText("css=div.summary"))
                    break;
            } catch (Exception $e) {
                
            }
            sleep(1);
        }
        $this->assertEquals("Displaying 1-2 of 2 results.", $this->getText("css=div.summary"));

        $this->select("css=select[name=\"User[role]\"]", "label=Agent Administrator");
        sleep(1);
        $this->assertEquals("Agent Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));

        $this->select("css=select[name=\"User[role]\"]", "label=Agent Operator");
        sleep(1);
        $this->assertEquals("Agent Operator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));

        $this->select("css=select[name=\"User[role]\"]", "label=Operator");
        sleep(1);
        $this->assertEquals("Operator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));

        $this->select("css=select[name=\"User[role]\"]", "label=Staff Member");
        sleep(1);
        $this->assertEquals("Staff Member", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-2 of 2 results.", $this->getText("css=div.summary"));

        $this->click("link=Manage Users");
        $this->assertTrue($this->isElementPresent("link=Add Administrator"));
        $this->click("link=Manage Users");
        $this->assertTrue($this->isElementPresent("link=Add Agent Administrator"));
        $this->click("link=Manage Users");
        $this->assertTrue($this->isElementPresent("link=Add Agent Operator"));
        $this->click("link=Manage Users");
        $this->assertTrue($this->isElementPresent("link=Add Operator"));
        $this->click("link=Manage Users");
        $this->assertTrue($this->isElementPresent("link=Add User"));
    }

    /* Scenario 2– Login as super admin and check access control
      Expected Behavior
      -	Open url for using another users id, should be able to update
      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Go to link ‘localhost/vms/index.php?r=user/update&id=170’
      6.	Assert Text ‘Update User’

     */

    function Scenario2() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=17");
        $this->assertEquals("Edit User", $this->getText("css=h1"));

        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=18");
        $this->assertEquals("Edit User", $this->getText("css=h1"));

        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=19");
        $this->assertEquals("Edit User", $this->getText("css=h1"));

        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=20");
        $this->assertEquals("Edit User", $this->getText("css=h1"));

        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=21");
        $this->assertEquals("Edit User", $this->getText("css=h1"));
    }

    /*
      Scenario 3– Login as admin and check data control
      Expected Behavior
      -	Assert text ‘administrator’, ‘agent administrator’, ‘operator’, ‘staff member’ in search role field except ‘super administrator’
      -	Assert link present ‘add agent administrator’, ‘add administrator’, ‘add operator’, ‘add staff member’

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Type ‘administrator’ in search role field
      7.	Assert text ‘administrator’
      8.	Type ‘agent operator in search role field
      9.	Assert text ‘agent operator’
      10.	Type ‘operator’  in search role field
      11.	Assert text ‘operator
      12.	Type ‘staff member’  in search role field
      13.	Assert text ‘staff member’
      14.	Verify link present in sidebar ‘add user’, ‘add administrator’, ‘add agent administrator’, ‘add agent operator’, ‘add operator’, ‘add staff member’

     */

    function Scenario3() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->select("css=select[name=\"User[role]\"]", "label=Administrator");
        sleep(1);
        $this->assertEquals("Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));

        $this->select("css=select[name=\"User[role]\"]", "label=Agent Administrator");
        sleep(1);
        $this->assertEquals("Agent Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));

        $this->select("css=select[name=\"User[role]\"]", "label=Agent Operator");
        sleep(1);
        $this->assertEquals("Agent Operator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));

        $this->select("css=select[name=\"User[role]\"]", "label=Operator");
        sleep(1);
        $this->assertEquals("Operator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));


        $this->click("link=Manage Users");
        $this->assertTrue($this->isElementPresent("link=Add Administrator"));
        $this->click("link=Manage Users");
        $this->assertTrue($this->isElementPresent("link=Add Agent Administrator"));
        $this->click("link=Manage Users");
        $this->assertTrue($this->isElementPresent("link=Add Operator"));
        $this->click("link=Manage Users");
        $this->assertTrue($this->isElementPresent("link=Add User"));
    }

    /* Scenario 4– Login as admin and check access control
      Expected Behavior
      -	Open url for using super users id, assert text ‘you are not authorized to access this page.’

      Steps:
      1.	Go to localhost/vms
      2.	Type admin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Go to link ‘localhost/vms/index.php?r=user/update&id=16’ , for superadmin
      6.	Assert Text ‘You are not authorized to access this page.’
      7.	Go to link ‘localhost/vms/index.php?r=user/update&id=22'’, for user with other tenant
      8.	Assert Text ‘You are not authorized to access this page.’
      7.	Go to link ‘localhost/vms/index.php?r=user/update&id=18'’, for agentadmin
      8.	Assert Text ‘update user’
      9.	Go to link ‘localhost/vms/index.php?r=user/update&id=19'’, for operator
      10.	Assert Text ‘update user’
     */

    function Scenario4() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=16");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));


        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=18");
        $this->assertEquals("Edit User", $this->getText("css=h1"));

        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=19");
        $this->assertEquals("Edit User", $this->getText("css=h1"));
    }

    /* Scenario 5 – Login as agent admin and check data control
      Expected Behavior
      -	Assert text ’agent operator’, ‘staff member’ in search role field except ‘super administrator’, ‘administrator’, ‘agent administrator’, ‘operator’
      -	Assert link  ‘add agent operator’ , ‘add staff member’

      Steps:
      1.	Go to localhost/vms
      2.	Type agentadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click ‘Administration’
      6.	Type ‘agent operator in search role field
      7.	Assert text ‘agent operator’
      8.	Type ‘staff member’  in search role field
      9.	Assert text ‘staff member’
      10.	Verify link present in sidebar ‘add user’,  ‘add agent operator’, ‘add staff member’
     */

    function Scenario5() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");

        $this->select("css=select[name=\"User[role]\"]", "label=Agent Administrator");
        sleep(1);
        $this->assertEquals("Agent Administrator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));

        $this->select("css=select[name=\"User[role]\"]", "label=Agent Operator");
        sleep(1);
        $this->assertEquals("Agent Operator", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));

        $this->select("css=select[name=\"User[role]\"]", "label=Staff Member");
        sleep(1);
        $this->assertEquals("Staff Member", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-2 of 2 results.", $this->getText("css=div.summary"));

        $this->click("link=Manage Users");
        $this->assertTrue($this->isElementPresent("link=Add Agent Operator"));
        $this->click("link=Manage Users");
        $this->assertTrue($this->isElementPresent("link=Add User"));
    }

    /* Scenario 6– Login as agent admin and check access control
      Expected Behavior
      -	Open url for using super users id, assert text ‘you are not authorized to access this page.’
      -	Open url for using admin users id, assert text ‘you are not authorized to access this page.’

      Steps:
      1.	Go to localhost/vms
      2.	Type agentadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Go to link ‘localhost/vms/index.php?r=user/update&id=16’ for superadmin
      6.	Assert Text ‘You are not authorized to access this page.’
      7.	Go to link ‘localhost/vms/index.php?r=user/update&id=17’ for admin
      8.	Assert Text ‘You are not authorized to access this page.’
      7.        Go to link ‘localhost/vms/index.php?r=user/update&id=24’ for user with another tenant agent
      8.	Assert Text ‘You are not authorized to access this page.’
      7.        Go to link ‘localhost/vms/index.php?r=user/update&id=24’ for user with another tenant agent
      8.	Assert Text ‘You are not authorized to access this page.’
      9.        Go to link ‘localhost/vms/index.php?r=user/update&id=20’ for agent operator
      10.	Assert Text ‘update user’
      10.        Go to link ‘localhost/vms/index.php?r=user/update&id=21’ for staff member
      11.	Assert Text ‘update user’
     */

    function Scenario6() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=16");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=17");
        $this->assertEquals("You are not authorized to perform this action.", $this->getText("css=div.error"));
        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=20");
        $this->assertEquals("Edit User", $this->getText("css=h1"));
        $this->open("http://cvms.identitysecurity.info/index.php?r=user/update&id=21");
        $this->assertEquals("Edit User", $this->getText("css=h1"));
    }

    /* Scenario 7– Login as super admin and check role field disabled if clicked in sidebar
      Expected Behavior
      -	Assert selected value ‘Administrator’ if clicked link ‘Add administrator’
      -	Assert selected value ‘Agent Administrator’ if clicked link ‘Add agent administrator’
      -	Assert selected value ‘Agent Operator‘ if clicked link ‘Add agent operator‘
      -	Assert selected value ‘Operator‘ if clicked link ‘Add operator‘
      -	Assert selected value ‘staff member‘ if clicked link ‘Add staff member‘


      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click administrator
      6.	Click ‘add administrator’
      7.	Verify selected role is ‘administrator’
      8.	Click ‘add agent administrator’
      9.	Verify selected role is ‘agent administrator’
      10.	Click ‘add agent operator
      11.	Verify selected role is ‘agent operator’
      12.	Click ‘add operator’
      13.	Verify selected role is ‘operator’
     */

    function Scenario7() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add Administrator");
        $this->waitForPageToLoad("30000");
        $this->getDisabledRoleValue("1");
        $this->click("link=Manage Users");
        $this->click("link=Add Agent Administrator");
        $this->waitForPageToLoad("30000");
        $this->getDisabledRoleValue("6");
        $this->click("link=Manage Users");
        $this->click("link=Add Agent Operator");
        $this->waitForPageToLoad("30000");
        $this->getDisabledRoleValue("7");
        $this->click("link=Manage Users");
        $this->click("link=Add Operator");
        $this->waitForPageToLoad("30000");
        $this->getDisabledRoleValue("8");
    }

    /* Scenario 8 – Login as super admin and create user admin, check for errors
      Expected Behavior
      -	Assert ‘Please fix the following input errors’ present for blank fields
      -	Assert ‘Email is not a valid email address’
      -	Assert ‘Email has already been taken’
      -	Assert ‘Repeat password does not match password’

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click administrator
      6.	Click ‘add administrator’
      7.	Click ‘Create’ button
      8.	Assert ‘Please fix the following input errors’
      9.	Type ‘testemail’ in email field
      10.	Click create button
      11.	Assert ‘email is not a valid email address’
      12.	Type superadmin@test.com in email field
      13.	Assert ‘email superadmin@test.com has already been taken’
      14.	Type ‘12345’ in password field
      15.	Type ‘1234’ in repeat password field
      16.	Assert text ‘Repeat password does not match with password’
     */

    function Scenario8() {
        $username = 'superadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add User");
        $this->waitForPageToLoad("30000");

        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12");
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[10]/td[2]/div"));
        $this->type("id=User_repeat_password", "12345");
        $this->assertFalse($this->isTextPresent("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[10]/td[2]/div"));

        $this->type("id=User_password", "");
        $this->type("id=User_repeat_password", "");

        $this->click("id=submitBtn");
        $this->clickAndWait("id=submitForm");
        $this->assertEquals("Please fix the following input errors:", $this->getText("css=div.errorSummary > p"));
        $this->assertEquals("Role cannot be blank.", $this->getText("css=div.errorMessage"));
        $this->assertEquals("Company Name cannot be blank.", $this->getText("css=#companyRow > div.errorMessage"));
        $this->assertEquals("First Name cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr/td[2]/div"));
        $this->assertEquals("Last Name cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[2]/td[2]/div"));
        $this->assertEquals("Email cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[3]/td[2]/div"));
        $this->assertEquals("Contact No. cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[4]/td[2]/div"));
        $this->assertEquals("Password cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[9]/td[2]/div"));
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "123456");
        $this->type("id=User_email", "testemail");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Email is not a valid email address.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[3]/td[2]/div"));
        $this->assertEquals("Password must be repeated exactly.", $this->getText("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[9]/td[2]/div"));

        $this->type("id=User_email", "superadmin@test.com");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
//        $this->assertEquals("Email \"superadmin@test.com\" has already been taken.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[3]/td[2]/div"));
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "Test");
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[10]/td[2]/div"));
    }

    /* Scenario 9 – Login as agent admin, go to set access rule and check data control
      Expected Behavior
      -	Assert ‘testagentoperator@test.com’
      -	Will see agent operators created by currently logged in agent admin

      Steps:
      1.	Go to localhost/vms
      2.	Type agentadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click administrator
      6.	Click ‘add agent operator’
      7.	Use ‘testagentoperator@test.com’ as email
      8.	Click create
      9.	Wait for manage user page and click set access rules
      10.	Type ‘testagentoperator@test,com’ in email search field
      11.	Assert ‘testagentoperator@test.com’
     */

    function Scenario9() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Set Access Rules");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
        $this->type("xpath=(//input[@name='User[email]'])[2]", "agentoperator@test.com");
        $this->click("css=select[name=\"User[user_type]\"]");
        $this->select("css=select[name=\"User[user_type]\"]", "label=Internal");
        sleep(1);
        $this->assertEquals("agentoperator@test.com", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /* Scenario 10 – Login as admin, go to set access rule and check data control
      Expected Behavior
      -	Assert ‘operator@test.com’
      -	Can see operator with the same company as the administrator logged in
      -	Can see agent operator made by agent admin made by administrator logged in

      Steps:
      1.	Go to localhost/vms
      2.	Type agentadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click administrator
      6.	Wait for manage users and click set access rules
      7.	Type ‘operator@test.com’ in email search field
      8.	Assert ‘operator@test.com’
      9.	Type ‘agentoperator@test.com’ in email search field
      10.	Assert ‘agentoperator@test.com’
     */

    function Scenario10() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Set Access Rules");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Displaying 1-2 of 2 results.", $this->getText("css=div.summary"));
        $this->type("xpath=(//input[@name='User[email]'])[2]", "operator@test.com");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test Operator");

        sleep(1);
        $this->assertEquals("operator@test.com", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));

        $this->type("xpath=(//input[@name='User[email]'])[2]", "agentoperator@test.com");
        $this->type("css=td > input[name=\"User[first_name]\"]", "Test AgentOperator");
        sleep(1);
        $this->assertEquals("agentoperator@test.com", $this->getText("//div[@id='user-grid']/table/tbody/tr/td[3]"));
        $this->assertEquals("Displaying 1-1 of 1 result.", $this->getText("css=div.summary"));
    }

    /* Scenario 11 – Login as admin and create user admin, check for errors
      Expected Behavior
      -	Assert ‘Please fix the following input errors’ present for blank fields
      -	Assert ‘Email is not a valid email address’
      -	Assert ‘Email has already been taken’
      -	Assert ‘Repeat password does not match password’

      Steps:
      1.	Go to localhost/vms
      2.	Type superadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click administrator
      6.	Click ‘add administrator’
      7.	Click ‘Create’ button
      8.	Assert ‘Please fix the following input errors’
      9.	Type ‘testemail’ in email field
      10.	Click create button
      11.	Assert ‘email is not a valid email address’
      12.	Type superadmin@test.com in email field
      13.	Assert ‘email superadmin@test.com has already been taken’
      14.	Type ‘12345’ in password field
      15.	Type ‘1234’ in repeat password field
      16.	Assert text ‘Repeat password does not match with password’
     */

    function Scenario11() {
        $username = 'admin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add User");
        $this->waitForPageToLoad("30000");

        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12");
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[10]/td[2]/div"));
        $this->type("id=User_repeat_password", "12345");
        $this->assertFalse($this->isTextPresent("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[10]/td[2]/div"));

        $this->type("id=User_password", "");
        $this->type("id=User_repeat_password", "");

        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Please fix the following input errors:", $this->getText("css=div.errorSummary > p"));
        $this->assertEquals("Role cannot be blank.", $this->getText("css=div.errorMessage"));
        $this->assertEquals("First Name cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr/td[2]/div"));
        $this->assertEquals("Last Name cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[2]/td[2]/div"));
        $this->assertEquals("Email cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[3]/td[2]/div"));
        $this->assertEquals("Contact No. cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[4]/td[2]/div"));
        $this->assertEquals("Password cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[9]/td[2]/div"));
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "123456");
        $this->type("id=User_email", "testemail");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Email is not a valid email address.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[3]/td[2]/div"));
        $this->assertEquals("Password must be repeated exactly.", $this->getText("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[9]/td[2]/div"));

        $this->type("id=User_email", "superadmin@test.com");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
//        $this->assertEquals("Email \"superadmin@test.com\" has already been taken.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[3]/td[2]/div"));
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "Test");
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[10]/td[2]/div"));
    }

    /* Scenario 12 – Login as agentadmin and create user agent operator, check for errors
      Expected Behavior
      -	Assert ‘Please fix the following input errors’ present for blank fields
      -	Assert ‘Email is not a valid email address’
      -	Assert ‘Email has already been taken’
      -	Assert ‘Repeat password does not match password’

      Steps:
      1.	Go to localhost/vms
      2.	Type agentadmin@test.com in username field
      3.	Type 12345 in password field
      4.	Click Login
      5.	Click administrator
      6.	Click ‘add administrator’
      7.	Click ‘Create’ button
      8.	Assert ‘Please fix the following input errors’
      9.	Type ‘testemail’ in email field
      10.	Click create button
      11.	Assert ‘email is not a valid email address’
      12.	Type superadmin@test.com in email field
      13.	Assert ‘email superadmin@test.com has already been taken’
      14.	Type ‘12345’ in password field
      15.	Type ‘1234’ in repeat password field
      16.	Assert text ‘Repeat password does not match with password’
     */

    function Scenario12() {
        $username = 'agentadmin@test.com';
        $this->login($username, '12345');
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->click("link=Manage Users");
        $this->click("link=Add User");
        $this->waitForPageToLoad("30000");

        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12");
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[10]/td[2]/div"));
        $this->type("id=User_repeat_password", "12345");
        $this->assertFalse($this->isTextPresent("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[10]/td[2]/div"));

        $this->type("id=User_password", "");
        $this->type("id=User_repeat_password", "");

        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Please fix the following input errors:", $this->getText("css=div.errorSummary > p"));
        $this->assertEquals("Role cannot be blank.", $this->getText("css=div.errorMessage"));
        $this->assertEquals("Contact No. cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[4]/td[2]/div"));
        $this->assertEquals("First Name cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr/td[2]/div"));
        $this->assertEquals("Last Name cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[2]/td[2]/div"));
        $this->assertEquals("Email cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[3]/td[2]/div"));
        $this->assertEquals("Contact No. cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[4]/td[2]/div"));
        $this->assertEquals("Password cannot be blank.", $this->getText("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[9]/td[2]/div"));
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "123456");
        $this->type("id=User_email", "testemail");
        $this->click("id=submitBtn");
        $this->click("id=submitForm");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Email is not a valid email address.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[3]/td[2]/div"));
        $this->assertEquals("Password must be repeated exactly.", $this->getText("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[9]/td[2]/div"));

        $this->type("id=User_email", "superadmin@test.com");
        $this->type("id=User_password", "12345");
        $this->type("id=User_repeat_password", "12345");
        $this->click("id=submitBtn");
        $this->clickAndWait("id=submitForm");
     //   $this->assertEquals("Email \"superadmin@test.com\" has already been taken.", $this->getText("//form[@id='user-form']/table/tbody/tr/td[2]/table/tbody/tr[3]/td[2]/div"));
        $this->type("id=User_password", "test");
        $this->type("id=User_repeat_password", "Test");
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr/td/table/tbody/tr[10]/td[2]/div"));
    }

}

?>
