<?php snippet('html', slots: true) ?>

	<?php	slot('body') ?>
		<body>
			<h1><?= $page->title() ?></h1>
		</body>
	<?php	endslot() ?>

<?php	endsnippet() ?>
