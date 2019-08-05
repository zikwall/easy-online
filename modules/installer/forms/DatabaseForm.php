<?php

namespace zikwall\easyonline\modules\installer\forms;

use Yii;

class DatabaseForm extends \yii\base\Model
{

    /**
     * @var string hostname
     */
    public $hostname;

    /**
     * @var string username
     */
    public $username;

    /**
     * @var string password
     */
    public $password;

    /**
     * @var string database name
     */
    public $database;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hostname', 'username', 'database'], 'required'],
            ['password', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hostname' => Yii::t('InstallerModule.forms_DatabaseForm', 'Hostname'),
            'username' => Yii::t('InstallerModule.forms_DatabaseForm', 'Username'),
            'password' => Yii::t('InstallerModule.forms_DatabaseForm', 'Password'),
            'database' => Yii::t('InstallerModule.forms_DatabaseForm', 'Name of Database'),
        ];
    }

}
