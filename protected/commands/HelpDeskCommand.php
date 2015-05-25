<?php
/**
 * Created by PhpStorm.
 * User: streetcoder
 * Date: 5/24/15
 * Time: 12:04 AM
 */

class helpDeskCommand extends CConsoleCommand{

    public function actionIndex(){
        echo "\n\x20\x20Usage: helpdesk backup";
        echo "\n\x20\x20Description: The command 'helpdesk backup' will extract all the groups and";
        echo "\n\x20\x20content of HelpDesk and save them in JSON format in a the file: helpdesk.json.";
        echo "\n\x20\x20This will be located in the directory /protected/data\n";

        echo "\n\x20\x20Usage: helpdesk restore";
        echo "\n\x20\x20Description: The command 'helpdesk restore' will restore all the groups and";
        echo "\n\x20\x20content of HelpDesk from the file: helpdesk.json.";
        echo "\n\n";

    }

    public function actionBackup(){

        echo "\nThis action will override the previous update of HelpDesk's content";
        echo "\nDo you want to perform this action? yes|no: ";

        if (fscanf (STDIN, '%s', $input) == 1) {

            if($input=='yes'){
                echo 'Backing up...' . PHP_EOL;
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
                        $helpDeskArr["helpdesk"][] = array(
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

    public function actionRestore(){

        echo "\nCaution:This action will update the current backup of HelpDesk content from helpdesk.json. So, previous record can be lost from the database.";
        echo "\nAre you sure you want to perform this action? yes|no: ";

        if (fscanf (STDIN, '%s', $input) == 1) {

            if($input=='yes'){

                echo 'Restoring...' . PHP_EOL;

                $filename = Yii::app()->basePath.'/data/helpdesk.json';
                $fileContent = file_get_contents($filename, true);
                $helpDeskArr = json_decode($fileContent,1);

                if(!empty($helpDeskArr)){
                    HelpDesk::model()->deleteAll();
                    HelpDeskGroup::model()->deleteAll();

                    foreach($helpDeskArr as $tblName=>$data){

                        if($tblName==='helpdesk_group'){
                            foreach($data as $key=>$groups){
                                $groupModel = new HelpDeskGroup();
                                $groupModel->id         = $groups['id'];
                                $groupModel->name       = $groups['name'];
                                $groupModel->order_by   = $groups['order_by'];
                                $groupModel->created_by = $groups['created_by'];
                                $groupModel->is_deleted = $groups['is_deleted'];
                                $groupModel->save();

                            }
                        }

                        if($tblName==='helpdesk'){
                            foreach($data as $key=>$helpdesk){
                                $helpDeskModel                    = new HelpDesk();
                                $helpDeskModel->id                = $helpdesk['id'];
                                $helpDeskModel->question          = $helpdesk['question'];
                                $helpDeskModel->answer            = $helpdesk['answer'];
                                $helpDeskModel->helpdesk_group_id = $helpdesk['helpdesk_group_id'];
                                $helpDeskModel->order_by          = $helpdesk['order_by'];
                                $helpDeskModel->created_by        = $helpdesk['created_by'];
                                $helpDeskModel->is_deleted        = $helpdesk['is_deleted'];
                                $helpDeskModel->save();

                            }
                        }
                    }
                    echo 'HelpDesk content restored successfully!' . PHP_EOL;
                }
                else{
                    echo 'There is no data in helpdesk.json' . PHP_EOL;
                }

            }
            else{
                return 0;
            }

        }


    }

}