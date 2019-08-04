<?php

namespace zikwall\easyonline\modules\admin\components;

use Yii;
use zikwall\easyonline\modules\admin\permissions\DefaultAdmin;
use zikwall\easyonline\modules\admin\permissions\ManageModules;
use zikwall\easyonline\modules\core\behaviors\AccessControl;

class Controller extends \zikwall\easyonline\modules\core\components\base\Controller
{
    /**
     * @inheritdoc
     */
    public $subLayout = "@zikwall/easyonline/modules/admin/views/layouts/main";

    /**
     * @var boolean если true разрешает доступ только системным администраторам, доступ к ним ограничен getAccessRules )
     */
    public $adminOnly = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->appendPageTitle(Yii::t('AdminModule.base', 'Administration'));

        parent::init();
    }

    public function beforeAction($action)
    {
        Yii::$app->cache->flush();
        // Обходное решение для действий по настройке модуля (getAccessRules())
        if ($this->module->id != 'admin') {
            $this->adminOnly = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => AccessControl::class,
                'adminOnly' => $this->adminOnly,
                'rules' => $this->getAccessRules()
            ]
        ];

    }

    /**
     * Возвращает правила доступа для стандартного поведения управления доступом
     *
     * @see AccessControl
     * @return array the access permissions
     */
    public function getAccessRules()
    {
        // Использовать по умолчанию разрешение DefaultAdmin, если метод не перезаписывается настраиваемым модулем
        if ($this->module->id != 'admin') {
            return [];
        }
    }
}
