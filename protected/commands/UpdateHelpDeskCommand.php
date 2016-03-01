<?php
require_once(Yii::app()->basePath . '/data/HelpDeskContents.php');

class UpdateHelpDeskCommand extends CConsoleCommand {

    public function run($args) {
        $this->updateHelpDesk();
    }

    public function extractHelpDesk(){

        ini_set("display_errors", 1);
        set_time_limit(0);

        $helpDesk = new HelpDeskContents();
        $db = Yii::app()->db;

    }

    public function pushToGit()
    {

    }

    public function pullFromGit(){

    }

    public function updateHelpDesk() {
     
	   ini_set("display_errors", 1);
       set_time_limit(0);
	   
	   $helpDesk = new HelpDeskContents();
	   $db = Yii::app()->db;
	   $dbCommand = $db->createCommand("DELETE FROM helpdesk_group");
       $dbCommand->query();
	   $dbCommand = $db->createCommand("DELETE FROM helpdesk");
       $dbCommand->query();
	   
	   $helpdesk_group=$helpDesk->helpdesk_group;
	   $helpdesk=$helpDesk->helpdesk;
	   
	  
	   for($ivar=1;$ivar<= count($helpdesk_group);$ivar++)
	   {
		   $dbCommand = $db->createCommand("INSERT INTO helpdesk_group (id,name,order_by,created_by,is_deleted) values ($ivar,'".addslashes($helpdesk_group[$ivar])."',$ivar,16,0) ");
           $dbCommand->query();
		  
	   }

	   for($ivar=1;$ivar<= count($helpdesk);$ivar++)
	   {
		  
		  $dbCommand = $db->createCommand("INSERT INTO helpdesk(id,question,answer,helpdesk_group_id,order_by,created_by,is_deleted) values ($ivar,'".addslashes($helpdesk[$ivar][1])."','".addslashes($helpdesk[$ivar][2])."','".addslashes($helpdesk[$ivar][0])."',$ivar,16,0) ");
          $dbCommand->query();
		  
	   }
	 
    }

 

}

?>
