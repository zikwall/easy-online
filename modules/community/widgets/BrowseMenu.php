<?php

namespace zikwall\easyonline\modules\community\widgets;

use Yii;

class BrowseMenu extends MenuWidget
{
    public $template = "application.widgets.views.leftNavigation";

    public function init()
    {

        $this->addItemGroup(array(
            'id' => 'browse',
            'label' => Yii::t('CommunityModule.widgets_CommunityBrowseMenuWidget', 'Communitys'),
            'sortOrder' => 100,
        ));


        $this->addItem(array(
            'label' => Yii::t('CommunityModule.widgets_CommunityBrowseMenuWidget', 'My Community List'),
            'url' => Yii::app()->createUrl('//community/browse', array()),
            'sortOrder' => 100,
            'isActive' => (Yii::app()->controller->id == "communitybrowse" && Yii::app()->controller->action->id == "index"),
        ));

        $this->addItem(array(
            'label' => Yii::t('CommunityModule.widgets_CommunityBrowseMenuWidget', 'My community summary'),
            'url' => Yii::app()->createUrl('//dashboard', array()),
            'sortOrder' => 100,
            'isActive' => (Yii::app()->controller->id == "communitybrowse" && Yii::app()->controller->action->id == "index"),
        ));


        $this->addItem(array(
            'label' => Yii::t('CommunityModule.widgets_CommunityBrowseMenuWidget', 'Community directory'),
            'url' => Yii::app()->createUrl('//community/workcommunitys', array()),
            'sortOrder' => 200,
            'isActive' => (Yii::app()->controller->id == "communitybrowse" && Yii::app()->controller->action->id == "index"),
        ));


        parent::init();
    }

}

?>
