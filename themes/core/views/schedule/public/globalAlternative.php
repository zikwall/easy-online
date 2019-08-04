<?php
/**
 * Created by PhpStorm.
 * User: 123
 * Date: 13.03.2018
 * Time: 20:40
 */

$this->registerCss('
.center{text-align: center; vertical-align: middle;}
.topright { position: absolute; top: 5px; right: 5px; text-align: right; }
'
);

use zikwall\easyonline\modules\core\libs\Html;

?>

<?= $this->render('@easyonline/themes/core/views/schedule/public/_scheduleTop', [
        'group' => $group
]); ?>

<?= $table->render();?>

<script>
    window.sidebarEnabled = false;
</script>




