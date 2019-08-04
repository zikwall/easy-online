<?php

use \yii\helpers\Html;
use \yii\helpers\Url;
?>
<?php if (Yii::$app->user->isGuest): ?>
    <a href="#" class="btn btn-enter" data-action-click="ui.modal.load" data-action-url="<?= Url::toRoute('/user/auth/login'); ?>">
        <?php if (Yii::$app->getModule('user')->settings->get('auth.anonymousRegistration')): ?>
            <?= Yii::t('UserModule.base', 'Sign in / up'); ?>
        <?php else: ?>
            <?= Yii::t('UserModule.base', 'Sign in'); ?>
        <?php endif; ?>
    </a>
<?php else: ?>
    <?php foreach ($this->context->getItems() as $item): ?>
        <?php if ($item['label'] == '---'): ?>
            <div class="dropdown-divider"></div>
        <?php elseif ($item['htmlOptions']['class'] == 'header'): ?>
            <a class="dropdown-header"><?= $item['label']; ?></a>
        <?php else: ?>
            <?php
            $item['htmlOptions']['class'] = 'dropdown-item';
            if (!empty($item['id'])) {
                $item['htmlOptions']['id'] = $item['id'];
            }
            $item['htmlOptions']['data-pjax-prevent'] = isset($item['pjax']) && $item['pjax'] === false ? true : false;
            ?>
            <?= Html::a($item['icon'] . ' ' . $item['label'], $item['url'], $item['htmlOptions']); ?>
        <?php endif; ?>
    <?php endforeach; ?>

<?php endif; ?>