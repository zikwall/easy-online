<?php

use yii\helpers\Html;

/**
 * @var \zikwall\easyonline\modules\user\models\User $contentContainer
 * @var $this zikwall\easyonline\components\View
 * @var $model \zikwall\easyonline\modules\university\models\University
 */

?>


<div class="help-block">
    На данной странице Вы сможете просмотреть всю информацию об университете, указанной главным в системе, узнать адреса и просмотреть список факультетов
</div>
<div class="panel-body">
    <div data-toggle="tooltip" title="Полное наименование">
        <span class="label label-default"><i class="fa fa-exclamation fa-fw" aria-hidden="true"></i></span>
        <span class="label label-default">Полное наименование: </span>
        <span class="label label-primary"><?= $model->fullname ?></span>
    </div>

    <div data-toggle="tooltip" title="Короткое наименование">
        <span class="label label-default"><i class="fa fa-calendar-check-o fa-fw" aria-hidden="true"></i></span>
        <span class="label label-default">Короткое наименование: </span>
        <span class="label label-primary"><?= $model->shortname; ?></span>
    </div>
    <hr>
</div>

<p class="panel-heading">
    <?= Yii::t('UniversityModule.base', 'Факультеты');?>

    <?= Yii::t('UniversityModule.base', '{n, plural, one{found # faculty} few{found # faculties} many{found # faculties} other{found # faculties}}', ['n' => count($model->faculties)]); ?>
    <?php if ($model->faculties): ?>
        <a class="dropdown-toggle"
           title="<?= Yii::t('UniversityModule.base', 'Expand the list of faculties'); ?>"
           onclick="$('#viewfaculties').slideToggle('fast');$('#viewfaculties').focus();return false;"
           data-toggle="dropdown" href="#"
           aria-label="<?= Yii::t('UniversityModule.base', 'Expand the list of faculties'); ?>
                       aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-angle-down fa-fw"></i>
        </a>
</p>
<div id="viewfaculties" style="display: none;">
    <ul class="tour-list">
        <?php foreach ($model->faculties as $faculties): ?>
            <li id="interface_entry" class="">
                <?= Html::a('<i class="fa fa-chevron-right"></i> '.$faculties->fullname, ['/faculties/public/view-ajax', 'id' => $faculties->id], ['class' => '', 'data-target' => '#globalModal']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>





