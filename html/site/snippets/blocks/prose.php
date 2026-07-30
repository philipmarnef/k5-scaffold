<?php

/**
 * @var Kirby\Cms\Block $block
 */

?>
<?php if ( $block->text()->isEmpty() ) return; ?>
<div class="block-prose prose <?= $class ?? '' ?>"">
	<?= $block->text()->kt() ?>
</div>
