<?php



namespace zikwall\easyonline\modules\community\widgets;

/**
 * ListBox returns the content of the community list modal
 * 
 * Example Action:
 * 
 * ```php
 * public actionCommunityList() {
 *       $query = Community::find();
 *       $query->where(...);
 *        
 *       $title = "Some Communitys";
 *  
 *       return $this->renderAjaxContent(ListBox::widget(['query' => $query, 'title' => $title]));
 * }
 * ```
 * 
 * @since 1.1
 * @author luke
 */
class ListBox extends \yii\base\Widget
{

    /**
     * @var \yii\db\ActiveQuery
     */
    public $query;

    /**
     * @var string title of the box (not html encoded!)
     */
    public $title = 'Communitys';

    /**
     * @var int displayed users per page
     */
    public $pageSize = 25;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $countQuery = clone $this->query;
        $pagination = new \yii\data\Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $this->pageSize]);
        $this->query->offset($pagination->offset)->limit($pagination->limit);

        return $this->render("listBox", [
                    'title' => $this->title,
                    'communitys' => $this->query->all(),
                    'pagination' => $pagination
        ]);
    }

}
