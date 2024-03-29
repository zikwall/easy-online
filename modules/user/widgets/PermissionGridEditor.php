<?php

namespace zikwall\easyonline\modules\user\widgets;

use zikwall\easyonline\modules\core\widgets\GridView;
use Yii;
use yii\data\ArrayDataProvider;
use zikwall\easyonline\modules\core\libs\Html;

/**
 * PermissionGridView
 *
 * @author luke
 */
class PermissionGridEditor extends GridView
{

    /**
     * @var boolean hide not changeable permissions
     */
    public $hideFixedPermissions = true;

    /**
     * @inheritdoc
     */
    public $showHeader = false;

    /**
     * @var \zikwall\easyonline\modules\user\components\PermissionManager
     */
    public $permissionManager;

    /**
     * @var string Community Id
     */
    public $groupId = "";

    /**
     * @var string used to community row headers
     */
    private $lastModuleId = '';

    /**
     * @inheritdoc
     */
    public $options = ['class' => 'grid-view permission-grid-editor'];

    /**
     * @inheritdoc
     */
    public function init()
    {
        Yii::configure($this, [
            'dataProvider' => $this->getDataProvider(),
            'layout' => "{items}\n{pager}",
            'columns' => [
                [
                    'label' => Yii::t('UserModule.widgets_PermissionGridEditor', 'Permission'),
                    'attribute' => 'title',
                    'content' => function($data) {
                        $module = Yii::$app->getModule($data['moduleId']);
                        return Html::tag('strong', $data['title']) .
                            '&nbsp;&nbsp;' .
                            Html::tag('span', $module->getName(), ['class' => 'badge']) .
                            Html::tag('br') .
                            $data['description'];
                    }
                ],
                [
                    'label' => '',
                    'class' => 'zikwall\easyonline\modules\core\libs\DropDownGridColumn',
                    'attribute' => 'state',
                    'readonly' => function($data) {
                        return !($data['changeable']);
                    },
                    'submitAttributes' => [ 'permissionId', 'moduleId'],
                    'dropDownOptions' => 'states'
                ],
            ],
        ]);

        /* Used for sections
          $this->beforeRow = function($model, $key, $index, $that) {
          if ($that->lastModuleId != $model['moduleId']) {
          $module = Yii::$app->getModule($model['moduleId']);
          $cell = Html::tag('td', Html::tag('br') . Html::tag('strong', $module->getName()), ['colspan' => 3]);
          $that->lastModuleId = $model['moduleId'];
          return Html::tag('tr', $cell);
          } else {
          return '';
          }
          };
         */

        parent::init();
    }

    /**
     * Returns data provider
     *
     * @return \yii\data\DataProviderInterface
     */
    protected function getDataProvider()
    {
        return new ArrayDataProvider([
            'allModels' => $this->permissionManager->createPermissionArray($this->groupId, $this->hideFixedPermissions),
            'sort' => [
                'attributes' => ['title', 'description', 'moduleId'],
            ],
        ]);
    }

}
