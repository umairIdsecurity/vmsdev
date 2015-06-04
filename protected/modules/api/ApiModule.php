<?php

class ApiModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'api.models.*',
			'api.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			header("Access-Control-Allow-Origin: *");
		        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		        header("Access-Control-Allow-Headers: Authorization");
		        header('Content-type: application/json');
			return true;
		}
		else
			return false;
	}
}
