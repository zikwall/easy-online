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

        <?php if (count($communitys) === 0): ?>
            <div class="modal-body">
                <p><?= Yii::t('CommunityModule.base', 'No communitys found.'); ?></p>
            </div>
        <?php endif; ?>      


        <div id="communitylist-content">

            <ul class="media-list">
                <!-- BEGIN: Results -->
                <?php foreach ($communitys as $community) : ?>
                    <li>
                        <a href="<?= $community->getUrl(); ?>">

                            <div class="media">
                                <img class="media-object img-rounded pull-left"
                                     src="<?= $community->getProfileImage()->getUrl(); ?>" width="50"
                                     height="50" alt="50x50" data-src="holder.js/50x50"
                                     style="width: 50px; height: 50px;">


                                <div class="media-body">
                                    <h4 class="media-heading"><?= Html::encode($community->name); ?>
                                    <h5><?= Html::encode($community->description); ?></h5>
                                </div>
                            </div>
                        </a>
                    </li>


                <?php endforeach; ?>
                <!-- END: Results -->

            </ul>

            <div class="pagination-container">
                <?= \zikwall\easyonline\widgets\AjaxLinkPager::widget(['pagination' => $pagination]); ?>
            </div>


        </div>


    </div>

</div>

<script type="text/javascript">

    // scroll to top of list
    $(".modal-body").animate({scrollTop: 0}, 200);

</script>

