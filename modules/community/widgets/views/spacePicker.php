<?php

use yii\helpers\Html;
use zikwall\easyonline\modules\community\widgets\Image;

$this->registerJsFile('@web-static/resources/community/communitypicker.js', ['position' => \yii\web\View::POS_END]);
?>

<?php
// Resolve guids to community tags
$selectedCommunitys = "";
foreach ($communitys as $community) {
    $name = Html::encode($community->name);
    $selectedCommunitys .= '<li class="communityInput" id="' . $community->guid . '">' . Image::widget(["community" => $community, "width" => 24]) . ' ' . addslashes($name) . '<i class="fa fa-times-circle"></i></li>';
}
?>

<script type="text/javascript">
    $(function () {
        $('#<?= $inputId; ?>').communitypicker({
            inputId: '#<?= $inputId; ?>',
            maxCommunitys: '<?= $maxCommunitys; ?>',
            searchUrl: '<?= $communitySearchUrl; ?>',
            currentValue: '<?= str_replace("\n", " \\", $selectedCommunitys); ?>',
            placeholder: '<?= Html::encode($placeholder); ?>'
        });
    });
</script>
