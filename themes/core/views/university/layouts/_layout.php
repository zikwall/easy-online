<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \zikwall\easyonline\modules\user\models\User $contentContainer
 * @var $this zikwall\easyonline\components\View
 */

?>

<div class="row">
    <div class="col-md-8 layout-content-container">
        <?= $content; ?>
    </div>
    <div class="col-md-4 layout-sidebar-container col-no-right-padding">
        <div id="university-sidebar-container">
            <div class="university-sidebar">
                <?= \zikwall\easyonline\modules\university\widgets\Sidebar::widget([
                    'widgets' => [
                        [
                            \zikwall\easyonline\modules\university\widgets\AbiturientsMenu::class,
                        ],
                        [
                            \zikwall\easyonline\modules\university\widgets\StudentsMenu::class,
                        ],
                        [
                            \zikwall\easyonline\modules\university\widgets\DownSidebarMenu::class,
                        ],
                        [
                            \zikwall\easyonline\modules\university\widgets\SidebarMenu::class,
                        ],
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (1 === 1) {
            let studentMenu = new StickySidebar('#university-sidebar-container', {
                containerSelector: '#main-container',
                innerWrapperSelector: '.university-sidebar',
                topSpacing: 40,
                bottomSpacing: 5
            });
        }
    });
</script>

