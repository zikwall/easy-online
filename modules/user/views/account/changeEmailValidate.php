<?php

use zikwall\easyonline\modules\core\components\compatibility\CHtml;

?>
<?php $this->beginContent('@user/views/account/_userProfileLayout.php') ?>
    <?= Yii::t('UserModule.views_account_changeEmailValidate', 'Your e-mail address has been successfully changed to {email}.', array('{email}' => CHtml::encode($newEmail))); ?>
<?php $this->endContent(); ?>

