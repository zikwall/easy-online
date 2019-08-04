<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

use zikwall\easyonline\modules\translation\assets\MainAsset;

use zikwall\easyonline\modules\translation\libs\GoogleTranslate;

$bundle = MainAsset::register($this);

$this->registerCss('.loading-indicator {
	height: 80px;
	width: 80px;
    background: url( "'. $bundle->baseUrl .'/img/loading.gif" );
	background-repeat: no-repeat;
	background-position: center center;
}');

?>

<div class="row">
    <div class="col-md-12">
        <div class="page_block">
            <div class="page_block_header clear_fix">
                <div class="page_block_header_inner _header_inner">
                    <?= Yii::t('TranslationModule.views_translate_index', 'Translation Editor'); ?>
                </div>
            </div>

            <div class="page_info_wrap">
                <?php Pjax::begin(['id' => 'pjax']); ?>


                <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success alert-dismissable" id="succesSave">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button" timeout="1000">×</button>
                        <h5><i class="icon fa fa-check"></i>  Saved!</h5>
                    </div>
                    <?php $this->registerJs(
                        'setTimeout(function(){
                                    $("#succesSave").hide("slow");
                                }, 1000)') ?>
                <?php endif; ?>


                <?= Html::beginForm(Url::to(['/translation/translate']), 'POST', ['data-pjax' => true, 'id' => 'form']); ?>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="">Module</label>
                        <?= Html::dropDownList('moduleId', $moduleId, $moduleIds, ['class' => 'form-control', 'onChange' => 'selectOptions()']); ?>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Language</label>
                        <?= Html::dropDownList('language', $language, $languages, ['class' => 'form-control', 'onChange' => 'selectOptions()']); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">File</label>
                        <?= Html::dropDownList('file', $file, $files, ['class' => 'form-control', 'onChange' => 'selectOptions()']); ?>
                    </div>

                    <?= Html::input('hidden', 'saveForm', 1)?>

                </div>
                <hr>
                <span style='color:red'>Save before change!</span>

                <?php $i = 0; ?>
                <p>
                    Интернационализация (I18N) является частью процесса разработки приложения, которое может быть адаптировано для нескольких языков без изменения программной логики. Это особенно важно для веб-приложений, так как потенциальные пользователи могут приходить из разных стран.
                    <br/>
                    <br/>
                    больше инфорации <a
                        href="http://www.yiiframework.com/doc-2.0/guide-tutorial-i18n.html">Yii Framework Guide I18n</a>.
                </p>

                <div class="panel-body">
                    <p style="float: right">
                        <?= Html::textInput("search", null, ["class" => "form-control form-search", "placeholder" => 'Search']); // Yii::t('TranslationModule.views_translate_index', 'Search') ?>
                    </p>

                    <p><?= Html::submitButton(Yii::t('TranslationModule.views_translate_index', 'Save'), ['class' => 'btn btn-primary', 'id' => 'submitPjax']); ?></p>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <div class="elem">Оригинал (en)</div>
                            <div class="elem">
                                Translated (<?php echo $language; ?>)
                                <button type="button" class="btn btn-success btn-sm btn_copy_suggested_2_empty">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                    <?php
                                    //ioxoi
                                    echo Yii::t('TranslationModule.views_translate_index', 'Запонить все пустые поля переводом');
                                    ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="words">

                            <?php

                            //ioxoi
                            $trans = new GoogleTranslate();

                            foreach ($messages as $orginal => $translated) : ?>
                                <div class="row ">
                                    <?php $i++; ?>
                                    <div class="elem">
                                        <div class="pre"><?php print Html::encode($orginal); ?></div>
                                    </div>
                                    <div class="elem">
                                        <?php echo Html::textArea('tid_' . md5($orginal), $translated, array('class' => 'form-control')); ?>
                                        <br>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-info btn-sm btn_copy_suggested"
                                                    data-translation="<?php echo 'tid_' . md5($orginal); ?>"
                                                    data-suggested="<?php echo 'suggested_' . md5($orginal); ?>"
                                            >
                                                <i class="fa fa-clone" aria-hidden="true"></i>
                                                <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                                <?php
                                                //ioxoi
                                                echo Yii::t('TranslationModule.views_translate_index', 'Заполнить переводом');
                                                ?>
                                            </button>
                                        </div>
                                        <?php

                                        //ioxoi
                                        echo Yii::t('TranslationModule.views_translate_index', 'Предлагаемый перевод:');

                                        //ioxoi
                                        $source = 'en';
                                        $target = $language;//es';
                                        $text = $orginal;

                                        //
                                        //	CHANGE & SAVE tags
                                        //
                                        //////////////////////////////////////////////////////////////////////////////////////
                                        //macth all tags (i loer and uper case m all as single line s include all)
                                        //preg_match_all('/<.[^>]*>/ims', $text, $matches, PREG_PATTERN_ORDER);
                                        preg_match_all('/<.[^>]*>/', $text, $matches_tags, PREG_PATTERN_ORDER);

                                        //replace it by a code number
                                        for ($i = 0; $i < count($matches_tags[0]); $i++)
                                        {
                                            $found =  (string)$matches_tags[0][$i];
                                            $replacement = '[#t_'. (string)$i .'#]';

                                            $text = str_replace( $found, $replacement, $text);
                                            //$text = preg_replace( (string)$matches_tags[0][$i], '[#t_'. (string)$i .'#]', $text, 1);

                                        };//for




                                        //
                                        //	CHANGE & SAVE Yii markup
                                        //
                                        //////////////////////////////////////////////////////////////////////////////////////
                                        preg_match_all('/{.[^}]*}/', $text, $matches_yii_1, PREG_PATTERN_ORDER);

                                        //replace it by a code number
                                        for ($i = 0; $i < count($matches_yii_1[0]); $i++)
                                        {
                                            $found =  (string)$matches_yii_1[0][$i];
                                            $replacement = '[#y1_'. (string)$i .'#]';

                                            $text = str_replace( $found, $replacement, $text);

                                        };//for



                                        // Macth all %text% but NOT  %text or text%  or % text
                                        preg_match_all('/%.[^%s]*%/', $text, $matches_yii_2, PREG_PATTERN_ORDER);

                                        //replace it by a code number
                                        for ($i = 0; $i < count($matches_yii_2[0]); $i++)
                                        {
                                            $found =  (string)$matches_yii_2[0][$i];
                                            $replacement = '[#y2_'. (string)$i .'#]';

                                            $text = str_replace( $found, $replacement, $text);

                                        };//for




                                        //
                                        //	CHANGE & SAVE old/depreciated '@@'
                                        //
                                        //////////////////////////////////////////////////////////////////////////////////////
                                        preg_match_all('/@.[^@s]*@/', $text, $matches_old, PREG_PATTERN_ORDER);

                                        //replace it by a code number
                                        for ($i = 0; $i < count($matches_old[0]); $i++)
                                        {
                                            $found =  (string)$matches_old[0][$i];
                                            $replacement = '[#old_'. (string)$i .'#]';

                                            $text = str_replace( $found, $replacement, $text);

                                        };//for



                                        /*
                                        //DEBUG
                                        echo '<textarea class="form-control">';
                                        echo "\n-------------------\n";
                                        for ($i = 0; $i < count($matches_tags[0]); $i++) {	echo $matches_tags[0][$i] ."\n"; };
                                        echo "\n-------------------\n";
                                        for ($i = 0; $i < count($matches_yii_1[0]); $i++) {	echo $matches_yii_1[0][$i] ."\n"; };
                                        echo "\n-------------------\n";
                                        for ($i = 0; $i < count($matches_yii_2[0]); $i++) {	echo $matches_yii_2[0][$i] ."\n"; };
                                        echo "\n-------------------\n";
                                        for ($i = 0; $i < count($matches_old[0]); $i++) {echo $matches_old[0][$i] ."\n"; };
                                        echo "\n-------------------\n";

                                        echo "</textarea>";
                                        */



                                        //
                                        //	TRANSALAE
                                        //
                                        //////////////////////////////////////////////////////////////////////////////////////

                                        $result = $trans->translate($source, $target, $text);


                                        //
                                        //	RESTORE HTML tags
                                        //
                                        //////////////////////////////////////////////////////////////////////////////////////

                                        //try to fix broken tags by trasnlation
                                        $result = str_replace('[# ', '[#', $result);
                                        $result = str_replace(' #]', '#]', $result);
                                        $result = str_replace('[#T_', '[#t_', $result);


                                        for ($i = 0; $i < count($matches_tags[0]); $i++)
                                        {
                                            //Debug
                                            //echo $matches_tags[0][$i];
                                            $found =  (string)$matches_tags[0][$i];
                                            $replacement = '[#t_'. (string)$i .'#]';

                                            $result = str_replace( $replacement, $found, $result);
                                            //$result = preg_replace( '[#t_'. (string)$i .'#]', (string)$matches_tags[0][$i], $text, 1);

                                        };//for


                                        //
                                        //	RESTORE Yii markup
                                        //
                                        //////////////////////////////////////////////////////////////////////////////////////

                                        //try to fix broken tags by trasnlation
                                        $result = str_replace('[#Y1_', '[#y1_', $result);


                                        for ($i = 0; $i < count($matches_yii_1[0]); $i++)
                                        {
                                            //Debug
                                            //echo $matches_yii_1[0][$i];
                                            $found =  (string)$matches_yii_1[0][$i];
                                            $replacement = '[#y1_'. (string)$i .'#]';

                                            $result = str_replace( $replacement, $found, $result);


                                        };//for

                                        //try to fix broken tags by trasnlation
                                        $result = str_replace('[#Y2_', '[#y2_', $result);


                                        for ($i = 0; $i < count($matches_yii_2[0]); $i++)
                                        {
                                            //Debug
                                            //echo $matches_yii_2[0][$i];
                                            $found =  (string)$matches_yii_2[0][$i];
                                            $replacement = '[#y2_'. (string)$i .'#]';

                                            $result = str_replace( $replacement, $found, $result);


                                        };//for


                                        //
                                        //	RESTORE old/depreciated '@@'
                                        //
                                        //////////////////////////////////////////////////////////////////////////////////////

                                        //try to fix broken tags by trasnlation
                                        $result = str_replace('[#Old_', '[#old_', $result);


                                        for ($i = 0; $i < count($matches_old[0]); $i++)
                                        {
                                            //Debug
                                            //echo $matches_old[0][$i];
                                            $found =  (string)$matches_old[0][$i];
                                            $replacement = '[#old_'. (string)$i .'#]';

                                            $result = str_replace( $replacement, $found, $result);


                                        };//for



                                        //echo $result;

                                        echo Html::textArea('suggested_' . md5($orginal), $result, array('class' => 'form-control'));
                                        ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>

                <hr>

                <p><?= Html::submitButton(Yii::t('TranslationModule.views_translate_index', 'Save'), ['class' => 'btn btn-primary']); ?></p>

                <?= Html::endForm(); ?>

                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
