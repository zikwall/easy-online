<?php

/**
 * @link https://www.encore.org/
 * @copyright Copyright (c) 2015 encore GmbH & Co. KG
 * @license https://www.encore.com/licences
 */

namespace zikwall\easyonline\modules\user\models\fieldtype;

use zikwall\easyonline\modules\user\models\User;
use Yii;
use zikwall\easyonline\libs\Iso3166Codes;

/**
 * ProfileFieldTypeSelect handles numeric profile fields.
 *
 * @package encore.modules_core.user.models
 * @since 0.5
 */
class CountrySelect extends Select
{

    /**
     * Returns Form Definition for edit/create this field.
     *
     * @return array Form Definition
     */
    public function getFormDefinition($definition = array())
    {
        return parent::getFormDefinition(array(
                    get_class($this) => array(
                        'type' => 'form',
                        'title' => Yii::t('UserModule.models_ProfileFieldTypeSelect', 'Supported ISO3166 country codes'),
                        'elements' => array(
                            'options' => array(
                                'type' => 'textarea',
                                'label' => Yii::t('UserModule.models_ProfileFieldTypeSelect', 'Possible values'),
                                'class' => 'form-control',
                                'hint' => Yii::t('UserModule.models_ProfileFieldTypeSelect', 'Comma separated country codes, e.g. DE,EN,AU')
                            )
                        )
                    )
        ));
    }

    /**
     * Returns a list of possible options
     *
     * @return array
     */
    public function getSelectItems()
    {
        $items = [];

        // if no options set basically return a translated map of all defined countries
        if (empty($this->options) || trim($this->options) == false) {
            $items = iso3166Codes::$countries;
            foreach ($items as $code => $value) {
                $items[$code] = iso3166Codes::country($code);
            }
        } else {
            foreach (explode(",", $this->options) as $code) {

                $key = trim($code);
                $value = iso3166Codes::country($key, true);
                if (!empty($key) && $key !== $value) {
                    $items[trim($key)] = trim($value);
                }
            }
        }

        // Sort countries list based on user language   
        $col = new \Collator(Yii::$app->language);
        $col->asort($items);

        return $items;
    }

    /**
     * Returns value of option
     *
     * @param User $user            
     * @param Boolean $raw
     *            Output Key
     * @return String
     */
    public function getUserValue($user, $raw = true)
    {
        $internalName = $this->profileField->internal_name;
        $value = $user->profile->$internalName;

        if (!$raw) {
            return \yii\helpers\Html::encode(iso3166Codes::country($value));
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function getFieldFormDefinition()
    {
        $definition = parent::getFieldFormDefinition();
        $definition[$this->profileField->internal_name]['htmlOptions'] = ['data-ui-select2' => true];
        return $definition;
    }

}
