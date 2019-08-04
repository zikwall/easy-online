<?php \zikwall\easyonline\modules\university\assets\UniversityAsset::register($this);
/**
 * @var \zikwall\easyonline\modules\university\models\UniversityEgeSubject $model
 */

?>

<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UniversityModule.base','<strong>Калькулятор</strong> ЕГЭ' );?>
        </div>
    </div>
    <div class="page_info_wrap">
        <?= $text; ?>
        <p class="panel-heading">
            Оцените свои шансы!
        </p>
        <p class="help-block">
            Введите результаты ЕГЭ (реальные или предполагаемые) и оцените свои шансы на поступление в Чувашский государственный университет имени И.Н. Ульянова на очную форму обучения.
        </p>
        <br><hr>
        <form action="javascript::void();">
            <div class="row">
                <?php foreach($model as $subject):?>
                <div class="col-md-6">
                    <div class="form-group field-basicsettingsform-baseurl">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="basicsettingsform-baseurl"><?= $subject->name; ?></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="basicsettingsform-baseurl" class="form-control" name="BasicSettingsForm[baseUrl]" value="0" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="help-block"></div>
                    </div>
                    <p class="help-block">Минимальные баллы: <?= $subject->minpoint; ?></p>
                    <hr>
                </div>
                <?php if (($i+1)%4 == 0): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <br>
            <div class="col-md-3 form-inline">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Расчитать', ['class' => 'click btn btn-primary']) ?>
                </div>
            </div>
        </form>
        <div id="okey"></div>
    </div>
</div>
<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UniversityModule.base','<strong>Калькулятор</strong> ЕГЭ' );?>
        </div>
    </div>
    <div class="page_info_wrap">
        <?= $text; ?>
        <p class="panel-heading">
            Оцените свои шансы!
        </p>
        <p class="help-block">
            Введите результаты ЕГЭ (реальные или предполагаемые) и оцените свои шансы на поступление в Чувашский государственный университет имени И.Н. Ульянова на очную форму обучения.
        </p>
        <br><hr>
        <form action="javascript::void();">
            <div class="row">
                <?php foreach($model as $subject):?>
                <div class="col-md-6">
                    <div class="form-group field-basicsettingsform-baseurl">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="basicsettingsform-baseurl"><?= $subject->name; ?></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="basicsettingsform-baseurl" class="form-control" name="BasicSettingsForm[baseUrl]" value="0" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="help-block"></div>
                    </div>
                    <p class="help-block">Минимальные баллы: <?= $subject->minpoint; ?></p>
                    <hr>
                </div>
                <?php if (($i+1)%4 == 0): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <br>
            <div class="col-md-3 form-inline">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Расчитать', ['class' => 'click btn btn-primary']) ?>
                </div>
            </div>
        </form>
        <div id="okey"></div>
    </div>
</div>
<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UniversityModule.base','<strong>Калькулятор</strong> ЕГЭ' );?>
        </div>
    </div>
    <div class="page_info_wrap">
        <?= $text; ?>
        <p class="panel-heading">
            Оцените свои шансы!
        </p>
        <p class="help-block">
            Введите результаты ЕГЭ (реальные или предполагаемые) и оцените свои шансы на поступление в Чувашский государственный университет имени И.Н. Ульянова на очную форму обучения.
        </p>
        <br><hr>
        <form action="javascript::void();">
            <div class="row">
                <?php foreach($model as $subject):?>
                <div class="col-md-6">
                    <div class="form-group field-basicsettingsform-baseurl">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="basicsettingsform-baseurl"><?= $subject->name; ?></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="basicsettingsform-baseurl" class="form-control" name="BasicSettingsForm[baseUrl]" value="0" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="help-block"></div>
                    </div>
                    <p class="help-block">Минимальные баллы: <?= $subject->minpoint; ?></p>
                    <hr>
                </div>
                <?php if (($i+1)%4 == 0): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <br>
            <div class="col-md-3 form-inline">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Расчитать', ['class' => 'click btn btn-primary']) ?>
                </div>
            </div>
        </form>
        <div id="okey"></div>
    </div>
</div>
<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UniversityModule.base','<strong>Калькулятор</strong> ЕГЭ' );?>
        </div>
    </div>
    <div class="page_info_wrap">
        <?= $text; ?>
        <p class="panel-heading">
            Оцените свои шансы!
        </p>
        <p class="help-block">
            Введите результаты ЕГЭ (реальные или предполагаемые) и оцените свои шансы на поступление в Чувашский государственный университет имени И.Н. Ульянова на очную форму обучения.
        </p>
        <br><hr>
        <form action="javascript::void();">
            <div class="row">
                <?php foreach($model as $subject):?>
                <div class="col-md-6">
                    <div class="form-group field-basicsettingsform-baseurl">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="basicsettingsform-baseurl"><?= $subject->name; ?></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="basicsettingsform-baseurl" class="form-control" name="BasicSettingsForm[baseUrl]" value="0" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="help-block"></div>
                    </div>
                    <p class="help-block">Минимальные баллы: <?= $subject->minpoint; ?></p>
                    <hr>
                </div>
                <?php if (($i+1)%4 == 0): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <br>
            <div class="col-md-3 form-inline">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Расчитать', ['class' => 'click btn btn-primary']) ?>
                </div>
            </div>
        </form>
        <div id="okey"></div>
    </div>
