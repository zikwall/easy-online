<?php



namespace zikwall\easyonline\modules\community\widgets;

use \yii\base\Widget;
use yii\bootstrap\Html;

/**
 * Return community image or acronym
 */
class Image extends Widget
{

    /**
     * @var \zikwall\easyonline\modules\community\models\Community
     */
    public $community;

    /**
     * @var int number of characters used in the acronym
     */
    public $acronymCount = 2;

    /**
     * @var int the width of the image
     */
    public $width = 50;

    /**
     * @var int the height of the image
     */
    public $height = null;

    /**
     * @var array html options for the generated tag
     */
    public $htmlOptions = [];

    /**
     * @var boolean create link to the community
     */
    public $link = false;

    /**
     * @var array Html Options of the link
     */
    public $linkOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->height === null) {
            $this->height = $this->width;
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {

        if (!isset($this->linkOptions['href'])) {
            $this->linkOptions['href'] = $this->community->getUrl();
        }

        if ($this->community->color != null) {
            $color = Html::encode($this->community->color);
            ;
        } else {
            $color = '#d7d7d7';
        }

        if (!isset($this->htmlOptions['class'])) {
            $this->htmlOptions['class'] = "";
        }

        if (!isset($this->htmlOptions['style'])) {
            $this->htmlOptions['style'] = "";
        }

        $acronymHtmlOptions = $this->htmlOptions;
        $imageHtmlOptions = $this->htmlOptions;



        $acronymHtmlOptions['class'] .= " community-profile-acronym-" . $this->community->id . " community-acronym";
        $acronymHtmlOptions['style'] .= " background-color: " . $color . "; width: " . $this->width . "px; height: " . $this->height . "px;";
        $acronymHtmlOptions['style'] .= " " . $this->getDynamicStyles($this->width);

        $imageHtmlOptions['class'] .= " community-profile-image-" . $this->community->id . " img-rounded profile-user-photo";
        $imageHtmlOptions['style'] .= " width: " . $this->width . "px; height: " . $this->height . "px";
        $imageHtmlOptions['alt'] = Html::encode($this->community->name);

        //$defaultImage = (basename($this->community->getProfileImage()->getUrl()) == 'default_community.jpg' || basename($this->community->getProfileImage()->getUrl()) == 'default_community.jpg?cacheId=0') ? true : false;

        if (!$defaultImage) {
            $acronymHtmlOptions['class'] .= " hidden";
        } else {
            $imageHtmlOptions['class'] .= " hidden";
        }

        return $this->render('image', [
                    'community' => $this->community,
                    'acronym' => $this->getAcronym(),
                    'link' => $this->link,
                    'linkOptions' => $this->linkOptions,
                    'acronymHtmlOptions' => $acronymHtmlOptions,
                    'imageHtmlOptions' => $imageHtmlOptions,
        ]);
    }

    protected function getAcronym()
    {
        $acronym = "";

        foreach (explode(" ", $this->community->name) as $w) {
            if (mb_strlen($w) >= 1) {
                $acronym .= mb_substr($w, 0, 1);
            }
        }

        return mb_substr(mb_strtoupper($acronym), 0, $this->acronymCount);
    }

    protected function getDynamicStyles($elementWidth)
    {

        $fontSize = 44 * $elementWidth / 100;
        $padding = 18 * $elementWidth / 100;
        $borderRadius = 4;

        if ($elementWidth < 140 && $elementWidth > 40) {
            $borderRadius = 3;
        }

        if ($elementWidth < 35) {
            $borderRadius = 2;
        }

        return "font-size: " . $fontSize . "px; padding: " . $padding . "px 0; border-radius: " . $borderRadius . "px;";
    }

}

?>
