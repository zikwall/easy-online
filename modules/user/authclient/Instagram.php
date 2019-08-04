<?php
/**
 * Created by PhpStorm.
 * User: 123
 * Date: 17.04.2017
 * Time: 8:35
 */

namespace zikwall\easyonline\modules\user\authclient;



class Instagram extends \yii\authclient\clients\Instagram
{


    public $scope = 'email, screen_name';

    protected function defaultViewOptions()
    {
        return [
            'popupWidth' => 860,
            'popupHeight' => 480,
            'cssIcon' => 'fa fa-instagram',
            'buttonBackgroundColor' => '#395697',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap()
    {
        return [
            'id' => 'id',
            'username' => 'username',
            'firstname' => 'fullname',
            'lastname' => 'last_name',

        ];
    }
}
