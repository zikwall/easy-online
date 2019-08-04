<?php

namespace zikwall\easyonline\modules\admin\widgets;

use Yii;
use yii\helpers\Url;
use zikwall\easyonline\modules\core\widgets\BaseMenu;

class InformationMenu extends BaseMenu
{

    /**
     * @inheritdoc
     */
    public $template = "@zikwall/easyonline/modules/core/widgets/views/tabMenu";

    public function init()
    {
        $this->addItem([
            'label' => Yii::t('AdminModule.information', 'About enCore'),
            'url' => Url::to(['/admin/information/about']),
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'information' && Yii::$app->controller->action->id == 'about'),
        ]);

        $this->addItem([
            'label' => Yii::t('AdminModule.information', 'Prerequisites'),
            'url' => Url::to(['/admin/information/prerequisites']),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'information' && Yii::$app->controller->action->id == 'prerequisites'),
        ]);

        $this->addItem([
            'label' => Yii::t('AdminModule.information', 'CronJobs'),
            'url' => Url::to(['/admin/information/cronjobs']),
            'sortOrder' => 400,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'admin' && Yii::$app->controller->id == 'information' && Yii::$app->controller->action->id == 'cronjobs'),
        ]);

        parent::init();
    }

}
