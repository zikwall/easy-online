<?= "<?php\n"; ?>

namespace app\modules\<?= $generator->moduleID; ?>\controllers;

class AdminController extends \app\modules\admin\components\Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \app\components\behaviors\AccessControl::class,
                'adminOnly' => true
            ]
        ];
    }

    /**
     * Render admin only page
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}

