<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

// Paritov-Elbrusweb.com//

namespace zikwall\easyonline\modules\user\authclient;



class VKontakte extends \yii\authclient\clients\VKontakte
{


	public $scope = 'email, screen_name';

	protected function defaultViewOptions()
	    {
	            return [
	            'popupWidth' => 860,
	            'popupHeight' => 480,
	            'cssIcon' => 'fa fa-vk',
	            'buttonBackgroundColor' => '#395697',
	        ];
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap()
    {
	       return [
            'id' => 'uid',
            'username' => 'screen_name',
            'firstname' => 'first_name',
            'lastname' => 'last_name',

           ];
    }
}
