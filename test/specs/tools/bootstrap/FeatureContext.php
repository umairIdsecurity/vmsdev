<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Context\Step,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;


/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {

    }


    /**
     * @Then /^I login with username as "([^"]*)" and password as "([^"]*)"$/
     */
    public function iLoginWithUsernameAndPassword($username, $password)
    {
        $this->getSession()->reset();
        echo "here";
        return array(
            new Step\Given('I am on "/index.php"'),
            new Step\Then('show me a screenshot'),
            new Step\When('I fill in "Username or Email" with "'.$username.'"'),
            new Step\When('I fill in "Password" with "'.$password.'"'),
            new Step\When('I press "Login"'),
            new Step\Then('I should see "Dashboard" appear'),
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
