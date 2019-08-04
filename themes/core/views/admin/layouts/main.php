
<div class="row">
    <div class="col-md-9">
        <?= $content; ?>
    </div>
    <div class="col-md-3 col-no-right-padding">
        <?= \zikwall\easyonline\modules\admin\widgets\AdminMenu::widget(); ?>
    </div>
</div>

<script>
    $(function () {
        let adminSidebar = new StickySidebar('#adminsidebar', {
            containerSelector: '#main-container',
            topSpacing: 56,
            bottomSpacing: 545
        });
    })
</script>
