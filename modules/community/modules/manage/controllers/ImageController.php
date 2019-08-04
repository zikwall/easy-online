<?php


namespace zikwall\easyonline\modules\community\modules\manage\controllers;

use Yii;
use zikwall\easyonline\modules\community\modules\manage\components\Controller;

/**
 * ImageControllers handles community profile and banner image
 *
 * @author Luke
 */
class ImageController extends Controller
{

    /**
     * Handle the profile image upload
     */
    public function actionUpload()
    {
        \Yii::$app->response->format = 'json';

        $model = new \zikwall\easyonline\models\forms\UploadProfileImage();

        $json = array();

        $files = \yii\web\UploadedFile::getInstancesByName('communityfiles');
        $file = $files[0];
        $model->image = $file;

        if ($model->validate()) {

            $json['error'] = false;

            $profileImage = new \zikwall\easyonline\libs\ProfileImage($this->getCommunity()->guid);
            $profileImage->setNew($model->image);

            $json['name'] = "";
            $json['community_id'] = $this->getCommunity()->id;
            $json['url'] = $profileImage->getUrl();
            $json['size'] = $model->image->size;
            $json['deleteUrl'] = "";
            $json['deleteType'] = "";
        } else {
            $json['error'] = true;
            $json['errors'] = $model->getErrors();
        }

        return array('files' => $json);
    }

    /**
     * Crops the community image
     */
    public function actionCrop()
    {
        $community = $this->getCommunity();
        $model = new \zikwall\easyonline\models\forms\CropProfileImage();
        $profileImage = new \zikwall\easyonline\libs\ProfileImage($community->guid);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $profileImage->cropOriginal($model->cropX, $model->cropY, $model->cropH, $model->cropW);
            return $this->htmlRedirect($community->getUrl());
        }


        return $this->renderAjax('crop', array('model' => $model, 'profileImage' => $profileImage, 'community' => $community));
    }

    /**
     * Handle the banner image upload
     */
    public function actionBannerUpload()
    {
        \Yii::$app->response->format = 'json';

        $model = new \zikwall\easyonline\models\forms\UploadProfileImage();
        $json = array();

        $files = \yii\web\UploadedFile::getInstancesByName('bannerfiles');
        $file = $files[0];
        $model->image = $file;

        if ($model->validate()) {
            $profileImage = new \zikwall\easyonline\libs\ProfileBannerImage($this->getCommunity()->guid);
            $profileImage->setNew($model->image);

            $json['error'] = false;
            $json['name'] = "";
            $json['url'] = $profileImage->getUrl();
            $json['size'] = $model->image->size;
            $json['deleteUrl'] = "";
            $json['deleteType'] = "";
        } else {
            $json['error'] = true;
            $json['errors'] = $model->getErrors();
        }

        return ['files' => $json];
    }

    /**
     * Crops the banner image
     */
    public function actionCropBanner()
    {
        $community = $this->getCommunity();
        $model = new \zikwall\easyonline\models\forms\CropProfileImage();
        $profileImage = new \zikwall\easyonline\libs\ProfileBannerImage($community->guid);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $profileImage->cropOriginal($model->cropX, $model->cropY, $model->cropH, $model->cropW);
            return $this->htmlRedirect($community->getUrl());
        }

        return $this->renderAjax('cropBanner', array('model' => $model, 'profileImage' => $profileImage, 'community' => $community));
    }

    /**
     * Deletes the profile image or profile banner
     */
    public function actionDelete()
    {
        \Yii::$app->response->format = 'json';
        $this->forcePostRequest();

        $community = $this->getCommunity();

        $type = Yii::$app->request->get('type', 'profile');
        $json = array('type' => $type);

        $image = NULL;
        if ($type == 'profile') {
            $image = new \zikwall\easyonline\libs\ProfileImage($community->guid, 'default_community');
        } elseif ($type == 'banner') {
            $image = new \zikwall\easyonline\libs\ProfileBannerImage($community->guid);
        }

        if ($image) {
            $image->delete();
            $json['community_id'] = $community->id;
            $json['defaultUrl'] = $image->getUrl();
        }

        return $json;
    }

}

?>
