<!-- check if flash message exists -->
<?php if (Yii::$app->getSession()->hasFlash('data-saved')): ?>

    <script type="text/javascript">
        $(function() {
            log('<?= Yii::$app->getSession()->getFlash('data-saved'); ?>', true);
        });
    </script>

<?php endif; ?>





