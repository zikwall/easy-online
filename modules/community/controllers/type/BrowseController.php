<?php

namespace zikwall\easyonline\modules\community\controllers\type;

use Yii;
use yii\helpers\Html;

class BrowseController extends \zikwall\easyonline\modules\community\controllers\BrowseController
{
    protected function prepareResult($searchResultSet)
    {
        $target = Yii::$app->request->get('target');
        
        $json = [];
        $withChooserItem = ($target === 'chooser');
        foreach ($searchResultSet->getResultInstances() as $space) {
            $json[] = $this->getSpaceResult($space, $withChooserItem);
        }

        return $json;
    }
    
    public function getSpaceResult($space, $withChooserItem = true, $options = [])
    {
        $spaceInfo = [];
        $spaceInfo['guid'] = $space->guid;
        $spaceInfo['title'] = Html::encode($space->name);
        $spaceInfo['tags'] = Html::encode($space->tags);
        $spaceInfo['image'] = Image::widget(['space' => $space, 'width' => 24]);
        $spaceInfo['link'] = $space->getUrl();

        if ($withChooserItem) {
            $options = array_merge(['space' => $space, 'isMember' => false, 'isFollowing' => false], $options);
            $spaceInfo['output'] = \humhub\modules\enterprise\modules\spacetype\widgets\SpaceChooserItem::widget($options);
        }

        return $spaceInfo;
    }
    

}
