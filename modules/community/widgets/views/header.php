<?php
/* @var $this \zikwall\easyonline\components\View */
/* @var $currentCommunity \zikwall\easyonline\modules\community\models\Community */

use yii\helpers\Html;

if ($community->isAdmin()) {
    $this->registerJsFile('@web-static/resources/community/communityHeaderImageUpload.js');
    $this->registerJsVar('profileImageUploaderUrl', $community->createUrl('/community/manage/image/upload'));
    $this->registerJsVar('profileHeaderUploaderUrl', $community->createUrl('/community/manage/image/banner-upload'));
}
?>

<div class="panel panel-default panel-profile">

    <div class="panel-profile-header">

        <div class="image-upload-container" style="width: 100%; height: 100%; overflow:hidden;">
            <!-- profile image output-->
            <img class="img-profile-header-background" id="community-banner-image"
                 src="<?= 'http://c95202tj.bget.ru/resources/img/apps_groups_catalog_header.png'/*$community->getProfileBannerImage()->getUrl()*/; ?>"
                 width="100%" style="width: 100%;">

            <!-- check if the current user is the profile owner and can change the images -->
            <?php if ($community->isAdmin()) { ?>
                <form class="fileupload" id="bannerfileupload" action="" method="POST" enctype="multipart/form-data"
                      style="position: absolute; top: 0; left: 0; opacity: 0; width: 100%; height: 100%;">
                    <input type="file" name="bannerfiles[]">
                </form>

                <?php
                // set standard padding for banner progressbar
                $padding = '90px 350px';

                // if the default banner image is displaying
                /*if (!$community->getProfileBannerImage()->hasImage()) {
                    // change padding to the lower image height
                    $padding = '50px 350px';
                }*/
                ?>

                <div class="image-upload-loader" id="banner-image-upload-loader"
                     style="padding: <?= $padding ?>;">
                    <div class="progress image-upload-progess-bar" id="banner-image-upload-bar">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="00"
                             aria-valuemin="0"
                             aria-valuemax="100" style="width: 0%;">
                        </div>
                    </div>
                </div>

            <?php } ?>

            <!-- show user name and title -->
            <div class="img-profile-data">
                <h1 class="community"><?= Html::encode($community->name); ?></h1>

                <h2 class="community"><?= Html::encode($community->description); ?></h2>
            </div>

            <!-- check if the current user is the profile owner and can change the images -->
            <?php if ($community->isAdmin()) { ?>
                <div class="image-upload-buttons" id="banner-image-upload-buttons">
                    <a href="#" onclick="javascript:$('#bannerfileupload input').click();"
                       class="btn btn-info btn-sm"><i
                            class="fa fa-cloud-upload"></i></a>
                    <a id="banner-image-upload-edit-button"
                       style="<?php
/*                       if (!$community->getProfileBannerImage()->hasImage()) {
                           echo 'display: none;';
                       }
                       */?>"
                       href="<?= $community->createUrl('/community/manage/image/crop-banner'); ?>"
                       class="btn btn-info btn-sm" data-target="#globalModal" data-backdrop="static"><i
                            class="fa fa-edit"></i></a>
                        <?php
                        /*echo \zikwall\easyonline\modules\ui\widgets\Modal::widget(array(
                            'uniqueID' => 'modal_bannerimagedelete',
                            'linkOutput' => 'a',
                            'title' => Yii::t('CommunityModule.widgets_views_deleteBanner', '<strong>Confirm</strong> image deleting'),
                            'message' => Yii::t('CommunityModule.widgets_views_deleteBanner', 'Do you really want to delete your title image?'),
                            'buttonTrue' => Yii::t('CommunityModule.widgets_views_deleteBanner', 'Delete'),
                            'buttonFalse' => Yii::t('CommunityModule.widgets_views_deleteBanner', 'Cancel'),
                            'linkContent' => '<i class="fa fa-times"></i>',
                            'cssClass' => 'btn btn-danger btn-sm',
                            //'style' => $community->getProfileBannerImage()->hasImage() ? '' : 'display: none;',
                            'linkHref' => $community->createUrl("/community/manage/image/delete", ['type' => 'banner']),
                            'confirmJS' => 'function(jsonResp) { resetProfileImage(jsonResp); }'
                        ));*/
                        ?>
                </div>

            <?php } ?>
        </div>

        <div class="image-upload-container profile-user-photo-container" style="width: 140px; height: 140px;">

            <?php /*if ($community->profileImage->hasImage()) : */?><!--
                <!-- profile image output-->
                <a data-ui-gallery="communityHeader" href="<?/*= $community->profileImage->getUrl('_org'); */?>">
                    <?php /*echo \zikwall\easyonline\modules\community\widgets\Image::widget(['community' => $community, 'width' => 140]); */?>
                </a>
            <?php /*else : */?>
                <?php /*echo \zikwall\easyonline\modules\community\widgets\Image::widget(['community' => $community, 'width' => 140]); */?>
            <?php /*endif; */?>

            <!-- check if the current user is the profile owner and can change the images -->
            <?php if ($community->isAdmin()) : ?>
                <form class="fileupload" id="profilefileupload" action="" method="POST" enctype="multipart/form-data"
                      style="position: absolute; top: 0; left: 0; opacity: 0; height: 140px; width: 140px;">
                    <input type="file" name="communityfiles[]">
                </form>

                <div class="image-upload-loader" id="profile-image-upload-loader" style="padding-top: 60px;">
                    <div class="progress image-upload-progess-bar" id="profile-image-upload-bar">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="00"
                             aria-valuemin="0"
                             aria-valuemax="100" style="width: 0%;">
                        </div>
                    </div>
                </div>

                <div class="image-upload-buttons" id="profile-image-upload-buttons">
                    <a href="#" onclick="javascript:$('#profilefileupload input').click();" class="btn btn-info btn-sm"><i
                            class="fa fa-cloud-upload"></i></a>
                    <a id="profile-image-upload-edit-button"
                       style="<?php
