<?php

namespace zikwall\easyonline\modules\community\widgets;

use Yii;
use yii\base\Widget;
use zikwall\easyonline\modules\content\models\Content;
use zikwall\easyonline\modules\post\models\Post;


class Header extends Widget
{
    /**
     * @var \zikwall\easyonline\modules\community\models\Community the Community which this header belongs to
     */
    public $community;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $postCount = 0;

        /*Content::find()->where([
            'object_model' => Post::class,
            'contentcontainer_id' => $this->community->contentContainerRecord->id
        ])->count();*/

        return $this->render('header', [
            'community' => $this->community,
            'followingEnabled' => !Yii::$app->getModule('community')->disableFollow,
            'postCount' => $postCount
        ]);
    }
}

?>
