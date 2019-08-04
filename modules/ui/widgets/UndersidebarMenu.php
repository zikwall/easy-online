<?php

namespace zikwall\easyonline\modules\ui\widgets;

use Yii;
use zikwall\easyonline\modules\core\widgets\BaseMenu;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\components\User;

class UndersidebarMenu extends BaseMenu
{
    /**
     * @inheritdoc
     */
    public $template = "@zikwall/easyonline/themes/core/views/ui/widgets/unsidebarMenu";

    /**
     * @inheritdoc
     */
    public $type = 'down-sidebar';

    /**
     * @inheritdoc
     */
    public $id = 'underside-menu-nav';

    public function init()
    {
        parent::init();

        if (Yii::$app->hasModule('blog')) {
            $this->addItem([
                'label' => 'Блог',
                'url' => Url::to(['/blog']),
                'sortOrder' => 100,
            ]);
        }
        
        $this->addItem([
            'label' => 'Разработчикам',
            'url' => Url::to(['/default']),
            'sortOrder' => 200,
        ]);

        $this->addItem([
            'label' => 'Реклама',
            'url' => Url::to(['/default']),
            'sortOrder' => 300,
        ]);

        $this->addItem([
            'label' => 'О Компании',
            'url' => Url::to(['/default']),
            'sortOrder' => 400,
        ]);

        $this->addItem([
            'label' => 'Вакансии',
            'url' => Url::to(['/default']),
            'sortOrder' => 500,
        ]);

        $this->addItem([
            'label' => 'Правовая информация',
            'url' => Url::to(['/default']),
            'sortOrder' => 600,
        ]);

        $this->addItem([
            'label' => 'Защита данных',
            'url' => Url::to(['/default']),
            'sortOrder' => 700,
        ]);

        $this->addItem([
            'label' => 'Центр безопасности',
            'url' => Url::to(['/default']),
            'sortOrder' => 800,
        ]);

        $this->addItem([
            'label' => 'Язык: русский',
            'url' => Url::to(['/default']),
            'sortOrder' => 900,
        ]);

        if (Yii::$app->user->isGuest && !User::isGuestAccessEnabled()) {
            $this->template = '';

            return false;
        }

        return parent::run();
    }
}
