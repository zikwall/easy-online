<?= "<?php\n"; ?>

namespace app\modules\<?= $generator->moduleID; ?>;

use Yii;
use yii\helpers\Url;

/**
 * Basic event methods
 *
 */
class Events extends \yii\base\BaseObject
{

    /**
     * Defines what to do when the top menu is initialized.
     *
     * @param $event
     */
    public static function onTopMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => "<?= ucfirst($generator->moduleID); ?>",
            'icon' => '<i class="fa fa-certificate" style="color: #6fdbe8;"></i>',
            'url' => Url::to(['/<?= $generator->moduleID; ?>/default']),
            'sortOrder' => 99999,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == '<?= $generator->moduleID; ?>' && Yii::$app->controller->id == 'default'),
        ));
    }


    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => "<?= ucfirst($generator->moduleID); ?>",
            'url' => Url::to(['/<?= $generator->moduleID; ?>/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-certificate" style="color: #6fdbe8;"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == '<?= $generator->moduleID; ?>' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 99999,
        ));
    }

}

