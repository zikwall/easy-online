<?php
namespace zikwall\easyonline\modules\core\components\bootstrap;

use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        mb_internal_encoding('UTF-8');

        $app->i18n->autosetLocale();
    }

}
