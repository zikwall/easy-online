<?php

use zikwall\easyonline\modules\community\modules\manage\widgets\DefaultMenu;

$this->registerJsFile('@web-static/resources/community/communityHeaderImageUpload.js');
$this->registerJsVar('profileImageUploaderUrl', $community->createUrl('/community/manage/image/upload'));
$this->registerJsVar('profileHeaderUploaderUrl', $community->createUrl('/community/manage/image/banner-upload'));
?>


<br/>
<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('CommunityModule.communitytype', '<strong>Change</strong> community image'); ?></div>
    <?= DefaultMenu::widget(['community' => $community]); ?>
    <div class="panel-body">

        <strong><?= Yii::t('CommunityModule.communitytype', 'Current image'); ?></strong>

        <div class="image-upload-container profile-user-photo-container"
             style="width: 140px; height: 140px; margin-top: 5px;">

            <?php
            /* Get original profile image URL */

            //$profileImageExt = pathinfo($community->getProfileImage()->getUrl(), PATHINFO_EXTENSION);

            //$profileImageOrig = preg_replace('/.[^.]*$/', '', $community->getProfileImage()->getUrl());
            //$defaultImage = (basename($community->getProfileImage()->getUrl()) == 'default_community.jpg' || basename($community->getProfileImage()->getUrl()) == 'default_community.jpg?cacheId=0') ? true : false;
            $profileImageOrig = $profileImageOrig . '_org.' . $profileImageExt;

            if (!$defaultImage) {
                ?>
                <!-- profile image output-->
                <a data-toggle="lightbox" data-gallery="" href="<?= $profileImageOrig; ?>#.jpeg"
                   data-footer='<button type="button" class="btn btn-primary" data-dismiss="modal"><?= Yii::t('CommunityModule.widgets_views_profileHeader', 'Close'); ?></button>'>
                       <?= \zikwall\easyonline\modules\community\widgets\Image::widget(['community' => $community, 'width' => 140]); ?>
                </a>
            <?php } else { ?>
                <?= \zikwall\easyonline\modules\community\widgets\Image::widget(['community' => $community, 'width' => 140]); ?>
            <?php } ?>

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

        </div>
        <br>
        <div>

            <a href="#" onclick="javascript:$('#profilefileupload input').click();" class="btn btn-primary"><i
                    class="fa fa-cloud-upload"></i> <?= Yii::t('CommunityModule.communitytype', 'Upload image'); ?></a>
            <a id="profile-image-upload-edit-button"
               style="<?php
               /*if (!$community->getProfileImage()->hasImage()) {
                   echo 'display: none;';
               }*/
               ?>"
               href="<?= $community->createUrl('/community/manage/image/crop'); ?>"
               class="btn btn-primary" data-target="#globalModal"><i
                    class="fa fa-edit"></i> <?= Yii::t('CommunityModule.communitytype', 'Crop image'); ?></a>
                <?php
/*                    echo \zikwall\easyonline\modules\core\widgets\ModalDialog::widget(array(
                        'uniqueID' => 'modal_profileimagedelete',
                    'linkOutput' => 'a',
                    'title' => Yii::t('CommunityModule.widgets_views_deleteImage', '<strong>Confirm</strong> image deleting'),
                    'message' => Yii::t('CommunityModule.widgets_views_deleteImage', 'Do you really want to delete your profile image?'),
                    'buttonTrue' => Yii::t('CommunityModule.widgets_views_deleteImage', 'Delete'),
                    'buttonFalse' => Yii::t('CommunityModule.widgets_views_deleteImage', 'Cancel'),
                    'linkContent' => '<i class="fa fa-times"></i>&nbsp;' . Yii::t('CommunityModule.communitytype', 'Delete image'),
                    'cssClass' => 'btn btn-danger pull-right',
                    //'style' => $community->getProfileImage()->hasImage() ? '' : 'display: none;',
                    'linkHref' => $community->createUrl("/community/manage/image/delete", array('type' => 'profile')),
                    'confirmJS' => 'function(jsonResp) { resetProfileImage(jsonResp); }'
                ));
                */?>
        </div>
    </div>


</div>


