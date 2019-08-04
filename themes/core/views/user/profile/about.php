<?php

use yii\helpers\Html;
use zikwall\easyonline\modules\core\widgets\RichText;
use zikwall\easyonline\modules\user\models\fieldtype\MarkdownEditor;
use \zikwall\easyonline\modules\core\widgets\MarkdownView;
?>

<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UserModule.views_profile_about', '<strong>About</strong> this user'); ?>
        </div>
    </div>
    <h2 class="page_block_h2 page_info_header_tabs">
        <ul class="ui_tabs clear_fix page_info_tabs">
            <?php $firstClass = 'ui_tab_sel'; foreach ($user->profile->getProfileFieldCategories() as $category): ?>
                <div class="ui_tab <?= $firstClass; ?>" role="link">
                    <a href="#profile-category-<?= $category->id; ?>" data-toggle="tab">
                        <?= Html::encode(Yii::t($category->getTranslationCategory(), $category->title)); ?>
                    </a>
                </div>
            <?php $firstClass = ''; endforeach; ?>
            <div class="ui_tabs_slider _ui_tabs_slider"></div>
        </ul>
    </h2>
    <div class="page_info_wrap">
        <?php $firstClass = "active"; ?>
        <div class="tab-content">
            <?php foreach ($user->profile->getProfileFieldCategories() as $category): ?>
                <div class="tab-pane <?php
                echo $firstClass;
                $firstClass = "";
                ?>" id="profile-category-<?= $category->id; ?>">
                    <form class="form-horizontal" role="form">
                        <?php foreach ($user->profile->getProfileFields($category) as $field) : ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    <?= Html::encode(Yii::t($field->getTranslationCategory(), $field->title)); ?>
                                </label>
                                <?php if (strtolower($field->title) == 'about'): ?>
                                    <div class="col-sm-9">
                                        <p class="form-control-static"><?= RichText::widget(['text' => $field->getUserValue($user, true)]); ?></p>
                                    </div>
                                <?php else: ?>
                                    <div class="col-sm-9">
                                        <?php if ($field->field_type_class == MarkdownEditor::class): ?>
                                            <p class="form-control-static" style="min-height: 0 !important;padding-top:0;">
                                                <?= MarkdownView::widget(['markdown' => $field->getUserValue($user, false)]); ?>
                                            </p>
                                        <?php else: ?>
                                            <p class="form-control-static"><?= $field->getUserValue($user, false); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php for($i = 0; $i <= 80; $i++): ?>
    <div class="page_block">
        <div class="page_info_wrap">
            text text text
        </div>
    </div>
<?php endfor; ?>

