<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php if ($user->hasTags()) : ?>
    <div class="panel" id="user-tags-panel">
        <div class="panel-content">
            <div class="panel-heading">
                <h1 class="page-headers small"><?= Yii::t('UserModule.widgets_views_userTags', '<strong>User</strong> tags'); ?></h1>
            </div>
            <hr>
            <div class="tags">
                <?php foreach ($user->getTags() as $tag): ?>
                    <?= Html::a(Html::encode($tag), Url::to(['/directory/directory/members', 'keyword' => $tag]), ['class' => 'btn btn-primary btn-xs tag']); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<script type="text/javascript">
    function toggleUp() {
        $('.pups').slideUp("fast", function () {
            // Animation complete.
            $('#collapse').hide();
            $('#expand').show();
        });
    }

    function toggleDown() {
        $('.pups').slideDown("fast", function () {
            // Animation complete.
            $('#expand').hide();
            $('#collapse').show();
        });
    }
</script>