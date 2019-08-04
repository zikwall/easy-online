<?= $this->render('@easyonline/themes/core/views/schedule/public/_scheduleTop', [
    'group' => $group
]); ?>

<?= $table->render();?>

<script>
    window.sidebarEnabled = false;
</script>
