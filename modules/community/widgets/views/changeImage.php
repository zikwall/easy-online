<div class="panel panel-default">
    <div class="panel-heading"><?= Yii::t('CommunityModule.widgets_views_changeImage', 'Current community image'); ?></div>
    <div class="panel-body">
        <img src="<?= $this->getController()->getCommunity()->getProfileImage()->getUrl(); ?>" alt=""/><br><br>
        <?= CHtml::link(Yii::t('CommunityModule.widgets_views_changeImage', "Change image"), $this->createUrl('//community/admin/changeImage', array('sguid' => $this->getController()->getCommunity()->guid)), array('class' => 'btn btn-primary')); ?>

    </div>
</div>
<br/>
