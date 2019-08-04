<?php

/**
 * @var $this \zikwall\easyonline\modules\core\components\base\View
 */
use zikwall\easyonline\modules\user\models\User;
use \yii\helpers\Html;

$this->registerJsFile("@web/js/highlight.min.js");
$this->registerJsFile("@web/js/userPicker.js");

$newValue = "";

foreach (explode(",", $currentValue) as $guid) {
    $user = User::findOne(['guid' => trim($guid)]);
    if ($user != null) {
        $name = Html::encode($user->displayName);
        $newValue .= '<li class="userInput" id="' . $user->guid . '">' . $name . '<i class="fa fa-times-circle"></i></li>';
    }
}

?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#<?= $inputId; ?>').userpicker({
            inputId: '#<?= $inputId; ?>',
            maxUsers: '<?= $maxUsers; ?>',
            searchUrl: '<?= $userSearchUrl; ?>',
            currentValue: '<?= $newValue; ?>',
            focus: '<?= $focus; ?>',
            userGuid: '<?= $userGuid; ?>',
            data: <?= $data ?>,
            placeholderText: '<?= $placeholderText; ?>'
        });
    });
</script>
