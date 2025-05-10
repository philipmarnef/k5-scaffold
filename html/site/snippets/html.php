<?php

	use Kirby\Toolkit\Html;
	use Bnomei\Fingerprint; 

	$lang = $kirby->currentLanguage()->locale(LC_ALL) ?? 'en-UK';
	$lang = str_replace('_', '-', $lang);
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">

	<head>

		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<?php if ( $_SERVER['HTTP_HOST'] !== 'k4-scaffold.test' ) { ?>

			<meta name="robots" content="noindex,nofollow,noodp">
			<title><?= $site->title() ?></title>

		<?php } else { ?>

			<?= snippet('seo') ?>

		<?php } ?>

		<link href="<?= $page->url() ?>" rel="canonical">

		<?php if ( !$page->isHomePage() ) { ?>

			<link href="<?= $site->homePage()->url() ?>" rel="home">

		<?php } ?>

		<?php if ( $kirby->multilang() ) { ?>

			<?php	foreach ( $kirby->languages() as $language ) { ?>

				<?php	
					$href = $page->url($language->code());
					$lang = $language->code();
				?>

				<?= Html::tag('link', null, [
						'href' => $href,
						'rel' => 'alternate',
						'hreflang' => $lang,
				]); ?>

				<?php if ( $language->isDefault() ) { ?>

					<?= Html::tag( 'link', null, [
						'href' => $href,
						'rel' => 'alternate',
						'hreflang' => 'x-default',
					] ); ?>

				<?php } ?>

			<?php } ?>

		<?php } ?>

		<?= Fingerprint::css('assets/css/main.css') ?>
		<?= Fingerprint::js('assets/js/main.js') ?>

		<?= $slots?->head() ?? '' ?>

	</head>

	<?= $slots?->body() ?? '<body></body>' ?>

</html>
