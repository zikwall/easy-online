<?php

use zikwall\easyonline\modules\core\libs\Html;
use yii\helpers\Url;
use zikwall\easyonline\modules\user\models\ProfileFieldCategory;
?>

<div class="page_block_header clear_fix">
    <div class="page_block_header_extra _header_extra">
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . Yii::t('AdminModule.views_userprofile_index', 'Add new category'), Url::to(['edit-category']), ['class' => 'btn btn-success']); ?>
            <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;' . Yii::t('AdminModule.views_userprofile_index', 'Add new field'), Url::to(['edit-field']), ['class' => 'btn btn-success']); ?>
        </div>
    </div>

    <div class="page_block_header_inner _header_inner">
        <?= Yii::t('AdminModule.views_userprofile_index', 'Manage profile attributes'); ?>
    </div>
</div>

<div class="encore-help-block">
    <?= Yii::t('AdminModule.views_userprofile_index', 'Here you can create or edit profile categories and fields.'); ?>
</div>

<div class="page_info_wrap">

    <style>
        ul.tree, ul.tree ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        ul.tree ul {
            margin-left: 10px;
        }
        ul.tree li {
            margin: 0;
            padding: 0 7px;
            line-height: 20px;
            color: #369;
            font-weight: bold;
            border-left:1px solid rgb(100,100,100);

        }
        ul.tree li:last-child {
            border-left:none;
        }
        ul.tree li:before {
            position:relative;
            top:-0.3em;
            height:1em;
            width:12px;
            color:white;
            border-bottom:1px solid rgb(100,100,100);
            content:"";
            display:inline-block;
            left:-7px;
        }
        ul.tree li:last-child:before {
            border-left:1px solid rgb(100,100,100);
        }
    </style>

    <ul>
        <ul class="tree">
            <?php foreach (ProfileFieldCategory::find()->orderBy('sort_order')->all() as $category): ?>

            <li>
                <a href="<?= Url::to(['edit-category', 'id' => $category->id]); ?>"><strong><?= Html::encode($category->title); ?></strong></a>
                <ul>
                    <?php foreach ($category->fields as $field) : ?>
                        <li data-id="<?= $field->id ?>">
                            <a href="<?= Url::to(['edit-field', 'id' => $field->id]); ?>"><?= Html::encode($field->title); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <?php endforeach; ?>
        </ul>
    </ul>
</div>
