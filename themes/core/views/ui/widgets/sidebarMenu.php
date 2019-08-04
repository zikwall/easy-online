<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div id="sidebar" class="sidebar float_left">
    <div class="sidebar-inner">
        <?php if (Yii::$app->user->getIsGuest()): ?>
            <?php $form = ActiveForm::begin(['enableClientValidation' => true, 'action' => Url::to(['/user/auth/login'])]); ?>
            <?= $form->field($advanced['loginForm'], 'username')->textInput(['id' => 'login_username', 'placeholder' => Yii::t('UserModule.views_auth_login', 'username or email')]); ?>
            <?= $form->field($advanced['loginForm'], 'password')->passwordInput(['id' => 'login_password', 'placeholder' => Yii::t('UserModule.views_auth_login', 'password')]); ?>
            <?= $form->field($advanced['loginForm'], 'rememberMe')->checkbox(); ?>
            <div style="text-align: center;">
                <button href="#" id="loginBtn" data-ui-loader type="submit" class="btn btn-primary" style="width: 100%">
                    <?= Yii::t('UserModule.views_auth_login', 'Sign in') ?>
                </button>
                <div class="more_div"></div>
                <a id="recoverPasswordBtn" href="<?= Url::to(['/user/password-recovery']) ?>" data-action-click="ui.modal.load" data-action-url="<?= Url::to(['/user/password-recovery']) ?>">
                    <?= Yii::t('UserModule.views_auth_login', 'Forgot your password?') ?>
                </a>
            </div>

            <?php ActiveForm::end(); ?>
        <?php else: ?>
            <nav>
                <ol>
                    <?php foreach ($this->context->getItems() as $item): ?>
                        <?php if ($item['label'] == '---'): ?>
                            <div class="more_div"></div>
                        <?php else: ?>
                            <?php
                            if (!empty($item['id'])) {
                                $item['htmlOptions']['id'] = $item['id'];
                            }

                            $item['htmlOptions']['data-pjax-prevent'] = isset($item['pjax']) && $item['pjax'] === false
                                ? true : false;
                            ?>
                            <li class="<?= isset($item['id']) ? $item['id'] : ''; ?>">
                                <a href="<?= $item['url']; ?>" class="sidebar-left-row">
                                <span class="sidebar-left-fixer">
                                    <span class="sidebar-left-icon float_left"></span>
                                        <span class="sidebar-left-label sidebar-inline-bl">
                                        <?= $item['label']; ?>
                                    </span>
                                </span>
                                </a>
                                <div class="sidebar-left-settings">
                                    <div class="sidebar-left-settings-inner"></div>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?= \zikwall\easyonline\modules\ui\widgets\SidebarUserMenu::widget(); ?>

                </ol>
            </nav>
            <?= \zikwall\easyonline\modules\ui\widgets\UndersidebarMenu::widget(); ?>
        <?php endif; ?>
    </div>
</div>



<script>
    window.addEventListener('DOMContentLoaded', function() {
        if (window.sidebarEnabled) {
            let sidebar = new StickySidebar('#sidebar', {
                containerSelector: '#main-container',
                innerWrapperSelector: '.sidebar',
                topSpacing: 55,
                bottomSpacing: 500
            });
        }
    });
</script>
