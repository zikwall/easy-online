
<div class="modal-box-layout">
    <?php if ($header !== null || $showClose): ?>
        <div class="modal-box-title-wrap" style="">
            <?php if ($showClose): ?>
                <div class="modal-box-x-button close" data-dismiss="modal" aria-label="Закрыть" tabindex="0" role="button"></div>
            <?php endif; ?>
            <?php if ($header !== null): ?>
                <div class="modal-box-title"><?= $header; ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="modal-box-body modal-box-no-buttons">
        <div class="modal-box-content">
            <?php if ($dialogContent) : ?>
                <?= $dialogContent ?>
            <?php else : ?>
                <!-- Body -->

                <?php if ($body !== null): ?>
                    <?= $body ?>
                <?php endif; ?>
                <?php if ($initialLoader): ?>
                    <?php echo \zikwall\easyonline\modules\core\widgets\LoaderWidget::widget(); ?>
                <?php endif; ?>

                <!-- Footer -->
                <?php if ($footer !== null): ?>
                    <div class="modal-footer">
                        <?= $footer ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

