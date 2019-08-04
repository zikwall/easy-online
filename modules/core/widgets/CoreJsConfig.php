<?php

namespace zikwall\easyonline\modules\core\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\models\UserPicker;

class CoreJsConfig extends Widget
{
    public function run()
    {
        if (!Yii::$app->user->isGuest) {
            $userConfig = UserPicker::asJSON(Yii::$app->user->getIdentity());
            $userConfig['isGuest'] = false;
        } else {
            $userConfig = ['isGuest' => true];
        }

        /*$liveModule = Yii::$app->getModule('live');*/

        $this->getView()->registerJsConfig(
            [
                'user' => $userConfig,
                'client' => [
                    'baseUrl' =>  Yii::$app->settings->get('baseUrl')
                ],
                'action' => [
                    'text' => [
                        'actionHandlerNotFound' => Yii::t('base', 'An error occurred while handling your last action. (Handler not found).'),
                    ]
                ],
                'ui.modal' => [
                    'defaultConfirmHeader' => Yii::t('base', '<strong>Confirm</strong> Action'),
                    'defaultConfirmBody' => Yii::t('base', 'Do you really want to perform this action?'),
                    'defaultConfirmText' => Yii::t('base', 'Confirm'),
                    'defaultCancelText' => Yii::t('base', 'Cancel')
                ],
                'ui.widget' => [
                    'text' => [
                        'error.unknown' => Yii::t('base', 'No error information given.'),
                        'info.title' => Yii::t('base', 'Info:'),
                        'error.title' => Yii::t('base', 'Error:')
                    ]
                ],
                'log' => [
                    'traceLevel' => (YII_DEBUG) ? 'DEBUG' : 'INFO',
                    'text' => [
                        'error.default' => Yii::t('base', 'An unexpected error occurred. If this keeps happening, please contact a site administrator.'),
                        'success.saved' => Yii::t('base', 'Saved'),
                        'saved' => Yii::t('base', 'Saved'),
                        'success.edit' => Yii::t('base', 'Saved'),
                        0 => Yii::t('base', 'An unexpected error occurred. If this keeps happening, please contact a site administrator.'),
                        403 => Yii::t('base', 'You are not allowed to run this action.'),
                        404 => Yii::t('base', 'The requested resource could not be found.'),
                        405 => Yii::t('base', 'Error while running your last action (Invalid request method).'),
                        500 => Yii::t('base', 'An unexpected server error occurred. If this keeps happening, please contact a site administrator.')
                    ]
                ],
                'ui.status' => [
                    'showMore' => Yii::$app->user->isAdmin() || YII_DEBUG,
                    'text' => [
                        'showMore' => Yii::t('base', 'Show more'),
                        'showLess' => Yii::t('base', 'Show less')
                    ]
                ],
            ]);
    }

}