/*                       if (!$community->getProfileImage()->hasImage()) {
                           echo 'display: none;';
                       }
                       */?>"
                       href="<?= $community->createUrl('/community/manage/image/crop'); ?>"
                       class="btn btn-info btn-sm" data-target="#globalModal" data-backdrop="static"><i
                            class="fa fa-edit"></i></a>
                        <?php
/*                        echo \zikwall\easyonline\modules\ui\widgets\Modal::widget(array(
                            'uniqueID' => 'modal_profileimagedelete',
                            'linkOutput' => 'a',
                            'title' => Yii::t('CommunityModule.widgets_views_deleteImage', '<strong>Confirm</strong> image deleting'),
                            'message' => Yii::t('CommunityModule.widgets_views_deleteImage', 'Do you really want to delete your profile image?'),
                            'buttonTrue' => Yii::t('CommunityModule.widgets_views_deleteImage', 'Delete'),
                            'buttonFalse' => Yii::t('CommunityModule.widgets_views_deleteImage', 'Cancel'),
                            'linkContent' => '<i class="fa fa-times"></i>',
                            'cssClass' => 'btn btn-danger btn-sm',
                            //'style' => $community->getProfileImage()->hasImage() ? '' : 'display: none;',
                            'linkHref' => $community->createUrl("/community/manage/image/delete", array('type' => 'profile')),
                            'confirmJS' => 'function(jsonResp) { resetProfileImage(jsonResp); }'
                        ));
                        */?>
                </div>
            <?php endif; ?>

        </div>


    </div>

    <div class="panel-body">

        <div class="panel-profile-controls">
            <!-- start: User statistics -->
            <div class="row">
                <div class="col-md-12">
                    <div class="statistics pull-left">

                        <div class="pull-left entry">
                            <span class="count"><?= $postCount; ?></span>
                            <br>
                            <span
                                class="title"><?= Yii::t('CommunityModule.widgets_views_profileHeader', 'Posts'); ?></span>
                        </div>

                        <a href="<?= $community->createUrl('/community/membership/members-list'); ?>" data-target="#globalModal">
                            <div class="pull-left entry">
                                <span class="count"><?= $community->getMemberships()->count(); ?></span>
                                <br>
                                <span
                                    class="title"><?= Yii::t('CommunityModule.widgets_views_profileHeader', 'Members'); ?></span>
                            </div>
                        </a>
                        <?php if ($followingEnabled): ?>
                            <a href="<?= $community->createUrl('/community/community/follower-list'); ?>" data-target="#globalModal">
                                <div class="pull-left entry">
                                    <span class="count"><?= $community->getFollowerCount(); ?></span><br>
                                    <span
                                        class="title"><?= Yii::t('CommunityModule.widgets_views_profileHeader', 'Followers'); ?></span>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                    <!-- end: User statistics -->

                    <div class="controls controls-header pull-right">
                        <?=
                        zikwall\easyonline\modules\community\widgets\HeaderControls::widget(['widgets' => [
                                [\zikwall\easyonline\modules\community\widgets\InviteButton::class, ['community' => $community], ['sortOrder' => 10]],
                                [\zikwall\easyonline\modules\community\widgets\MembershipButton::class, ['community' => $community], ['sortOrder' => 20]],
                                [\zikwall\easyonline\modules\community\widgets\FollowButton::class,
                                    [
                                        'community' => $community,
                                        'followOptions' => ['class' => 'btn btn-primary'],
                                        'unfollowOptions' => ['class' => 'btn btn-info']],
                                    [
                                        'sortOrder' => 30
                                    ]
                                ]
                        ]]);
                        ?>
                        <?=
                        zikwall\easyonline\modules\community\widgets\HeaderControlsMenu::widget([
                            'community' => $community,
                            'template' => '@ui/widgets/views/dropdownNavigation'
                        ]);
                        ?>
                    </div>
                </div>
            </div>

        </div>


    </div>

</div>

<!-- start: Error modal -->
<div class="modal" id="uploadErrorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-extra-small animated pulse">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"
                    id="myModalLabel"><?= Yii::t('CommunityModule.widgets_views_profileHeader', '<strong>Something</strong> went wrong'); ?></h4>
            </div>
            <div class="modal-body text-center">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"
                        data-dismiss="modal"><?= Yii::t('CommunityModule.widgets_views_profileHeader', 'Ok'); ?></button>
            </div>
        </div>
    </div>
</div>
