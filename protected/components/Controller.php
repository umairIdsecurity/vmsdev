<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    private $_assetsBase;
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    public function getAssetsBase()
    {
        if ($this->_assetsBase === null) {
            $this->_assetsBase = Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('application.assets'),
                false,
                -1,
                defined('YII_DEBUG') && YII_DEBUG
            );
        }
        return $this->_assetsBase;
    }

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

    public function beforeAction(CAction $action)
    {
        $systemIsShutdown = System::model()->isSystemShutdown();
        if (isset(Yii::app()->user->id)) {
            if (Yii::app()->controller->id != 'site') {
                if ($systemIsShutdown) {

                    if (!in_array(Yii::app()->user->role, array(Roles::ROLE_SUPERADMIN,
                        Roles::ROLE_ADMIN, Roles::ROLE_ISSUING_BODY_ADMIN))
                    )
                        $this->redirect(Yii::app()->createUrl("site/shutdown"));
                }
            } elseif (Yii::app()->controller->action->id == 'shutdown') {
                if (!$systemIsShutdown || in_array(Yii::app()->user->role, array(Roles::ROLE_SUPERADMIN,
                    Roles::ROLE_ADMIN, Roles::ROLE_ISSUING_BODY_ADMIN))
                )
                    $this->redirect(Yii::app()->createUrl("dashboard"));
            }
        }

        return true;
    }
}