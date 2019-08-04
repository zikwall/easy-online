<?php
 /* @var $userMessages \zikwall\easyonline\modules\message\models\UserMessage[] */
?>

<?php if (count($userMessages) != 0) : ?>
    <?php foreach ($userMessages as $userMessage) : ?>
        <?= $this->render('_messagePreview', ['userMessage' => $userMessage, 'active' => 0]); ?>
    <?php endforeach; ?>
<?php else: ?>
    <li class="placeholder"> <?= Yii::t('MessageModule.views_mail_list', 'There are no messages yet.'); ?></li>
<?php endif; ?>
