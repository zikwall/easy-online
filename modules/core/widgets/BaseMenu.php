<?php

namespace zikwall\easyonline\modules\core\widgets;

use Yii;
use yii\helpers\Url;

/**
 * BaseMenu is the base class for navigations.
 */
class BaseMenu extends \yii\base\Widget
{
    const EVENT_INIT = 'init';
    const EVENT_RUN = 'run';

    /**
     *
     * @var array
     */
    public $items = [];

    /**
     *
     * @var array
     */
    public $itemGroups = [];

    /**
     *
     * @var string тип навигации, необязательный для идентификации.
     */
    public $type = "";

    /**
     * @var string идентификатор элемента dom
     */
    public $id;

    /**
     * Шаблон навигации
     *
     * Доступные шаблоны по умолчанию:
     * - leftNavigation
     * - tabMenu
     *
     * @var string
     */
    public $template;

    /**
     * @var bool 
     */
    public $outerWrapper = false;

    /**
     * @var array 
     */
    public $outerWrapperOptions = [
        'id' => false, 'class' => false
    ];

    /**
     * @var bool
     */
    public $useOwnblock = false;

    /**
     * @var array
     */
    public $advancedParams = [];

    /**
     * @var array
     */
    public $subItems = [];

    public $enableIcons = true;

    public function init()
    {
        $this->addItemGroup([
            'id' => '',
            'label' => ''
        ]);

        // Yii 2.0.11 представил собственное событие init
        if (version_compare(Yii::getVersion(), '2.0.11', '<')) {
            $this->trigger(self::EVENT_INIT);
        }

        return parent::init();
    }

    public function run()
    {
        $this->trigger(self::EVENT_RUN);

        $this->addSubItems();

        if (empty($this->template)) {
            return;
        }

        return $this->render($this->template, [
            'outerWrapper' => $this->outerWrapper,
            'outerWrapperOptions' => $this->outerWrapperOptions,
            'useOwnblock' => $this->useOwnblock,
            'advanced' => $this->advancedParams
        ]);
    }

    /**
     * @param array $addItem
     * @return array
     */
    public function add(array $addItem) : array
    {
        // i think naher eto
    }

    /**
     * @param array $item
     */
    public function addItem(array $item) : void
    {
        if (!isset($item['label'])) {
            $item['label'] = 'Unnamed';
        }

        if (!isset($item['url'])) {
            $item['url'] = '#';
        }

        if (!isset($item['icon'])) {
            $item['icon'] = '';
        }

        if (!$this->enableIcons) {
            $item['icon'] = '';
        }

        if (!isset($item['group'])) {
            $item['group'] = '';
        }

        if (!isset($item['htmlOptions'])) {
            $item['htmlOptions'] = [];
        }

        if (!isset($item['pjax'])) {
            $item['pjax'] = true;
        }

        if (isset($item['target'])) {
            $item['htmlOptions']['target'] = $item['target'];
        }

        if (!isset($item['sortOrder'])) {
            $item['sortOrder'] = 1000;
        }

        if (!isset($item['newItemCount'])) {
            $item['newItemCount'] = 0;
        }

        if (!isset($item['isActive'])) {
            $item['isActive'] = false;
        }
        if (isset($item['isVisible']) && !$item['isVisible']) {
            return;
        }

        if (!isset($item['htmlOptions']['class'])) {
            $item['htmlOptions']['class'] = "";
        }

        if ($item['isActive']) {
            $item['htmlOptions']['class'] .= "active";
        }
        
        if (isset($item['id'])) {
            $item['htmlOptions']['class'] .= " " . $item['id'];
        }

        if (!isset($item['isOwnblock'])) {
            $item['isOwnblock'] = false;
        }

        if (isset($item['identity'])) {
            $this->items[$item['identity']] = $item;
        } else {
            $this->items[] = $item;
        }
    }

    /**
     * @param array $itemGroup
     */
    public function addItemGroup(array $itemGroup) : void
    {
        if (!isset($itemGroup['id']))
            $itemGroup['id'] = 'default';

        if (!isset($itemGroup['label']))
            $itemGroup['label'] = 'Unnamed';

        if (!isset($itemGroup['icon'])) {
            $itemGroup['icon'] = '';
        }

        if (!$this->enableIcons) {
            $itemGroup['icon'] = '';
        }

        if (!isset($itemGroup['sortOrder']))
            $itemGroup['sortOrder'] = 1000;

        if (isset($itemGroup['isVisible']) && !$itemGroup['isVisible'])
            return;

        $this->itemGroups[] = $itemGroup;
    }

