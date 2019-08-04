<?php

use yii\helpers\Html;
?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"
                id="myModalLabel">
                    <?= $title; ?>
            </h4>
            <br/>
        </div>

        <?php if (count($users) === 0): ?>
            <div class="modal-body">
                <p><?= Yii::t('UserModule.base', 'No users found.'); ?></p>
            </div>
        <?php endif; ?>      


        <div id="userlist-content">

            <ul class="media-list">
                <!-- BEGIN: Results -->
                <?php foreach ($users as $user) : ?>
                    <li>
                        <a href="<?= $user->getUrl(); ?>">
                            <div class="media">
                                <div class="media-body">
                                    <h4 class="media-heading"><?= Html::encode($user->displayName); ?></h4>
                                </div>
                            </div>
                        </a>
                    </li>


                <?php endforeach; ?>
                <!-- END: Results -->

            </ul>

            <div class="pagination-container">
                <?= \zikwall\easyonline\modules\core\widgets\AjaxLinkPager::widget(['pagination' => $pagination]); ?>
            </div>


        </div>


    </div>

</div>

<script type="text/javascript">

    // scroll to top of list
    $(".modal-body").animate({scrollTop: 0}, 200);

</script>

