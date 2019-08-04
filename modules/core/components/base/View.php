<?php

namespace zikwall\easyonline\modules\core\components\base;

use Yii;
use yii\helpers\Html;
use zikwall\easyonline\modules\core\widgets\CoreJsConfig;
use zikwall\easyonline\modules\core\widgets\LayoutAddons;

/**
 * @inheritdoc
 */
class View extends \yii\web\View
{
    public function init()
    {
        parent::init();
    }

    /**
     * @var string
     */
    private $_pageTitle;

    /**
     * Сохраняет все javascript-конфигурации, которые будут добавлены к представлению.
     * @see View::endBody
     * @var []
     */
    private $jsConfig = [];

    /**
     * Метод устанавливает заголовок к текущей странице
     */
    public function setPageTitle(string $title)
    {
        $this->_pageTitle = $title;
    }

    /**
     * Метод возвращает текущий заголовок
     */
    public function getPageTitle() : string
    {
        return (($this->_pageTitle) ? $this->_pageTitle . " - " : '') . Yii::$app->name;
    }

    /**
     * Регистрирует переменную Javascript
     *
     * @param string $name
     * @param string $value
     */
    public function registerJsVar($name, $value, $position = self::POS_HEAD)
    {
        $jsCode = "var " . $name . " = '" . addslashes($value) . "';\n";
        $this->registerJs($jsCode, $position, $name);
    }

    /**
     * Метод регистрирует конфигурацию Js
     *
     * @param $module
     * @param null $params
     */
    public function registerJsConfig($module, $params = null)
    {
        if (is_array($module)) {
            foreach ($module as $moduleId => $value) {
                $this->registerJsConfig($moduleId, $value);
            }
            return;
        }

        if (isset($this->jsConfig[$module])) {
            $this->jsConfig[$module] = yii\helpers\ArrayHelper::merge($this->jsConfig[$module], $params);
        } else {
            $this->jsConfig[$module] = $params;
        }
    }

    /**
     * Регистриует ресурсы по Ajax запросу
     *
     * @param string $content
     * @return string Rendered content
     */
    public function renderAjaxContent($content)
    {
        ob_start();
        ob_implicit_flush(false);

        $this->beginPage();
        $this->head();
        $this->beginBody();
        echo $content;
        $this->unregisterAjaxAssets();
        $this->endBody();
        $this->endPage(true);

        return ob_get_clean();
    }

    /**
     * @inheritdoc
     */
    public function renderAjax($view, $params = [], $context = null)
    {
        $viewFile = $this->findViewFile($view, $context);

        ob_start();
        ob_implicit_flush(false);

        $this->beginPage();
        $this->head();
        $this->beginBody();
        echo $this->renderFile($viewFile, $params, $context);
        $this->unregisterAjaxAssets();
        $this->endBody();

        $this->endPage(true);

        return ob_get_clean();
    }

    /**
     * Унифицирует стандартные ресурсы по запросам ajax.
     */
    protected function unregisterAjaxAssets()
    {
        unset($this->assetBundles['yii\bootstrap\BootstrapAsset']);
        unset($this->assetBundles['yii\web\JqueryAsset']);
        unset($this->assetBundles['yii\web\YiiAsset']);
        unset($this->assetBundles['all']);
    }

    /**
     * @inheritdoc
     */
    public function registerJsFile($url, $options = [], $key = null)
    {
        parent::registerJsFile($this->addCacheBustQuery($url), $options, $key);
    }

    /**
     * @inheritdoc
     */
    public function registerCssFile($url, $options = [], $key = null)
    {
        parent::registerCssFile($this->addCacheBustQuery($url), $options, $key);
    }

    /**
     * Добавляет строку запроса bust запроса к указанному URL-адресу, если запрос отсутствует
     */
    protected function addCacheBustQuery(string $url) : string
    {
        if (strpos($url, '?') === false) {
            $file = str_replace('@web', '@webroot', $url);
            $file = Yii::getAlias($file);

            if (file_exists($file)) {
                $url .= '?v=' . filemtime($file);
            } else {
                $url .= '?v=' . urlencode(Yii::$app->version);
            }
        }

        return $url;
    }

    /**
     * @inheritdoc
     */
    protected function renderHeadHtml()
    {
        return (!Yii::$app->request->isAjax) ? Html::csrfMetaTags() . parent::renderHeadHtml() : parent::renderHeadHtml();
    }

    public function setStatusMessage($type, $message)
    {
        Yii::$app->getSession()->setFlash('view-status', [$type => $message]);
    }

    public function saved()
    {
        $this->success(Yii::t('base', 'Saved'));
    }

    public function info($message)
    {
        $this->setStatusMessage('info', $message);
    }

    public function success($message)
    {
        $this->setStatusMessage('success', $message);
    }

    public function error($message)
    {
        $this->setStatusMessage('error', $message);
    }

    public function warn($message)
    {
        $this->setStatusMessage('warn', $message);
    }

    /**
     * Переопределение метода View::endBody()
     */
    public function endBody()
    {
        // Flush jsConfig необходим для всех типов запросов (включая pjax / ajax)
        $this->flushJsConfig();
        // В случае pjax мы должны добавить заголовок вручную, pjax удалит этот узел
        if (Yii::$app->request->isPjax) {
            echo '<title>' . $this->getPageTitle() . '</title>';
        }
        if (Yii::$app->params['installed']) {
            if (Yii::$app->getSession()->hasFlash('view-status')) {
                $viewStatus = Yii::$app->getSession()->getFlash('view-status');
                $type = strtolower(key($viewStatus));
                $value = Html::encode(array_values($viewStatus)[0]);
                $this->registerJs('encore.modules.ui.status.' . $type . '("' . $value . '")', View::POS_END, 'viewStatusMessage');
            }
            if (Yii::$app->session->hasFlash('executeJavascript')) {
                $position = self::POS_READY;
                if (Yii::$app->session->hasFlash('executeJavascriptPosition')) {
                    $position = Yii::$app->session->hasFlash('executeJavascriptPosition');
                }
                $this->registerJs(Yii::$app->session->getFlash('executeJavascript'));
            }
        }
        if (Yii::$app->request->isPjax) {
            echo LayoutAddons::widget();
            $this->flushJsConfig();
        }
        if (Yii::$app->request->isAjax) {
            return parent::endBody();
        }
        // Поскольку JsConfig обращается к пользовательским запросам, он не выполняется перед установкой.
        if (Yii::$app->params['installed']) {
            CoreJsConfig::widget();
        }

        // Добавить LayoutAddons и jsConfig, зарегистрированные аддонами
        echo LayoutAddons::widget();
        $this->flushJsConfig();
        return parent::endBody();
    }

    /**
     * Записывает зарегистрированные записи jsConfig и сбрасывает конфигурационный массив.
     */
    protected function flushJsConfig($key = null)
    {
        if (!empty($this->jsConfig)) {
            $this->registerJs("encore.config.set(" . json_encode($this->jsConfig) . ");", View::POS_BEGIN, $key);
            $this->jsConfig = [];
        }
    }

}