    /**
     * @param string $group
     * @return array
     */
    public function getItems(string $group = null) : array
    {
        $this->sortItems();

        $ret = [];

        foreach ($this->items as $item) {
            if ($group == $item['group']) $ret[] = $item;
        }

        return $ret;
    }

    private function sortItems() : void
    {
        usort($this->items, [$this, 'getSortableItems']);
    }

    private function sortItemGroups() : void
    {
        usort($this->itemGroups, [$this, 'getSortableItems']);
    }

    private function getSortableItems($a, $b)
    {
        if ($a['sortOrder'] == $b['sortOrder']) {
            return 0;
        }

        return ($a['sortOrder'] < $b['sortOrder']) ? -1 : 1;
    }

    /**
     * @return array
     */
    public function getItemGroups() : array
    {
        $this->sortItemGroups();
        return $this->itemGroups;
    }

    /**
     * @param string $itemIdentity
     * @param array $subItem
     */
    public function addSubItem(string $itemIdentity, array $subItem) : void
    {
        if (!isset($subItem['label'])) {
            $subItem['label'] = 'Unnamed';
        }

        if (!isset($subItem['url'])) {
            $subItem['url'] = '#';
        }

        if (!isset($subItem['group'])) {
            $subItem['group'] = '';
        }

        if (!isset($subItem['htmlOptions'])) {
            $subItem['htmlOptions'] = [];
        }

        if (!isset($subItem['sortOrder'])) {
            $subItem['sortOrder'] = 1000;
        }

        $this->subItems[$itemIdentity][] = $subItem;
    }

    /**
     * @return bool
     */
    public function addSubItems() : bool
    {
        if (empty($this->subItems)) {
            return false;
        }

        foreach ($this->subItems as $identity => $subItems) {
            usort($subItems, [$this, 'getSortableItems']);

            foreach ($subItems as $subItem) {
                if (!isset($this->items[$identity]['subItems'])) {
                    $this->items[$identity]['subItems'] = [];
                }

                if (isset($this->items[$identity])) {
                    $this->items[$identity]['subItems'][] = $subItem;
                }
            }
        }

        return true;
    }

    /**
     * @param string $url
     */
    public function setActive(string $url) : void
    {
        foreach ($this->items as $key => $item) {
            if ($item['url'] == $url) {
                $this->items[$key]['htmlOptions']['class'] = 'active';
                $this->items[$key]['isActive'] = true;
                $this->view->registerJs('encore.modules.ui.navigation.setActive("' . $this->id . '", ' . json_encode($this->items[$key]) . ');', \yii\web\View::POS_END, 'active-' . $this->id);
            }
        }
    }

    /**
     * @return array
     */
    public function getActive() : array
    {
        foreach ($this->items as $item) {
            if ($item['isActive']) {
                return $item;
            }
        }
    }

    /**
     * @param string $url
     */
    public function setInactive(string $url) : void
    {
        foreach ($this->items as $key => $item) {
            if ($item['url'] == $url) {
                $this->items[$key]['htmlOptions']['class'] = '';
                $this->items[$key]['isActive'] = false;
            }
        }
    }

    /**
     * @param array $url
     */
    public static function markAsActive(array $url) : void
    {
        if (is_array($url)) {
            $url = Url::to($url);
        }

        \yii\base\Event::on(static::class, static::EVENT_RUN, function($event) use ($url) {
            $event->sender->setActive($url);
        });
    }

    public static function setViewState() : void
    {
        $instance = new static();
        if (!empty($instance->id)) {
            $active = $instance->getActive();
            $instance->view->registerJs('encore.modules.ui.navigation.setActive("' . $instance->id . '", ' . json_encode($active) . ');', \yii\web\View::POS_END, 'active-' . $instance->id);
        }
    }

    /**
     * @param string $url
     */
    public static function markAsInactive(string $url) : void
    {
        if (is_array($url)) {
            $url = Url::to($url);
        }

        \yii\base\Event::on(static::class, static::EVENT_RUN, function($event) use ($url) {
            $event->sender->setInactive($url);
        });
    }

    /**
     * @param string $url
     */
    public function deleteItemByUrl(string $url) : void
    {
        foreach ($this->items as $key => $item) {
            if ($item['url'] == $url) {
                unset($this->items[$key]);
            }
        }
    }
}

?>
