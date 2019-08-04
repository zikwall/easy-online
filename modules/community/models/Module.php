<?php



namespace zikwall\easyonline\modules\community\models;

use Yii;

/**
 * This is the model class for table "community_module".
 *
 * @property integer $id
 * @property string $module_id
 * @property integer $community_id
 * @property integer $state
 */
class Module extends \yii\db\ActiveRecord
{

    private static $_states = array();

    const STATE_DISABLED = 0;
    const STATE_ENABLED = 1;
    const STATE_FORCE_ENABLED = 2;
    const STATES_CACHE_ID_PREFIX = 'community_module_states_';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'community_module';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module_id'], 'required'],
            [['community_id', 'state'], 'integer'],
            [['module_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'community_id' => 'Community ID',
            'state' => 'State',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        Yii::$app->cache->delete(self::STATES_CACHE_ID_PREFIX . $this->community_id);
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        Yii::$app->cache->delete(self::STATES_CACHE_ID_PREFIX . $this->community_id);

        return parent::beforeDelete();
    }

    /**
     * Returns an array of moduleId and the their states (enabled, disabled, force enabled)
     * for given community id. If community id is 0 or empty, the default states will be returned.
     *
     * @param int|null $communityId the community id or null for the default state
     * @return array State of Module Ids
     */
    public static function getStates($communityId = null)
    {

        // Used already cached values
        if (isset(self::$_states[$communityId])) {
            return self::$_states[$communityId];
        }

        $states = Yii::$app->cache->get(self::STATES_CACHE_ID_PREFIX . $communityId);
        if ($states === false) {

            $states = [];

            $query = self::find();

            if (empty($communityId)) {
                $query->andWhere(['IS', 'community_id', new \yii\db\Expression('NULL')]);
            } else {
                $query->andWhere(['community_id' => $communityId]);
            }

            foreach ($query->all() as $communityModule) {
                $states[$communityModule->module_id] = $communityModule->state;
            }

            Yii::$app->cache->set(self::STATES_CACHE_ID_PREFIX . $communityId, $states);
        }
        self::$_states[$communityId] = $states;

        return self::$_states[$communityId];
    }

    /**
     * Returns community relation
     *
     * @return ActiveQuery the relation query
     */
    public function getCommunity()
    {
        return $this->hasOne(Community::class, ['id' => 'community_id']);
    }

}
