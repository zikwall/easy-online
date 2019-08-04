<div class="modal-box-layout">
    <div class="modal-box-title-wrap<?= $isGrey ? ' modal-box-grey' : ''; ?>">
        <div class="modal-box-x-button close" data-dismiss="modal" aria-label="Закрыть" tabindex="0" role="button"></div>
        <?php if (!empty($title)): ?>
            <div class="modal-box-title">
                <?= $title; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="modal-box-body modal-box-no-buttons">
        <div class="modal-box-content">
            <?= $content; ?>
        </div>
    </div>
</div>

<?php if ($isDraggable): ?>
    <script>
        $(function() {
            $('.modal-box-layout').draggable({
                handle: '.modal-box-title-wrap',
                //containment: 'window',
                //scroll: false,
            });
        });
    </script>
<?php endif; ?>



