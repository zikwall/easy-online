<?php



namespace zikwall\easyonline\modules\community\widgets;

use Yii;
use \yii\base\Widget;
use \zikwall\easyonline\modules\community\models\Community;

/**
 * Picker displays a community picker instead of an input field.
 *
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * 
 * echo zikwall\easyonline\modules\community\widgets\Picker::widget([
 *    'inputId' => 'community_filter',
 *    'value' => $communityGuidsString,
 *    'maxCommunitys' => 3
 * ]);
 *  
 * </pre>
 *
 * @since 0.5
 * @deprecated since version 1.2 use CommunityPickerField instead
 * @author Luke
 */
class Picker extends Widget
{
    /**
     * @var string The id of input element which should replaced
     */
    public $inputId = "";

    /**
     * JSON Search URL - default: /community/browse/search-json
     * The token -keywordPlaceholder- will replaced by the current search query.
     *
     * @var string the search url
     */
    public $communitySearchUrl = "";

    /**
     * @var int the maximum of communitys
     */
    public $maxCommunitys = 10;

    /**
     * @var \yii\base\Model the data model associated with this widget. (Optional)
     */
    public $model = null;

    /**
     * The name can contain square brackets (e.g. 'name[1]') which is used to collect tabular data input.
     * @var string the attribute associated with this widget. (Optional)
     */
    public $attribute = null;

    /**
     * @var string the initial value of comma separated community guids
     */
    public $value = "";

    /**
     * @var string placeholder message, when no community is set
     */
    public $placeholder = null;

    /**
     * Displays / Run the Widgets
     */
    public function run()
    {
        // Try to get current field value, when model & attribute attributes are specified.
        if ($this->model != null && $this->attribute != null) {
            $attribute = $this->attribute;
            $this->value = $this->model->$attribute;
        }

        if ($this->communitySearchUrl == "")
            $this->communitySearchUrl = \yii\helpers\Url::to(['/community/browse/search-json', 'keyword' => '-keywordPlaceholder-']);

        if ($this->placeholder === null) {
            $this->placeholder = Yii::t('CommunityModule.picker', 'Add {n,plural,=1{community} other{communitys}}', ['n' => $this->maxCommunitys]);
        }

        // Currently populated communitys
        $communitys = [];
        foreach (explode(",", $this->value) as $guid) {
            $community = Community::findOne(['guid' => trim($guid)]);
            if ($community != null) {
                $communitys[] = $community;
            }
        }

        return $this->render('communityPicker', array(
                    'communitySearchUrl' => $this->communitySearchUrl,
                    'maxCommunitys' => $this->maxCommunitys,
                    'value' => $this->value,
                    'communitys' => $communitys,
                    'placeholder' => $this->placeholder,
                    'inputId' => $this->inputId,
        ));
    }

}

?>
