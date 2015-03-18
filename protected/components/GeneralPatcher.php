<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class GeneralPatcher extends CComponent {

	public static function startPatcher() {
		echo '  --==  Starting Patcher  ==--  ';
		// ISSUE 81 Patch ( Reprint card patcher ) 
		$status = Issue81Patch::Issue81Process();
		$info[0] = 'Issue 81 Patch Status';
		$info[1] = $status ? 'Successful' : 'Failed';
		$msg[] = $info;

		
                return $msg;
        }

}
