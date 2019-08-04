<?php

use \yii\helpers\Html;
use \yii\helpers\Url;
?>
<div class="topbar-actions pull-right">
    <?php if (Yii::$app->user->isGuest): ?>
        <a href="#" class="btn btn-enter" data-action-click="ui.modal.load" data-action-url="<?= Url::toRoute('/user/auth/login'); ?>">
            <?php if (Yii::$app->getModule('user')->settings->get('auth.anonymousRegistration')): ?>
                <?= Yii::t('UserModule.base', 'Sign in / up'); ?>
            <?php else: ?>
                <?= Yii::t('UserModule.base', 'Sign in'); ?>
            <?php endif; ?>
        </a>
    <?php else: ?>

        <ul class="nav">
            <li class="dropdown account">
                <a href="#" id="account-dropdown-link" class="dropdown-toggle" data-toggle="dropdown" aria-label="<?= Yii::t('base', 'Profile dropdown')?>" aria-expanded="false">
                    <?php if ($this->context->showUserName): ?>
                        <div class="user-title pull-left hidden-xs">
                            <strong><?= Html::encode(Yii::$app->user->getIdentity()->displayName); ?></strong>
                            <br>
                            <span class="truncate">Системный администратор</span>
                        </div>
                    <?php endif; ?>

                    <img id="user-account-image" class="img-rounded" src="https://vk.com/images/deactivated_hid_200.gif" height="22" width="22" alt="My profile image" data-src="holder.js/32x32" style="width: 22px; height: 22px;">

                    <span class="angle">
                        <b class="caret-a"></b>
                   </span>
                </a>
                <div id="top_profile_menu" class="shown dropdown-menu">
                    <?php foreach ($this->context->getItems() as $item): ?>
                        <?php if ($item['label'] == '---'): ?>
                            <div class="top_profile_sep" style=""></div>
                        <?php else: ?>
                            <a class="top_profile_mrow" <?= isset($item['id']) ? 'id="' . $item['id'] . '"' : '' ?>
                               href="<?= $item['url']; ?>" <?= isset($item['pjax']) && $item['pjax'] === false ? 'data-pjax-prevent' : '' ?>>
                                <?= $item['icon'] . ' ' . $item['label']; ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </li>
        </ul>
    <?php endif; ?>
</div>

