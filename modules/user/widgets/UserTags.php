<?php

namespace zikwall\easyonline\modules\user\widgets;

/**
 * UserTagsWidget lists all skills/tags of the user
 *
 * @package encore.modules_core.user.widget
 * @since 0.5
 * @author andystrobel
 */
class UserTags extends \yii\base\Widget
{
    public $user;

    public function run()
    {
        return $this->render('userTags', ['user' => $this->user]);
    }

}

?>
