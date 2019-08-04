<?php

use yii\helpers\Html;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\controllers\ImageController;

if ($allowModifyProfileBanner || $allowModifyProfileImage) {
    $this->registerJsFile('@web-static/resources/user/profileHeaderImageUpload.js');
    $this->registerJs("var profileImageUploaderUserGuid='" . $user->guid . "';", \yii\web\View::POS_BEGIN);
    $this->registerJs("var profileImageUploaderCurrentUserGuid='" . Yii::$app->user->getIdentity()->guid . "';", \yii\web\View::POS_BEGIN);
    $this->registerJs("var profileImageUploaderUrl='" . Url::to(['/user/image/upload', 'userGuid' => $user->guid, 'type' => ImageController::TYPE_PROFILE_IMAGE]) . "';", \yii\web\View::POS_BEGIN);
    $this->registerJs("var profileHeaderUploaderUrl='" . Url::to(['/user/image/upload', 'userGuid' => $user->guid, 'type' => ImageController::TYPE_PROFILE_BANNER_IMAGE]) . "';", \yii\web\View::POS_BEGIN);
}
?>


<div class="ui-block">
    <div class="top-header">
        <div class="top-header-thumb">
            <img src="<?= $user->getProfileBannerImage()->getUrl(); ?>" alt="nature">
        </div>
        <div class="profile-section">
            <div class="row">
                <div class="col-lg-5 col-md-5 ">
                    <ul class="profile-menu">
                        <li>
                            <a href="02-ProfilePage.html">Timeline</a>
                        </li>
                        <li>
                            <a href="13-FavouritePage-About.html">About</a>
                        </li>
                        <li>
                            <a href="06-ProfilePage.html">Friends</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-5 offset-lg-2 col-md-5 offset-md-2">
                    <ul class="profile-menu">
                        <li>
                            <a href="07-ProfilePage-Photos.html">Photos</a>
                        </li>
                        <li>
                            <a href="09-ProfilePage-Videos.html">Videos</a>
                        </li>
                        <li>
                            <div class="more">
                                <svg class="olymp-three-dots-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#olymp-three-dots-icon"></use></svg>
                                <ul class="more-dropdown more-with-triangle">
                                    <li>
                                        <a href="#">Report Profile</a>
                                    </li>
                                    <li>
                                        <a href="#">Block Profile</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="control-block-button">
                <a href="35-YourAccount-FriendsRequests.html" class="btn btn-control bg-blue">
                    <svg class="olymp-happy-face-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#olymp-happy-face-icon"></use></svg>
                </a>

                <a href="#" class="btn btn-control bg-purple">
                    <svg class="olymp-chat---messages-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#olymp-chat---messages-icon"></use></svg>
                </a>

                <div class="btn btn-control bg-primary more">
                    <svg class="olymp-settings-icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#olymp-settings-icon"></use></svg>

                    <ul class="more-dropdown more-with-triangle triangle-bottom-right">
                        <li>
                            <a href="#" data-toggle="modal" data-target="#update-header-photo">Update Profile Photo</a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#update-header-photo">Update Header Photo</a>
                        </li>
                        <li>
                            <a href="29-YourAccount-AccountSettings.html">Account Settings</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="top-header-author">
            <a href="02-ProfilePage.html" class="author-thumb">
                <img src="<?= $user->getProfileImage()->getUrl(); ?>" alt="author">
            </a>
            <div class="author-content">
                <a href="02-ProfilePage.html" class="h4 author-name"><?= Html::encode($user->displayName); ?></a>
                <div class="country">San Francisco, CA</div>
            </div>
        </div>
    </div>
</div>
