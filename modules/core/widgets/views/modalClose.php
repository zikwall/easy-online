<?php
use zikwall\easyonline\modules\core\libs\Html;

/* @var $success string */
/* @var $saved boolean */
/* @var $error string */
/* @var $warn string */
/* @var $info string */
/* @var $script string */
/* @var $reload boolean*/
?>
<div class="modal-dialog modal-dialog-extra-small animated pulse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-content">
        <?php if (!(empty($success))) : ?>
            <script>
                $(function () {encore.modules.ui.status.success('<?= Html::encode($success) ?>')});
            </script>
        <?php elseif ($saved) : ?>
            <script>
                $(function () {encore.modules.ui.status.success('<?= Html::encode(Yii::t('base', 'Saved')) ?>')});
            </script>
        <?php elseif (!(empty($error))) : ?>
            <script>
                $(function () {encore.modules.ui.status.error('<?= Html::encode($error) ?>')});
            </script>
        <?php elseif (!(empty($warn))) : ?>
            <script>
                $(function () {encore.modules.ui.status.warn('<?= Html::encode($warn) ?>')});
            </script>
        <?php elseif (!(empty($info))) : ?>
            <script>
                $(function () {encore.modules.ui.status.info('<?= Html::encode($info) ?>')});
            </script>
        <?php endif; ?>
        <script>
            $(function () {
                encore.modules.ui.modal.global.close();
                <?php if ($script) : ?>
                <?= $script ?>
                <?php endif; ?>
                <?php if ($reload) : ?>
                encore.modules.client.reload();
                <?php endif; ?>
            });
        </script>
    </div>
</div>
