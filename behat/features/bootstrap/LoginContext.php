<?php

use Behat\Behat\Context\Context,
    Behat\Behat\Context\SnippetAcceptingContext,
    \Behat\MinkExtension\Context\MinkContext;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
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
class LoginContext extends MinkContext implements Context
{
    private $environment;

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
     * @bBeforeScenario
     */
    public function GetEnvironment(BeforeScenarioScope $scope)
    {
        $this->environment = $scope->getEnvironment();

    }

    /*
     * @AfterFeature
     */
    function afterFeature($event)
    {
        $this->environment->getContext("TenantContext")->iDeleteCreatedTenants();
    }

    /*
     * @BeforeFeature
     */
    function beforeFeature($event)
    {
        $this->environment->getContext("TenantContext")->iCreateATenant();
    }


    function getCurrentTenant()
    {
        return $this->environment->getContext("TenantContext")->getCurrentTenant();
    }


    /**
     * @Given /^I am on the login page$/
     */
    public function iAmOnTheLoginPage()
    {
        $this->visit("/index.php");

    }

    /**
     * @Then /^I log in as an Issuing Body Administrator$/
     */
    public function iLogInAsAnIssuingBodyAdministrator()
    {
        $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("issuingbody@test.com", "12345", $this->getCurrentTenant()['name'], 'Test Airport Workstation');
    }

    /**
     * @Then /^I log in as an Airport Operator$/
     */
    public function iLogInAsAnAirportOperator()
    {
        $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("airportoperator@test.com", "12345", $this->getCurrentTenant()['name'], 'Test Airport Workstation');
    }

    /**
     * @Then /^I log in as an Agent Airport Administrator$/
     */
    public function iLogInAsAnAgentAirportAdministrator()
    {
        $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("agentairportadmin@test.com", "12345", $this->getCurrentTenant()['name'], 'Test Agent Airport Workstation');
    }

    /**
     * @Then /^I log in as an Agent Airport Operator$/
     */
    public function iLogInAsAnAgentAirportOperator()
    {
        $this->iLoginWithUsernameAndPasswordForTenantAtWorkstation("agentairportoperator@test.com", "12345", $this->getCurrentTenant()['name'], 'Test Agent Airport Workstation');
    }

    /**
     * @Then /^I log in as a Super Administrator$/
     */
    public function iLogInAsASuperAdministrator($username="superadmin@test.com", $password="12345")
    {

        $this->iAmOnTheLoginPage();
        $this->fillField("Username",$username);
        $this->fillField("Password",$password);
        $this->selectOption("LoginForm_tenant",$this->getCurrentTenant());
        $this->assertPageContainsText("Login");
        $this->pressButton("Login");
        $this->assertPageContainsText("Administration");

    }

    /**
     * @Then /^I login with username as "([^"]*)" and password as "([^"]*)" for tenant "([^"]*)" at workstation "([^"]*)" $/
     */
    public function iLoginWithUsernameAndPasswordForTenantAtWorkstation($username, $password, $tenant = null, $workstation = null)
    {
        $this->iAmOnTheLoginPage();
        $this->fillField("Username",$username);
        $this->fillField("Password",$password);
        $this->selectOption("LoginForm_tenant",$tenant);
        $this->assertPageContainsText("Login");
        $this->pressButton("Login");
        $this->assertPageContainsText("Continue");
        $this->selectOption("LoginForm_tenant",$tenant);
        $this->pressButton("Continue");
        $this->assertPageContainsText("Administration");

    }

    /**
     * @Then /^I logout$/
     */
    public function iLogout()
    {
        $this->visit("/index.php?r=site/logout");
    }


}
