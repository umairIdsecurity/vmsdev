<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 5/24/15
 * Time: 12:04 AM
 */

class helpDeskCommand extends CConsoleCommand{

    public function actionIndex(){

        echo "\n\x20\x20Usage: helpdesk extract";
        echo "\n\x20\x20Description: The command 'helpdesk extract' will extract all the groups \n";
        echo "\n\x20\x20 and content of HelpDesk and save them in JSON format in a \n";
        echo "\n\x20\x20 the file: helpdesk.json. This will be located in the directory\n";
        echo "\n\x20\x20 /protected/data\n\n";

    }

    public function actionExtract(){

        echo "\nThis action will override the previous update of HelpDesk's content";
        echo "\nDo you want to perform this action? yes|no: ";

        if (fscanf (STDIN, '%s', $input) == 1) {

            if($input=='yes'){
                echo 'Extracting...' . PHP_EOL;
                $helpDeskArr = array();

                $groups = HelpDeskGroup::model()->findAll();

                if(!empty($groups)){
                    foreach($groups as $key=>$value){
                        $helpDeskArr["helpdesk_group"][] = array(
                            "id"         => $value->id,
                            "name"       => $value->name,
                            "order_by"   => $value->order_by,
                            "created_by" => $value->created_by,
                            "is_deleted" => $value->is_deleted,
                        );
                    }
                }

                $helpDesk = HelpDesk::model()->findAll();

                if(!empty($helpDesk)){
                    foreach($helpDesk as $key=>$value){
                        $helpDeskArr["helpDesk"][] = array(
                            "id"                => $value->id,
                            "question"          => $value->question,
                            "answer"            => $value->answer,
                            "helpdesk_group_id" => $value->helpdesk_group_id,
                            "order_by"          => $value->order_by,
                            "created_by"        => $value->created_by,
                            "is_deleted"        => $value->is_deleted
                        );
                    }
                }

                $jsonGroupArr = json_encode($helpDeskArr , JSON_PRETTY_PRINT);

                $filename = Yii::app()->basePath.'/data/helpdesk.json';
                $file = fopen($filename, 'w');
                fwrite($file, $jsonGroupArr);
                fclose($file);

                echo 'helpdesk.json is created successfully!' . PHP_EOL;
            }
            else{
                return 0;
            }

        }

    }

}