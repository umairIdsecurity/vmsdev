<?php


use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;
use Yii;




//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class LoginContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {

    }


    /*
     * @AfterFeature
     */
    function afterFeature($event){
        $this->getMainContext()->getSubcontext("tenant")->iDeleteCreatedTenants();
    }

    /*
     * @BeforeFeature
     */
    function beforeFeature($event){
        $this->getMainContext()->getSubcontext("tenant")->iCreateATenant();
    }


    function getCurrentTenant(){
        return  $this->getMainContext()->getSubcontext("tenant")->getCurrentTenant();
    }


    /**
    * @Given /^I am on the login page$/
    */
    public function iAmOnTheLoginPage()
    {
        return [new Step\Given('I am on "/index.php"')];

    }

    /**
     * @Then /^I log in as an Issuing Body Administrator$/
     */
    public function iLogInAsAnIssuingBodyAdministrator(){
        return $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("issuingbody@test.com","12345",$this->getCurrentTenant()['name'],'Test Airport Workstation');
    }

    /**
     * @Then /^I log in as an Airport Operator$/
     */
    public function iLogInAsAnAirportOperator(){
        return $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("airportoperator@test.com","12345",$this->getCurrentTenant()['name'],'Test Airport Workstation');
    }

    /**
     * @Then /^I log in as an Agent Airport Administrator$/
     */
    public function iLogInAsAnAgentAirportAdministrator(){
        return $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("agentairportadmin@test.com","12345",$this->getCurrentTenant()['name'],'Test Agent Airport Workstation');
    }
    /**
     * @Then /^I log in as an Agent Airport Operator$/
     */
    public function iLogInAsAnAgentAirportOperator(){
        return $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("agentairportoperator@test.com","12345",$this->getCurrentTenant()['name'],'Test Agent Airport Workstation');
    }

    /**
     * @Then /^I log in as a Super Administrator$/
     */
    public function iLogInAsASuperAdministrator()
    {
        //$this->getMainContext()->getSession()->reset();

        return array(
            new Step\Given('I reset this session'),
            new Step\Given('I am on "/index.php"'),
            new Step\Then('I fill in "Username or Email" with "superadmin@test.com"'),
            new Step\Then('I fill in "Password" with "12345"'),
            new Step\Then('I select "'.$this->getCurrentTenant()['name'].'" from "LoginForm_tenant"'),
            new Step\Then('I should see "Login"'),
            new Step\Then('I press "Login"'),
            new Step\Then('I should see "Administration" appear'),
        );

    }

    /**
     * @Then /^I login with username as "([^"]*)" and password as "([^"]*)" for tenant "([^"]*)" at workstation "([^"]*)" $/
     */
    public function iLoginWithUsernameAndPasswordForTenantAtWorkstation($username, $password,$tenant=null,$workstation=null)
    {
        //$this->getMainContext()->getSession()->reset();

        return array(
            new Step\Given('I reset this session'),
            new Step\Given('I am on "/index.php"'),
            new Step\Then('I fill in "Username or Email" with "'.$username.'"'),
            new Step\Then('I fill in "Password" with "'.$password.'"'),
            new Step\Then('I select "'.$tenant.'" from "LoginForm_tenant"'),
            new Step\Then('I press "Login"'),
            new Step\Then('I should see "Continue" appear'),
            new Step\Then('I select "'.$workstation.'" from "userWorkstation"'),
            new Step\Then('I press "Continue"'),
            new Step\Then('I should see "Dashboard" appear')

        );

    }

    /**
     * @Then /^I logout$/
     */
    public function iLogout(){
        return array(
            new Step\Given('I am on "/index.php?r=site/logout"'),
        );
    }




}
