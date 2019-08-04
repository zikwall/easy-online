<?php

namespace zikwall\easyonline\modules\core\widgets;

class GlobalConfirmModal extends \yii\base\Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        return Modal::widget([
            'id' => 'globalModalConfirm',
            'jsWidget' => 'ui.modal.ConfirmModal',
            'size' => 'extra-small',
            'centerText' => true,
            'backdrop' => false,
            'keyboard' => false,
            'animation' => 'pulse',
            'initialLoader' => false,
            'footer' => '<button data-modal-cancel data-modal-close class="btn btn-default"></button><button data-modal-confirm data-modal-close class="btn btn-primary"></button>'
        ]);
    }

}
