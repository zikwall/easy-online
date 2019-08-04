<?php
/* @var $community \zikwall\easyonline\modules\community\models\Community */

use yii\helpers\Html;
use zikwall\easyonline\libs\Helpers;
?>

<li<?= (!$visible) ? ' style="display:none"' : '' ?> data-community-chooser-item <?= $data ?> data-community-guid="<?= $community->guid; ?>">
    <a href="<?= $community->getUrl(); ?>">

        <div class="media">
            <?=
            \zikwall\easyonline\modules\community\widgets\Image::widget([
                'community' => $community,
                'width' => 24,
                'htmlOptions' => [
                    'class' => 'pull-left',
            ]]);
            ?>
            <div class="media-body">
                <strong class="community-name"><?= Html::encode($community->name); ?></strong>
                    <?= $badge ?>
                <div  data-message-count="<?= $updateCount; ?>" style="display:none;" class="badge badge-community messageCount pull-right tt" title="<?= Yii::t('CommunityModule.widgets_views_communityChooserItem', '{n,plural,=1{# new entry} other{# new entries}} since your last visit', ['n' => $updateCount]); ?>">
                    <?= $updateCount; ?>
                </div>
                <br>
                <p><?= Html::encode(Helpers::truncateText($community->description, 60)); ?></p>
            </div>
        </div>
    </a>

</li>
