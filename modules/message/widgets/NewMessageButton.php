<?php

namespace zikwall\easyonline\modules\message\widgets;

use zikwall\easyonline\modules\ui\widgets\ModalButton;
use Yii;
use zikwall\easyonline\modules\core\components\base\Widget;

class NewMessageButton extends Widget
{
    /**
     * @var string
     */
    public $guid;

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $size = 'sm';

    /**
     * @var string
     */
    public $icon = 'fa-plus';

    /**
     * Creates the Wall Widget
     */
    public function run()
    {
        $button = ModalButton::info($this->getLabel())
            ->load(['/mail/mail/create', 'ajax' => 1, 'userGuid' => $this->guid]);

        if ($this->icon) {
            $button->icon($this->icon);
        }

        switch ($this->size) {
            case 'sm':
            case 'small':
                $button->sm();
                break;
            case 'lg':
            case 'large':
                $button->lg();
                break;
            case 'xs':
            case 'extraSmall':
                $button->xs();
                break;
        }

        return $button;
    }

    public function getLabel()
    {
        return ($this->guid)
            ? Yii::t('MessageModule.widgets_views_newMessageButton', 'Send message')
            : Yii::t('MessageModule.widgets_views_newMessageButton', 'New message');
    }
}

?>
