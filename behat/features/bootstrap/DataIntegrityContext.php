<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;
use Yii,
    DataIntegrityHelper;



//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class DataIntegrityContext implements Context, \Behat\Behat\Context\SnippetAcceptingContext
{

    /**
     * @Then /^I run a data integrity check$/
     */
    public function iRunADataIntegrityCheck(){
        $helper = new DataIntegrityHelper();
        $helper->checkDatabase();

    }

}
