<?php

/**
 * @var Kirby\Cms\Block $block
 */

?>
<?php	if ( $block->code()->isEmpty() ) return; ?>
<div class="block-embed <?= $class ?? '' ?>">
	<?= $block->code()->value() ?>
</div>
