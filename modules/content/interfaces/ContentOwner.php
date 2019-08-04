<?php

namespace zikwall\easyonline\modules\content\interfaces;

interface ContentOwner
{
    /**
     * @return mixed
     */
    public function getContent();

    /**
     * @returns string name of the content like 'comment', 'post'
     */
    public function getContentName();

    /**
     * @returns string short content description
     */
    public function getContentDescription();
}
