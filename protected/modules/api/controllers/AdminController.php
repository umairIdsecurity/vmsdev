<?php

class AdminController extends RestfulController {

    /**
     * Admin
     * Get Admin & Admin Logout
     * by rohan m.
     * * */
    public function actionIndex() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->getParam('email')) {
                $email = Yii::app()->request->getParam('email');
                $admin = User::model()->with('com')->findByAttributes(array('email' => $email));
                if ($admin) {
                    $result = array();
                    $result['firstName'] = $admin->first_name;
                    $result['lastName'] = $admin->last_name;
                    $result['email'] = $admin->email;
                    $result['companyName'] = ($admin->com->name) ? $admin->com->name : "N/A";
                    $result['companyTagLine'] = ($admin->com->trading_name) ? $admin->com->trading_name : "N/A";
                    $result['VICPickupLocation'] = "N/A";
                    $result['visitorLogin'] = false;
                    $result['photoRequired'] = true;
                    $result['complianceTerms'] = $this->getComplianceTerms();
                    if (isset($admin->com->companyPreference)) {
                        $pref = $admin->com->companyPreference;
                        $result['brandInfo']['companyLogoURL'] = ($admin->com->ph) ? Yii::app()->request->hostInfo . yii::app()->baseUrl . '/' . $admin->com->ph->relative_path : "N/A";
                        #actionForwardButton
                        $result['brandInfo']['actionForwardButton']['backgroundColor'] = $pref->action_forward_bg_color;
                        $result['brandInfo']['actionForwardButton']['backgroundGradient'] = $pref->action_forward_bg_color2;
                        $result['brandInfo']['actionForwardButton']['textColor'] = $pref->action_forward_font_color;
                        $result['brandInfo']['actionForwardButton']['hoverBackgroundColor'] = $pref->action_forward_hover_color;
                        $result['brandInfo']['actionForwardButton']['hoverBackgroundColor2'] = $pref->action_forward_hover_color2;
                        $result['brandInfo']['actionForwardButton']['hoverTextColor'] = $pref->action_forward_hover_font_color;

                        #completeButton
                        $result['brandInfo']['completeButton']['backgroundColor'] = $pref->complete_bg_color;
                        $result['brandInfo']['completeButton']['backgroundGradient'] = $pref->complete_bg_color2;
                        $result['brandInfo']['completeButton']['textColor'] = $pref->complete_hover_color;
                        $result['brandInfo']['completeButton']['hoverBackgroundColor'] = $pref->complete_hover_color2;
                        $result['brandInfo']['completeButton']['hoverBackgroundColor2'] = $pref->complete_font_color;
                        $result['brandInfo']['completeButton']['hoverTextColor'] = $pref->complete_hover_font_color;

                        #neutralButton
                        $result['brandInfo']['neutralButton']['backgroundColor'] = $pref->neutral_bg_color;
                        $result['brandInfo']['neutralButton']['backgroundGradient'] = $pref->neutral_bg_color2;
                        $result['brandInfo']['neutralButton']['textColor'] = $pref->neutral_hover_color;
                        $result['brandInfo']['neutralButton']['hoverBackgroundColor'] = $pref->neutral_hover_color2;
                        $result['brandInfo']['neutralButton']['hoverBackgroundColor2'] = $pref->neutral_font_color;
                        $result['brandInfo']['neutralButton']['hoverTextColor'] = $pref->neutral_hover_font_color;

                        #navigationMenu
                        $result['brandInfo']['navigationMenu']['backgroundColor'] = $pref->nav_bg_color;
                        $result['brandInfo']['navigationMenu']['textColor'] = $pref->nav_hover_color;
                        $result['brandInfo']['navigationMenu']['hoverBackgroundColor'] = $pref->nav_font_color;
                        $result['brandInfo']['navigationMenu']['hoverTextColor'] = $pref->nav_hover_font_color;

                        #sideMenuAndHeaderText
                        $result['brandInfo']['sideMenuAndHeaderText']['backgroundColor'] = $pref->sidemenu_bg_color;
                        $result['brandInfo']['sideMenuAndHeaderText']['textColor'] = $pref->sidemenu_hover_color;
                        $result['brandInfo']['sideMenuAndHeaderText']['hoverBackgroundColor'] = $pref->sidemenu_font_color;
                        $result['brandInfo']['sideMenuAndHeaderText']['hoverTextColor'] = $pref->sidemenu_hover_font_color;
                    }

                    $this->sendResponse(200, CJSON::encode($result));
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'ADMIN_DOES_NOT_EXIST', 'errorDescription' => 'Requested Admin not found')));
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'Something went wrong')));
        }
    }

    public function actionLogout() {
        try {
            $token_user = $this->checkAuth();
            if (Yii::app()->request->getParam('email')) {
                $email = Yii::app()->request->getParam('email');
                $admin = User::model()->with('com')->findByAttributes(array('email' => $email));
                if ($admin) {
                    $access_token = AccessTokens::model()->findByAttributes(array('USER_ID' => $admin->id));
                    if ($access_token) {
                        $access_token->delete();
                        $this->sendResponse(204);
                    }
                } else {
                    $this->sendResponse(404, CJSON::encode(array('responseCode' => 404, 'errorCode' => 'ADMIN_NOT_FOUND', 'errorDescription' => 'Requested Admin not found')));
                }
            } else {
                $this->sendResponse(401, CJSON::encode(array('responseCode' => 401, 'errorCode' => 'INVALID_PARAMETER', 'errorDescription' => 'GET parameter required for action')));
            }
        } catch (Exception $ex) {
            $this->sendResponse(500, CJSON::encode(array('responseCode' => 500, 'errorCode' => 'INTERNAL_SERVER_ERROR', 'errorDescription' => 'something went wrong')));
        }
    }
    private function getComplianceTerms(){
        $terms = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip';
            return array($terms,$terms,$terms);
    }
        

}
