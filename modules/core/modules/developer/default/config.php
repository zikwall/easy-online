<?= "<?php\n"; ?>
return [
	'id' => '<?= $generator->moduleID; ?>',
	'class' => 'app\modules\<?= $generator->moduleID; ?>\<?= $generator->getModuleClassName(); ?>',
	'namespace' => 'app\modules\<?= $generator->moduleID; ?>',
	'events' => [
		// toDo: generate events callbacks
	],
];
?>

