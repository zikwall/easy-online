
<?php $this->beginContent('@easyonline/modules/schedule/views/layouts/_advancedLayout.php') ?>

<?php

use yii\helpers\Html;
use \zikwall\easyonline\modules\core\widgets\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel zikwall\easyonline\modules\schedule\models\search\ScheduleAviableDay */
/* @var $dataProvider yii\data\ActiveDataProvider */
/**
 * @var \zikwall\easyonline\modules\faculties\models\UniversityFaculties $model
 */
?>
<?php $this->beginContent('@easyonline/modules/schedule/views/layouts/_advancedLayout.php') ?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_inner _header_inner">
        <?= Yii::t('AdminModule.user', 'Overview'); ?>
    </div>
</div>

<div class="page_info_wrap">
    <?php foreach ($model as $faculty): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= $faculty->fullname; ?>
                <div class="pull-right">
                    <?= Html::a('Перейти к заполнению расписания для '.$faculty->shortname, [
                        '/schedule/admin/course-schedule',
                        'faculty' => $faculty->id,
                    ], ['class' => 'flat_button button_wide secondary']
                    )?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?= ($pagination != null) ? \zikwall\easyonline\modules\core\widgets\LinkPager::widget(['pagination' => $pagination]) : ''; ?>

<?php $this->endContent(); ?>
