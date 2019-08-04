<?php

use zikwall\easyonline\modules\user\widgets\PermissionGridEditor;
?>
<?php $this->beginContent('@zikwall/easyonline/modules/user/views/group/_manageLayout.php', ['group' => $group]) ?>
<div class="panel-body">
    <?= PermissionGridEditor::widget(['permissionManager' => Yii::$app->user->permissionManager, 'groupId' => $group->id, 'hideFixedPermissions' => false]); ?>
</div>
<?php $this->endContent(); ?>
