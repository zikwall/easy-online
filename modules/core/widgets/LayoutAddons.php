<?php

namespace zikwall\easyonline\modules\core\widgets;

use Yii;
use yii\widgets\Pjax;

class LayoutAddons extends BaseStack
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!Yii::$app->request->isPjax) {
            $this->addWidget(GlobalModal::class);
            $this->addWidget(GlobalConfirmModal::class);

            $this->addWidget(LoaderWidget::class, ['show' => false, 'id' => "encore-ui-loader-default"]);

            if (Yii::$app->params['enablePjax']) {
                $this->addWidget(Pjax::class);
            }
        }
        parent::init();
    }

}
