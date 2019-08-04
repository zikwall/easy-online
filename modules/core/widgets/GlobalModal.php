<?php

namespace zikwall\easyonline\modules\core\widgets;

class GlobalModal extends Modal
{

    public $id = 'globalModal';

    /**
     * @inheritdoc
     * Это неправильео, потому что это часто используется для серьезной работы, например html-формы,
     * случайное закрытие которого может привести к потере пользовательских данных.
     */
    public $backdrop = false;
}
