<?php


use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Yii;
use TenantManager;

/**
 * Created by PhpStorm.
 * User: gistewart
 * Date: 4/03/2016
 * Time: 10:57 PM
 */
class LoginContext implements Context, SnippetAcceptingContext
{

    private $environment;

    /**
     * @BeforeScenario
     */
    public function getEnvironment(BeforeScenarioScope $scope)
    {
        $this->environment = $scope->getEnvironment();
    }

    /*
     * @BeforeFeature
     */
    function beforeFeature($event)
    {
        $this->getTenantContext()->iCreateATenant();
    }


    function getCurrentTenant()
    {
        return $this->getTenantContext()->getCurrentTenant();
    }


    function getTenantContext()
    {
        return $this->environment->getContext("TenantContext");
    }


    function getFeatureContext(){
        return $this->environment->getContext("FeatureContext");
    }


    /*
     * @AfterFeature
     */
    function afterFeature($event)
    {
        $this->getTenantContext()->iDeleteCreatedTenants();
    }

    /**
     * @Then /^I log in as an Issuing Body Administrator$/
     */
    public function iLogInAsAnIssuingBodyAdministrator()
    {
        $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("issuingbody@test.com", "12345", $this->getCurrentTenant()['id'], 'Test Airport Workstation');
    }

    /**
     * @Then /^I log in as an Airport Operator$/
     */
    public function iLogInAsAnAirportOperator()
    {
        $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("airportoperator@test.com", "12345", $this->getCurrentTenant()['id'], 'Test Airport Workstation');
    }

    /**
     * @Then /^I log in as an Agent Airport Administrator$/
     */
    public function iLogInAsAnAgentAirportAdministrator()
    {
        $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("agentairportadmin@test.com", "12345", $this->getCurrentTenant()['id'], 'Test Agent Airport Workstation');
    }

    /**
     * @Then /^I log in as an Agent Airport Operator$/
     */
    public function iLogInAsAnAgentAirportOperator()
    {
        $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("agentairportoperator@test.com", "12345", $this->getCurrentTenant()['id'], 'Test Agent Airport Workstation');
    }


    /**
     * @Given /^I am on the login page$/
     */
    public function iAmOnTheLoginPage()
    {
        $mink = $this->getFeatureContext();
        $mink->visit("/index.php");
    }



    /**
     * @Then /^I log in as a Super Administrator$/
     */
    public function iLogInAsASuperAdministrator($username="superadmin@test.com", $password="12345")
    {
        $mink = $this->getFeatureContext();
        $this->iAmOnTheLoginPage();
        $mink->fillField("Username or Email",$username);
        $mink->fillField("Password",$password);
        $mink->fillFIeld("LoginForm_tenant",$this->getCurrentTenant()['id']);
        $mink->iWaitForTextToAppear("Login");
        $mink->pressButton("Login");
        //$mink->assertPageContainsText("Administration");

    }

    /**
     * @Then /^I login with username as "([^"]*)" and password as "([^"]*)" for tenant "([^"]*)" at workstation "([^"]*)" $/
     */
    public function iLoginWithUsernameAndPasswordForTenantAtWorkstation($username, $password, $tenant = null, $workstation = null)
    {
        $mink = $this->getFeatureContext();

        $this->iAmOnTheLoginPage();
        $mink->fillField("Username or Email",$username);
        $mink->fillField("Password",$password);
        $mink->fillField("LoginForm_tenant",$tenant);
        $mink->assertPageContainsText("Login");
        $mink->pressButton("Login");
        $mink->iWaitForTextToAppear("Continue");
        $mink->pressButton("Continue");
        //$mink->assertPageContainsText("Administration");

    }

    /**
     * @Then /^I logout$/
     */
    public function iLogout()
    {
        $mink = $this->getFeatureContext();
        $mink->visit("/index.php?r=site/logout");
    }


}