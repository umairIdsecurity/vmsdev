<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$tenant = trim($_REQUEST['tenant']);
	
        $aArray = array();
        
        $connection = Yii::app()->db;
                $sql ="select id,concat(first_name,' ',last_name) as name from `user` where tenant='93' and role=6";
                $command = $connection->createCommand($sql);
                $row = $command->queryAll();
                foreach ($row as $key=>$value){
                    
                    $aArray[] = array (
                            'id'=>$value['id'],
                            'name'=>$value['name'],
                        );
                }
                
         $resultMessage['data'] = $aArray;
        
        
        echo json_encode($resultMessage);