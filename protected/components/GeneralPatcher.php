<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GeneralPatcher extends CComponent {

	public static function startPatcher()
    {
        echo '  --==  Starting Patcher  ==--  ';
       /* // ISSUE 81 Patch ( Reprint card patcher )
        $status = IssuePatch::Issue81Process();
        $info[0] = 'Issue 81 Patch Status';
        $info[1] = $status ? 'Successful' : 'Failed';
        $msg[] = $info;

        // ISSUE 137 Patch ( Card Number )
        $status = IssuePatch::Issue137Process();
        $info[0] = 'Issue 137 Patch Status';
        $info[1] = $status ? 'Successful' : 'Failed';
        $msg[] = $info;*/


        $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
        $runner = new CConsoleCommandRunner();
        $runner->addCommands($commandPath);
        $commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
        $runner->addCommands($commandPath);
        $args = array('yiic', 'migrate', '--interactive=0');
        ob_start();
        $runner->run($args);

    }

}