</div>
<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UniversityModule.base','<strong>Калькулятор</strong> ЕГЭ' );?>
        </div>
    </div>
    <div class="page_info_wrap">
        <?= $text; ?>
        <p class="panel-heading">
            Оцените свои шансы!
        </p>
        <p class="help-block">
            Введите результаты ЕГЭ (реальные или предполагаемые) и оцените свои шансы на поступление в Чувашский государственный университет имени И.Н. Ульянова на очную форму обучения.
        </p>
        <br><hr>
        <form action="javascript::void();">
            <div class="row">
                <?php foreach($model as $subject):?>
                <div class="col-md-6">
                    <div class="form-group field-basicsettingsform-baseurl">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="basicsettingsform-baseurl"><?= $subject->name; ?></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="basicsettingsform-baseurl" class="form-control" name="BasicSettingsForm[baseUrl]" value="0" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="help-block"></div>
                    </div>
                    <p class="help-block">Минимальные баллы: <?= $subject->minpoint; ?></p>
                    <hr>
                </div>
                <?php if (($i+1)%4 == 0): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <br>
            <div class="col-md-3 form-inline">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Расчитать', ['class' => 'click btn btn-primary']) ?>
                </div>
            </div>
        </form>
        <div id="okey"></div>
    </div>
</div>
<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UniversityModule.base','<strong>Калькулятор</strong> ЕГЭ' );?>
        </div>
    </div>
    <div class="page_info_wrap">
        <?= $text; ?>
        <p class="panel-heading">
            Оцените свои шансы!
        </p>
        <p class="help-block">
            Введите результаты ЕГЭ (реальные или предполагаемые) и оцените свои шансы на поступление в Чувашский государственный университет имени И.Н. Ульянова на очную форму обучения.
        </p>
        <br><hr>
        <form action="javascript::void();">
            <div class="row">
                <?php foreach($model as $subject):?>
                <div class="col-md-6">
                    <div class="form-group field-basicsettingsform-baseurl">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="basicsettingsform-baseurl"><?= $subject->name; ?></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="basicsettingsform-baseurl" class="form-control" name="BasicSettingsForm[baseUrl]" value="0" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="help-block"></div>
                    </div>
                    <p class="help-block">Минимальные баллы: <?= $subject->minpoint; ?></p>
                    <hr>
                </div>
                <?php if (($i+1)%4 == 0): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <br>
            <div class="col-md-3 form-inline">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Расчитать', ['class' => 'click btn btn-primary']) ?>
                </div>
            </div>
        </form>
        <div id="okey"></div>
    </div>
</div>
<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UniversityModule.base','<strong>Калькулятор</strong> ЕГЭ' );?>
        </div>
    </div>
    <div class="page_info_wrap">
        <?= $text; ?>
        <p class="panel-heading">
            Оцените свои шансы!
        </p>
        <p class="help-block">
            Введите результаты ЕГЭ (реальные или предполагаемые) и оцените свои шансы на поступление в Чувашский государственный университет имени И.Н. Ульянова на очную форму обучения.
        </p>
        <br><hr>
        <form action="javascript::void();">
            <div class="row">
                <?php foreach($model as $subject):?>
                <div class="col-md-6">
                    <div class="form-group field-basicsettingsform-baseurl">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="basicsettingsform-baseurl"><?= $subject->name; ?></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="basicsettingsform-baseurl" class="form-control" name="BasicSettingsForm[baseUrl]" value="0" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="help-block"></div>
                    </div>
                    <p class="help-block">Минимальные баллы: <?= $subject->minpoint; ?></p>
                    <hr>
                </div>
                <?php if (($i+1)%4 == 0): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <br>
            <div class="col-md-3 form-inline">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Расчитать', ['class' => 'click btn btn-primary']) ?>
                </div>
            </div>
        </form>
        <div id="okey"></div>
    </div>
