<?php

namespace zikwall\easyonline\modules\user\widgets;

use zikwall\easyonline\modules\core\libs\BasePermission;
use Yii;
use yii\helpers\Html;
use \yii\helpers\Url;
use zikwall\easyonline\modules\user\models\User;
use zikwall\easyonline\modules\user\models\UserFilter;

class UserPicker extends \yii\base\Widget
{

    public $inputId = "";

    /**
     * JSON Search URL - defaults: search/json
     *
     * The token -keywordPlaceholder- will replaced by the current search query.
     *
     * @var String Url with -keywordPlaceholder-
     */
    public $userSearchUrl = "";

    /**
     * Maximum users
     *
     * @var int
     */
    public $maxUsers = 50;

    /**
     * Set guid for the current user
     *
     * @var string
     */
    public $userGuid = "";

    /**
     * Set focus to input or not
     *
     * @var boolean
     */
    public $focus = false;

    /**
     * @var User
     */
    public $model = null;

    /**
     * @var string
     */
    public $attribute = null;

    /**
     * @var string for input placeholder attribute.
     */
    public $placeholderText = "";
    
    /**
     * @var null
     */
    public $userRole = null;
    
    /**
     * @var null
     */
    public $data = null;

    public function init()
    {
        if ($this->userSearchUrl == "") {
            $this->userSearchUrl = Url::toRoute(['/user/search/json', 'keyword' => '-keywordPlaceholder-']);
        }
    }

    public function run()
    {
        $currentValue = "";
        if ($this->model != null && $this->attribute != null) {
            $attribute = $this->attribute;
            $currentValue = $this->model->$attribute;
        }

        return $this->render('userPicker', [
            'userSearchUrl' => $this->userSearchUrl,
            'maxUsers' => $this->maxUsers,
            'currentValue' => $currentValue,
            'inputId' => $this->inputId,
            'focus' => $this->focus,
            'userGuid' => $this->userGuid,
            'userRole' => $this->userRole,
            'data' => json_encode($this->data),
            'placeholderText' => $this->placeholderText,
        ]);
    }
    
    /**
     * Создает пользовательский массив json, используемый в интерфейсе userpicker js.
     * $cfg используется для указания значений фильтра: доступны следующие значения:
     * 
     * query - (ActiveQuery) Исходный запрос, который используется для добавления дополнительных фильтров. - default = Пользователь друзей, если модуль дружбы включен else User::find()
     * 
     * active - (boolean) Указывает, должен ли включаться только активный пользователь - default = true
     * 
     * maxResults - (int) Максимальное количество записей, возвращаемых в массиве - по умолчанию = 10
     * 
     * keyword - (string) Ключевое слово, которое фильтрует пользователя по имени пользователя, имени, фамилии и электронной почте
     * 
     * permission - (BasePermission) Дополнительный фильтр разрешений
     * 
     * fillQuery - (ActiveQuery) Может использоваться для заполнения массива результатов, если исходный запрос не возвращает maxResults, эти результаты будут иметь более низкий приоритет
     * 
     * fillUser - (boolean) Если установлено значение true и no fillQuery не задано, результат заполняется результатами User::find()
     * 
     * disableFillUser - Указывает, должны ли результаты fillQuery быть отключены в результатах userpicker - default = true
     *
     */
    /**
     * @param null $cfg
     * @return array|type json representation used by the userpicker
     */
    public static function filter($cfg = null)
    {
        $defaultCfg = [
            'active' => true,
            'maxResult' => 10,
            'disableFillUser' => true,
            'keyword' => null,
            'permission' => null,
            'fillQuery' => null,
            'fillUser' => false
        ];
        
        $cfg = ($cfg == null) ? $defaultCfg : array_merge($defaultCfg, $cfg);

        // Если исходный запрос не задан, мы используем getFriends, если модуль дружбы включен, в противном случае все пользователи
        if (!isset($cfg['query'])) {
            $cfg['query'] = (Yii::$app->getModule('friendship')->getIsEnabled()) 
                    ? Yii::$app->user->getIdentity()->getFriends()
                    : UserFilter::find();
        }

        // Отфильтровать исходный запрос и отключить пользователя без указанного разрешения.
        $user = UserFilter::filter($cfg['query'], $cfg['keyword'], $cfg['maxResult'], null, $cfg['active']);
        $jsonResult = self::asJSON($user, $cfg['permission'], 2);

        // Заполните результат дополнительными пользователями, если это разрешено, и результат будет меньше, чем maxResult
        if (count($user) < $cfg['maxResult'] && (isset($cfg['fillQuery']) || $cfg['fillUser']) ) {

            // Отфильтровывать пользователей с помощью fillQuery или по умолчанию fillQuery
            $fillQuery = (isset($cfg['fillQuery'])) ? $cfg['fillQuery'] : UserFilter::find();
            UserFilter::addKeywordFilter($fillQuery, $cfg['keyword'], ($cfg['maxResult'] - count($user)));
            $fillQuery->andFilterWhere(['not in', 'id', self::getUserIdArray($user)]);
            $fillUser = $fillQuery->all();

            // либо дополнительные пользователи отключены (по умолчанию), либо мы отключили их с разрешения
            $disableCondition = (isset($cfg['permission'])) ? $cfg['permission']  : $cfg['disableFillUser'];
            $jsonResult = array_merge($jsonResult, UserPicker::asJSON($fillUser, $disableCondition, 1));
        }   
        
        return $jsonResult;
    }
    
    /**
     * Assambles all user Ids of the given $users into an array
     * 
     * @param array $users array of user models
     * @return array user id array
     */
    private static function getUserIdArray($users)
    {
        $result = [];
        foreach($users as $user) {
            $result[] = $user->id;
        }
        return $result;
    }
    
    /**
     * Creates an json result with user information arrays. A user will be marked
     * as disabled, if the permission check fails on this user.
     * 
     * @param type $users
     * @param type $permission
     * @return type
     */
    public static function asJSON($users, $permission = null, $priority = null)
    {
        if (is_array($users)) {
            $result = [];
            foreach ($users as $user) {
                if ($user != null) {
                    $result[] = self::createJSONUserInfo($user, $permission, $priority);
                }
            }
            return $result;
        } else {
            return self::createJSONUserInfo($users, $permission, $priority);
        }
    }

    /**
     * Creates an single user-information array for a given user. A user will be marked
     * as disabled, if the permission check fails on this user.
     * 
     * @param type $user
     * @param type $permission
     * @return type
     */
    private static function createJSONUserInfo($user, $permission = null, $priority = null)
    {
        $disabled = false;
        
        if ($permission != null && $permission instanceof BasePermission) {
            $disabled = !$user->getPermissionManager()->can($permission);
        } else if ($permission != null) {
            $disabled = $permission;
        }
        
        $priority = ($priority == null) ? 0 : $priority;
        
        $text = Html::encode($user->displayName);
        $userInfo = [];
        $userInfo['id'] = $user->id;
        $userInfo['guid'] = $user->guid;
        $userInfo['disabled'] = $disabled;
        // Deprecated since v1.2 used by old user picker implementation...
        $userInfo['displayName'] = $text;
        $userInfo['text'] = $text;
        $userInfo['image'] = "/uploads/profile_image/d9b63f1d-8d44-427a-b566-92fef9f50312.jpg?m=1504813572";
        $userInfo['priority'] = $priority;
        $userInfo['link'] = $user->getUrl();
        return $userInfo;
    }
}

?>
