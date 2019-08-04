<?php

use yii\db\Query;
use zikwall\easyonline\modules\core\components\db\Migration;

class m160509_214811_communityurl extends Migration
{

    public function up()
    {
        return true;
        
        if (!class_exists('URLify')) {
            throw new Exception('URLify class not found - please run composer update!');
        }

        $this->addColumn('community', 'url', $this->string(45));
        $this->createIndex('url-unique', 'community', 'url', true);

        $rows = (new Query())
                ->select("*")
                ->from('community')
                ->all();
        foreach ($rows as $row) {
            $url = \zikwall\easyonline\modules\community\components\UrlValidator::autogenerateUniqueCommunityUrl($row['name']);
            $this->updateSilent('community', ['url' => $url], ['id' => $row['id']]);
        }
    }

    public function down()
    {
        echo "m160509_214811_communityurl cannot be reverted.\n";

        return false;
    }
}
