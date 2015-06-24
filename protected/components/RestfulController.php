<?php

/**
 * Controller is the customized base controller class.
 * API module's controller classes for this application should extend from this base class.
 */
class RestfulController extends CController {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    Const APPLICATION_ID = 'VMS';
    const ADMIN_USER = 0;
    const VISITOR_USER = 1;
    /**
     * Send raw HTTP response
     * @param int $status HTTP status code
     * @param string $body The body of the HTTP response
     * @param string $contentType Header content-type
     * @return HTTP response 
     */
    protected function sendResponse($status = 200, $body = '', $contentType = 'application/json') {
        // Set the status
        $statusHeader = 'HTTP/1.1 ' . $status . ' ' . $this->getStatusCodeMessage($status);
        header($statusHeader);
        // Set the content type
        header('Content-type: ' . $contentType);
        // Allows from any origin
        // Allows a header called Authorization
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Authorization");

        echo $body;
        Yii::app()->end();
    }

    protected function checkAuth() {
        $headers = apache_request_headers();
        // Check if we have the USERNAME and PASSWORD HTTP headers set?
        try {
            if (!isset($headers['HTTP_X_' . self::APPLICATION_ID . '_TOKEN'])) {
                $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'HEADERS_NOT_FOUND', 'errorDescription' => 'Requset header not found.')));
            }
            $access_token = $headers['HTTP_X_' . self::APPLICATION_ID . '_TOKEN'];

            $tokens = new AccessTokens();
            $userData = $tokens->find('ACCESS_TOKEN=:token', array(':token' => $access_token));
            if ($userData == null) {
                // Error: Unauthorized
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'UNAUTHORIZED', 'errorDescription' => 'Requseted Token is Invalid')));
            } elseif ($userData->EXPIRY === null) {
                return $userData;
            } elseif ((strtotime('now') < strtotime($userData->EXPIRY))) {
                return $userData;
            }
        } catch (Exception $exc) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'Something went wrong.')));
        }
    }

    /**
     * Return the http status message based on integer status code
     * @param int $status HTTP status code
     * @return string status message
     */
    protected function getStatusCodeMessage($status) {
        $codes = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

}
