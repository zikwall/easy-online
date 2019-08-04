<?php

namespace zikwall\easyonline\modules\core\widgets;

use Yii;
use zikwall\easyonline\modules\user\components\User;

class GlobalTopMenu extends BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "topNavigation";

    /**
     * @inheritdoc
     */
    public $id = 'top-menu-nav';

    /**
     * Минималистические иконки меню (опционально указываются в шаблоне)
     */
    public $mini = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->mini){
            $this->template = 'topNavigationMini';
        }

        // Отключаем меню для гостей
        if (Yii::$app->user->isGuest && !User::isGuestAccessEnabled()) {
            $this->template = '';
        }
    }

}

?>
