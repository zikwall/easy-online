<?php
$this->registerJsFile('@web/resources/js/highlight.js/highlight.pack.js', ['position' => yii\web\View::POS_BEGIN]);
$this->registerCssFile('@web/resources/js/highlight.js/styles/' . $highlightJsCss . '.css');
?>
<div class="markdown-render">
    <?= $content; ?>
</div>

<script>
    $(function () {
        $("pre code").each(function (i, e) {
            hljs.highlightBlock(e);
        });
    });
</script>