</div>
<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UniversityModule.base','<strong>Калькулятор</strong> ЕГЭ' );?>
        </div>
    </div>
    <div class="page_info_wrap">
        <?= $text; ?>
        <p class="panel-heading">
            Оцените свои шансы!
        </p>
        <p class="help-block">
            Введите результаты ЕГЭ (реальные или предполагаемые) и оцените свои шансы на поступление в Чувашский государственный университет имени И.Н. Ульянова на очную форму обучения.
        </p>
        <br><hr>
        <form action="javascript::void();">
            <div class="row">
                <?php foreach($model as $subject):?>
                <div class="col-md-6">
                    <div class="form-group field-basicsettingsform-baseurl">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="basicsettingsform-baseurl"><?= $subject->name; ?></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="basicsettingsform-baseurl" class="form-control" name="BasicSettingsForm[baseUrl]" value="0" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="help-block"></div>
                    </div>
                    <p class="help-block">Минимальные баллы: <?= $subject->minpoint; ?></p>
                    <hr>
                </div>
                <?php if (($i+1)%4 == 0): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <br>
            <div class="col-md-3 form-inline">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Расчитать', ['class' => 'click btn btn-primary']) ?>
                </div>
            </div>
        </form>
        <div id="okey"></div>
    </div>
</div>
<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UniversityModule.base','<strong>Калькулятор</strong> ЕГЭ' );?>
        </div>
    </div>
    <div class="page_info_wrap">
        <?= $text; ?>
        <p class="panel-heading">
            Оцените свои шансы!
        </p>
        <p class="help-block">
            Введите результаты ЕГЭ (реальные или предполагаемые) и оцените свои шансы на поступление в Чувашский государственный университет имени И.Н. Ульянова на очную форму обучения.
        </p>
        <br><hr>
        <form action="javascript::void();">
            <div class="row">
                <?php foreach($model as $subject):?>
                <div class="col-md-6">
                    <div class="form-group field-basicsettingsform-baseurl">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="basicsettingsform-baseurl"><?= $subject->name; ?></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="basicsettingsform-baseurl" class="form-control" name="BasicSettingsForm[baseUrl]" value="0" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="help-block"></div>
                    </div>
                    <p class="help-block">Минимальные баллы: <?= $subject->minpoint; ?></p>
                    <hr>
                </div>
                <?php if (($i+1)%4 == 0): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <br>
            <div class="col-md-3 form-inline">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Расчитать', ['class' => 'click btn btn-primary']) ?>
                </div>
            </div>
        </form>
        <div id="okey"></div>
    </div>
</div>
<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UniversityModule.base','<strong>Калькулятор</strong> ЕГЭ' );?>
        </div>
    </div>
    <div class="page_info_wrap">
        <?= $text; ?>
        <p class="panel-heading">
            Оцените свои шансы!
        </p>
        <p class="help-block">
            Введите результаты ЕГЭ (реальные или предполагаемые) и оцените свои шансы на поступление в Чувашский государственный университет имени И.Н. Ульянова на очную форму обучения.
        </p>
        <br><hr>
        <form action="javascript::void();">
            <div class="row">
                <?php foreach($model as $subject):?>
                <div class="col-md-6">
                    <div class="form-group field-basicsettingsform-baseurl">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="basicsettingsform-baseurl"><?= $subject->name; ?></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="basicsettingsform-baseurl" class="form-control" name="BasicSettingsForm[baseUrl]" value="0" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="help-block"></div>
                    </div>
                    <p class="help-block">Минимальные баллы: <?= $subject->minpoint; ?></p>
                    <hr>
                </div>
                <?php if (($i+1)%4 == 0): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <br>
            <div class="col-md-3 form-inline">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Расчитать', ['class' => 'click btn btn-primary']) ?>
                </div>
            </div>
        </form>
        <div id="okey"></div>
    </div>
</div>
<div class="page_block">
    <div class="page_block_header clear_fix">
        <div class="page_block_header_inner _header_inner">
            <?= Yii::t('UniversityModule.base','<strong>Калькулятор</strong> ЕГЭ' );?>
        </div>
    </div>
    <div class="page_info_wrap">
        <?= $text; ?>
        <p class="panel-heading">
            Оцените свои шансы!
        </p>
        <p class="help-block">
            Введите результаты ЕГЭ (реальные или предполагаемые) и оцените свои шансы на поступление в Чувашский государственный университет имени И.Н. Ульянова на очную форму обучения.
        </p>
        <br><hr>
        <form action="javascript::void();">
            <div class="row">
                <?php foreach($model as $subject):?>
                <div class="col-md-6">
                    <div class="form-group field-basicsettingsform-baseurl">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="basicsettingsform-baseurl"><?= $subject->name; ?></label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="basicsettingsform-baseurl" class="form-control" name="BasicSettingsForm[baseUrl]" value="0" aria-required="true" aria-invalid="false">
                            </div>
                        </div>
                        <div class="help-block"></div>
                    </div>
                    <p class="help-block">Минимальные баллы: <?= $subject->minpoint; ?></p>
                    <hr>
                </div>
                <?php if (($i+1)%4 == 0): ?>
            </div><div class="row">
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <br>
            <div class="col-md-3 form-inline">
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Расчитать', ['class' => 'click btn btn-primary']) ?>
                </div>
            </div>
        </form>
        <div id="okey"></div>
    </div>
</div>


