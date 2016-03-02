<?php
namespace SubContext;


use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,
    Behat\Behat\Context\Step;
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
class YiiContext extends BehatContext
{
    const PATH_TO_YII = "yii/framework/yii.php";
    static $APP = null;

    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct()
    {
    }

    /**
     * @BeforeSuite
     */
    public static function prepare($event)
    {
        // prepare system for test suite
        // before it runs
        if(YiiContext::$APP==null) {
            defined('YII_DEBUG') or define('YII_DEBUG', true);
            require_once(YiiContext::PATH_TO_YII);
            Yii::createConsoleApplication("protected/config/console.php");
            YiiContext::$APP = Yii::app();
        }
    }



    private function runYiiConsoleCommand($command,$args=[] ){

        try {
            $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
            $runner = new CConsoleCommandRunner();
            $runner->addCommands($commandPath);
            $commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
            $runner->addCommands($commandPath);
            $args = array_merge(['yiic'], [$command], $args);
            ob_start();
            $runner->run($args);
            echo htmlentities(ob_get_clean(), null, Yii::app()->charset);
        } catch(CException $e){
            echo $e->getMessage();
        }

    }


}
