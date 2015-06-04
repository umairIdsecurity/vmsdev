<?php

class ApiModule extends CWebModule {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
        $this->setImport(array(
            'api.models.*',
            'api.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            $content_type = 'application/json';
            $status = 204;

            // set the status
            $status_header = 'HTTP/1.1 ' . $status . ' No Content';
            header($status_header);

            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE,OPTIONS");
            header("Access-Control-Allow-Headers: Authorization");
            header('Content-type: ' . $content_type);
            yii::app()->end();
        }
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }

}
