<?php

namespace zikwall\easyonline\modules\community\widgets;

use Yii;
use yii\base\Exception;
use zikwall\easyonline\modules\content\components\ContentContainerController;
use zikwall\easyonline\modules\community\models\Community;
use zikwall\easyonline\modules\core\widgets\BaseMenu;

class Menu extends BaseMenu
{
    /** @var Community */
    public $community;
    public $template = "@ui/widgets/views/leftNavigation";

    public function init()
    {
        if ($this->community === null && Yii::$app->controller instanceof ContentContainerController && Yii::$app->controller->contentContainer instanceof Community) {
            $this->community = Yii::$app->controller->contentContainer;
        }

        if ($this->community === null) {
            throw new Exception("Could not instance community menu without community!");
        }
        
        $this->id = 'navigation-menu-community-' . $this->community->getUniqueId();

        $this->addItemGroup([
            'id' => 'modules',
            'label' => Yii::t('CommunityModule.widgets_CommunityMenuWidget', '<strong>Community</strong> menu'),
            'sortOrder' => 100,
        ]);

        $this->addItem([
            'label' => Yii::t('CommunityModule.widgets_CommunityMenuWidget', 'Stream'),
            'group' => 'modules',
            'url' => $this->community->createUrl('/community/community/home'),
            //'icon' => '<i class="fa fa-bars"></i>',
            'sortOrder' => 100,
            'isActive' => (Yii::$app->controller->id == 'community' && (Yii::$app->controller->action->id == 'index' || Yii::$app->controller->action->id == 'home') && Yii::$app->controller->module->id == 'community'),
        ]);

        parent::init();
    }

    /**
     * Searches for urls of modules which are activated for the current community
     * and offer an own site over the community menu.
     * The urls are associated with a module label.
     * 
     * Returns an array of urls with associated module labes for modules 
     * @param type $community
     */
    public static function getAvailablePages()
    {
        //Initialize the community Menu to check which active modules have an own page
        $moduleItems = (new static())->getItems('modules');
        $result = [];
        foreach ($moduleItems as $moduleItem) {
            $result[$moduleItem['url']] = $moduleItem['label'];
        }

        return $result;
    }

    /**
     * Returns community default / homepage
     * 
     * @return string|null the url to redirect or null for default home
     */
    public static function getDefaultPageUrl($community)
    {
        $settings = Yii::$app->getModule('community')->settings;

        $indexUrl = $settings->contentContainer($community)->get('indexUrl');
        if ($indexUrl !== null) {
            $pages = static::getAvailablePages();
            if (isset($pages[$indexUrl])) {
                return $indexUrl;
            } else {
                //Either the module was deactivated or url changed
                $settings->contentContainer($community)->delete('indexUrl');
            }
        }

        return null;
    }

    /**
     * Returns community default / homepage
     * 
     * @return string|null the url to redirect or null for default home
     */
    public static function getGuestsDefaultPageUrl($community)
    {
        $settings = Yii::$app->getModule('community')->settings;

        $indexUrl = $settings->contentContainer($community)->get('indexGuestUrl');
        if ($indexUrl !== null) {
            $pages = static::getAvailablePages();
            if (isset($pages[$indexUrl])) {
                return $indexUrl;
            } else {
                //Either the module was deactivated or url changed
                $settings->contentContainer($community)->delete('indexGuestUrl');
            }
        }

        return null;
    }

}
