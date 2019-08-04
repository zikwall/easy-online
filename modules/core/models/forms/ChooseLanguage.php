<?php

namespace zikwall\easyonline\modules\core\models\forms;

use Yii;
use yii\base\Model;

class ChooseLanguage extends Model
{
    /**
     * @var string
     */
    public $language;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['language', 'in', 'range' => array_keys(Yii::$app->i18n->getAllowedLanguages())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array(
            'language' => Yii::t('base', 'Language'),
        );
    }

    /**
     * Сохраняет язык в cookie
     * @return boolean
     */
    public function save()
    {
        if ($this->validate()) {
            $cookie = new \yii\web\Cookie([
                'name' => 'language',
                'value' => $this->language,
                'expire' => time() + 86400 * 365,
            ]);
            Yii::$app->getResponse()->getCookies()->add($cookie);

            return true;
        }

        return false;
    }

    public function getSavedLanguage()
    {
        if (isset(Yii::$app->request->cookies['language'])) {
            $this->language = (string) Yii::$app->request->cookies['language'];

            if (!$this->validate()) {
                $cookie = new \yii\web\Cookie([
                    'name' => 'language',
                    'value' => 'en',
                    'expire' => 1,
                ]);
                Yii::$app->getResponse()->getCookies()->add($cookie);
            } else {
                return $this->language;
            }
        }

        return null;
    }

}
