<?php

namespace zikwall\easyonline\modules\user\widgets;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\core\widgets\BaseMenu;


class UserSettingMenu extends BaseMenu
{

    public $template = "@core/widgets/views/tabMenu";
    public $type = "adminUserSettingNavigation";

    public function init()
    {
        $this->addItem(array(
            'label' => Yii::t('AdminModule.views_setting_authentication', 'General'),
            'url' => Url::toRoute(['/admin/setting/authentication']),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'settings' && Yii::$app->controller->action->id == 'authentication'),
        ));
        $this->addItem(array(
            'label' => Yii::t('AdminModule.views_setting_authentication', 'LDAP'),
            'url' => Url::toRoute(['/admin/setting/authentication-ldap']),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'settings' && Yii::$app->controller->action->id == 'authentication-ldap'),
        ));

        parent::init();
    }

}
